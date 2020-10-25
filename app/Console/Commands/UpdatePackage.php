<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Package;

class UpdatePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:update {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest information about a package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $package = Package::firstOrCreate(['name' => $this->argument('name')]);
        $package->updateFromNpm();
        $package->updateFromGitHub();
    }
}
