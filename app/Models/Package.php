<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Laravel\Scout\Searchable;
use GrahamCampbell\GitHub\Facades\GitHub;

class Package extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    /**
     * Get the GitHub Issues for the package.
     */
    public function githubIssues()
    {
        return $this->hasMany('App\Models\GithubIssue');
    }

    /**
     * Get only closed GitHub Issues for the package.
     */
    public function closedGithubIssues()
    {
        return $this->hasMany('App\Models\GithubIssue')->where('state', 'closed');
    }

    /**
     * Get only open GitHub Issues for the package.
     */
    public function openGithubIssues()
    {
        return $this->hasMany('App\Models\GithubIssue')->where('state', 'open');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        return $array;
    }

    /**
     * Fetch data from npm and GitHub APIs if out of date
     */
    public function sync()
    {
        $today = new Carbon;

        if ($this->npm_synced_at !== null)
        {
            $npm_synced_at = Carbon::createFromFormat('Y-m-d H:s:i', $this->npm_synced_at);
            // If the package hasn't been synced for over 24 hours
            if ($today->diffInHours($npm_synced_at) > 24)
            {
                $this->updateFromNpm();
            }
        }
        else
        {
            $this->updateFromNpm();
        }

        if ($this->github_synced_at !== null)
        {
            $github_synced_at = Carbon::createFromFormat('Y-m-d H:s:i', $this->github_synced_at);
            // If the github repo hasn't been synced for over 6 hours
            if ($today->diffInHours($github_synced_at) > 6)
            {
                $this->updateFromGithub();
            }
        }
        else
        {
            $this->updateFromGithub();
        }
    }

    /**
     * Fetch data about the package from the npm API
     */
    public function updateFromNpm()
    {
        $package_name = $this->name;

        $api_url = 'https://api.npms.io/v2/package/';

        // urlencode required because of '@' and '/' characters
        $response = Http::get($api_url . urlencode($package_name));

        $data = json_decode($response);

        if ($response->status() === 200)
        {
            $metadata = $data->collected->metadata;

            $this->description = $metadata->description;
            $this->homepage_url = isset($data->collected->github->homepage)
                ? $data->collected->github->homepage
                : (isset($metadata->links->homepage) ? $metadata->links->homepage : NULL);
            $this->repo = extractGitHubRepoFromUrl($metadata->repository->url);
        }

        $this->npm_synced_at = now();

        $this->save();
    }

    /**
     * Fetch data about the package from its GitHub repo
     */
    public function updateFromGitHub()
    {
        $repo = $this->repo;

        if ($repo !== null)
        {
            try
            {
                $data = GitHub::search()->issues('accessibility repo:' . $repo . ' type:issue');
            }
            catch (\Github\Exception\ValidationFailedException $e)
            {
                // The search end point may error if a user moves a repo but
                // doesn't update npm. Check the repo end point to see if it has
                // moved
                list($user_name, $repo_name) = explode('/', $repo);
                $repo_data = GitHub::repo()->show($user_name, $repo_name);

                if ($repo_data['full_name'] !== $repo)
                {
                    $this->repo = $repo_data['full_name'];
                }

                // Search again
                $data = GitHub::search()->issues('accessibility repo:' . $repo_data['full_name'] . ' type:issue');
            }

            $issues = $data['items'];

            foreach ($issues as $issue)
            {
                GithubIssue::updateOrCreate(
                    [
                        'url' => $issue['html_url']
                    ],
                    [
                        'package_id' => $this->id,
                        'title' => $issue['title'],
                        'state' => $issue['state'],
                        'issue_created_at' => date('Y-m-d H:i:s', strtotime($issue['created_at'])),
                    ]
                );
            }
        }

        $this->github_synced_at = now();
        $this->save();
    }
}
