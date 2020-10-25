<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $json = Storage::disk('local')->get('npm_packages.json');
        $data = json_decode($json);

        foreach ($data as $item) {
            Package::firstOrCreate((array) $item);
        }
    }
}
