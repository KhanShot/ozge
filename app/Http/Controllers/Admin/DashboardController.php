<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        $data['prizes'] = Products::query()->count();
        $data['spins'] = Clients::query()->sum('is_used');
        $data['clients'] = Clients::query()->count();

        $data['list'] = Products::query()
            ->leftJoin('clients', 'products.id', '=', 'clients.product_id')
            ->select([
                'products.id as product_id',
                'products.name as product_name',
                DB::raw('COUNT(clients.product_id) as clients_today')
            ])
            ->whereDate('clients.used_date', $request->get('date'))  // You can use a dynamic date here
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('clients_today')
            ->get();



        return view('admin.pages.dashboard', compact('data'));
    }
}
