<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use File;
use Storage;

use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Seed some packages
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/npm_packages.json');
        $data = json_decode($json);

        foreach ($data as $item) {
            Package::firstOrCreate((array) $item);
        }
    }
}
