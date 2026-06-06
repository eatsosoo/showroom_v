<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Vehicle;
use App\Models\VehicleCategory;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'title' => 'app.pages.admin_dashboard',
            'stats' => [
                'vehicles' => Vehicle::count(),
                'vehicleCategories' => VehicleCategory::count(),
                'posts' => Post::count(),
                'banners' => Banner::count(),
                'newLeads' => Lead::where('status', 'new')->count(),
            ],
        ]);
    }
}
