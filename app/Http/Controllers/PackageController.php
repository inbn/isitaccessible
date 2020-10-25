<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Jobs\UpdatePackage;

class PackageController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  string  $name
     * @return \Illuminate\View\View
     */
    public function show($name)
    {
        $package = Package::firstOrCreate(['name' => $name]);

        UpdatePackage::dispatch($package);

        return view('package.show', ['package' => $package]);
    }
}
