<?php

namespace App\Jobs;

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePackage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $package;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Package $package)
    {
        //
        $this->package = $package;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = new Carbon;

        if ($this->package->npm_synced_at !== null)
        {
            $npm_synced_at = Carbon::createFromFormat('Y-m-d H:s:i', $this->package->npm_synced_at);
            // If the package hasn't been synced for over 24 hours
            if ($today->diffInHours($npm_synced_at) > 24)
            {
                $this->package->updateFromNpm();
            }
        }
        else
        {
            $this->package->updateFromNpm();
        }

        if ($this->package->github_synced_at !== null)
        {
            $github_synced_at = Carbon::createFromFormat('Y-m-d H:s:i', $this->package->github_synced_at);
            // If the github repo hasn't been synced for over 6 hours
            if ($today->diffInHours($github_synced_at) > 6)
            {
                $this->package->updateFromGithub();
            }
        }
        else
        {
            $this->package->updateFromGithub();
        }
    }
}
