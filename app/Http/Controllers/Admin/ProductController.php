<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::query()->withCount('clients')->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $probability = Products::query()->where('is_active', 1)->sum('probability');
        return view('admin.products.create', compact('probability'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $probability = Products::query()->where('is_active', 1)->sum('probability');
        if ($probability+$request->probability> 100)
            return redirect()->back()->with('error', "Вероятность превышает  100%, сейчас " . $probability + $request->probability);
        $data = $request->all();
        if ($request->hasFile("image")){
            $path = "/assets/prizes";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }
        Products::query()->create($data);
        return redirect()->route('prizes.index')->with('message', 'Приз успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $probability = Products::query()->where('is_active', 1)->sum('probability');
        $product = Products::query()->findOrFail($id);
        return view('admin.products.edit', compact('product', 'probability'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $probability = Products::query()->where('is_active', 1)->sum('probability');
        $product = Products::query()->findOrFail($id);
        $sum = $probability - $product->probability + $request->probability;
        if ( $sum > 100)
            return redirect()->back()->with('error', "Вероятность превышает  100%, сейчас " . $sum);
        $data = $request->all();

        if ($request->hasFile("image")){
            $path = "/assets/prizes";
            Storage::delete('public'.$product->image);
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }
        $product->update($data);
        return redirect()->route('prizes.index')->with('success', 'Приз успешно обнавлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::query()->findOrFail($id);
        $product->delete();
        return redirect()->route('prizes.index')->with('success', 'Приз удален!');
    }
}
