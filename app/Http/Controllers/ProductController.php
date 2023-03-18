<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
        $products = product::all();
        return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'product_name' => 'required|max:255|unique:products,product_name,'.$id,
            'section_id'=>'required|exists:sections,id',
            'description' => 'required',
        ],[

            'product_name.required'=>'يرجى ادخال اسم المنج',
            'product_name.unique'=>'اسم المنتج مسجل مسبقا',
            'section_id.required'=>'ادخال القسم مطلوب',
            'description.required'=>'يرجى ادخال البيان',
        ]);

        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = section::where('section_name', $request->section_name)->first()->id;

        $Products = Product::findOrFail($request->pro_id);

        $Products->update([
        'product_name' => $request->product_name,
        'description' => $request->description,
        'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $Products = Product::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();

    }
}
