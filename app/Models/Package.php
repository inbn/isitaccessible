<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use GrahamCampbell\GitHub\Facades\GitHub;

class Package extends Model
{
    use HasFactory;

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
     * Fetch data about the package from the npm API
     */
    public function updateFromNpm()
    {
        $package_name = $this->name;

        // We could use the npm view command to retrieve data about the package
        // $json = shell_exec('npm view '. $package_name . ' -json 2>&1');
        // $data = json_decode($json);

        // var_dump($json);

        // // If the package doesn't exist, delete this record
        // if (isset($data->error->code) && $data->error->code === 'E404')
        // {
        //     $this->delete();
        //     return;
        // }

        $apiUrl = 'https://api.npms.io/v2/package/';

        // But let's use the npms.io api instead
        // urlencode required because of '@' and '/' characters
        $response = Http::get($apiUrl . urlencode($package_name));

        $data = json_decode($response);
        $metadata = $data->collected->metadata;

        $this->description = $metadata->description;
        $this->homepage_url = isset($data->collected->github->homepage)
            ? $data->collected->github->homepage
            : (isset($metadata->links->homepage) ? $metadata->links->homepage : NULL);
        $this->repo = extractGitHubRepoFromUrl($metadata->repository->url);
        $this->npm_synced_at = now();

        $this->save();
    }

    /**
     * Fetch data about the package from its GitHub repo
     */
    public function updateFromGitHub()
    {
        // If date is newer than 1 hour, return
        $repo = $this->repo;

        // TODO search API does not account for redirects. e.g. if a user moves
        // repo but doesn't update npm. Come up with a solution for this
        $data = GitHub::search()->issues('accessibility repo:' . $repo . ' type:issue');
        $issues = $data['items'];

        foreach ($issues as $issue) {
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

        $this->github_synced_at = now();
        $this->save();
    }
}
