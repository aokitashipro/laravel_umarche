<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Shop;
use App\Models\PrimaryCategory;
use App\Models\Owner;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('product'); 
            if(!is_null($id)){ 
            $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
                $productId = (int)$productsOwnerId; 
                if($productId !== Auth::id()){ 
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        // EagerLoadingなし
        //$products = Owner::findOrFail(Auth::id())->shop->product;
        
        $ownerInfo = Owner::with('shop.product.imageFirst')
        ->where('id', Auth::id())->get();

        // dd($ownerInfo);
        // foreach($ownerInfo as $owner){
        // //    dd($owner->shop->product);
        //     foreach($owner->shop->product as $product){
        //         dd($product->imageFirst->filename);
        //     }
        // }

        return view('owner.products.index',
        compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')
        ->get();

        $images = Image::where('owner_id', Auth::id())
        ->select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return view('owner.products.create', 
            compact('shops', 'images', 'categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        try{
            DB::transaction(function () use($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sort_order' => $request->sort_order,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity
                ]);
            }, 2);
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return redirect()
        ->route('owner.products.index')
        ->with(['message' => '商品登録しました。',
        'status' => 'info']);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');

        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')
        ->get();

        $images = Image::where('owner_id', Auth::id())
        ->select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return view('owner.products.edit',
            compact('product', 'quantity', 'shops', 
            'images', 'categories'));
    }

    public function update(ProductRequest $request, $id)
    {
        $request->validate([
            'current_quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');

        if($request->current_quantity !== $quantity){
            $id = $request->route()->parameter('product');
            return redirect()->route('owner.products.edit', [ 'product' => $id])
            ->with(['message' => '在庫数が変更されています。再度確認してください。',
                'status' => 'alert']);            

        } else {

            try{
                DB::transaction(function () use($request, $product) {
                    
                        $product->name = $request->name;
                        $product->information = $request->information;
                        $product->price = $request->price;
                        $product->sort_order = $request->sort_order;
                        $product->shop_id = $request->shop_id;
                        $product->secondary_category_id = $request->category;
                        $product->image1 = $request->image1;
                        $product->image2 = $request->image2;
                        $product->image3 = $request->image3;
                        $product->image4 = $request->image4;
                        $product->is_selling = $request->is_selling;
                        $product->save();

                    if($request->type === \Constant::PRODUCT_LIST['add']){
                        $newQuantity = $request->quantity;
                    }
                    if($request->type === \Constant::PRODUCT_LIST['reduce']){
                        $newQuantity = $request->quantity * -1;
                    }
                    Stock::create([
                        'product_id' => $product->id,
                        'type' => $request->type,
                        'quantity' => $newQuantity
                    ]);
                }, 2);
            }catch(Throwable $e){
                Log::error($e);
                throw $e;
            }
    
            return redirect()
            ->route('owner.products.index')
            ->with(['message' => '商品情報を更新しました。',
            'status' => 'info']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete(); 

        return redirect()
        ->route('owner.products.index')
        ->with(['message' => '商品を削除しました。',
        'status' => 'alert']);
    }
}
