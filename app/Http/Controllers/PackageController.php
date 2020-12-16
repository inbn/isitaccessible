<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Jobs\UpdatePackage;

class PackageController extends Controller
{
    /**
     * Show the detail page for the given Package
     *
     * @param  string  $name
     * @return \Illuminate\View\View
     */
    public function show($name)
    {
        $package = Package::firstOrCreate(['name' => $name]);

        $package->sync();
        if (!$package->npm_sync_success)
        {
            abort(404, 'Couldn’t find that package on npm');
        }
        if (!$package->repo)
        {
            abort(404, 'Couldn’t find GitHub info for that package');
        }

        return view('package.show', ['package' => $package]);
    }
}
