<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductsVariants;
use App\Models\Photo;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('faculty', 'type')->get();
        return response()->json($products, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    /** 
    * Display 10 items of the resource. 
    * 
    * @return \Illuminate\Http\Response 
    */ 
    public function paginate($count) 
    { 
    $count = $count - 1; 
    $products = Product::offset($count*6)->limit(6)->get(); 
    return response()->json($products, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        Product::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'faculty_id' => $validated['faculty_id'],
            'type_id' => $validated['type_id'],
        ]);
        return response()->json([
            'message' => 'Успешно добавлено! (я пришел с сервера)',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('faculty', 'type')->where('id', '=', $id)->get();
        return response()->json($product, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(ProductsVariants::where('product_id', $id)->first() || Photo::where('product_id', $id)->first() || Comment::where('product_id', $id)->first()) {
            return response()->json([
                'message' => 'Товар номер '.$id.' не получилось удалить. Существует конкретный товар на данное наименование.',
            ]);
        }
        Product::destroy($id);
        return response()->json([
            'message' => 'Товар номер '.$id.' удален успешно (я пришел с сервера)',
        ]);
    }
}
