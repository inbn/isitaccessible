<?php

namespace App\Jobs;

use App\Models\Package;
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
        // To stop going over the 30 requests per minute rate limit for the
        // GitHub search endpoint, we wait 2 seconds between jobs
        sleep(2);
        $this->package->sync();
    }
}
