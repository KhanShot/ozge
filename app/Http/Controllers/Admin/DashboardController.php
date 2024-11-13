<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Products;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['prizes'] = Products::query()->count();
        $data['spins'] = Clients::query()->sum('is_used');
        $data['clients'] = Clients::query()->count();
        return view('admin.pages.dashboard', compact('data'));
    }
}
