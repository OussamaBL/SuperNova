<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Repositories\ProductRepositorieInterface;
use Exception;

class ProductController extends Controller
{
    
    protected $ProductRepositorieInterface;


    public function __construct(ProductRepositorieInterface $ProductRepositorieInterface){
        $this->ProductRepositorieInterface = $ProductRepositorieInterface;
    }
    
    public function index()
    {
        $products = $this->ProductRepositorieInterface->getAll();
        if (count($products)>0) {
            return response()->json([
                'exist' => true,
                'products' => $products
            ]);
        } else {
            return response()->json([
                'exist' => false,
                'message' => 'Products not found',
            ]);
        }
    }


    public function create()
    {
        //
    }


    public function store(ProductRequest $request)
    {
        try{
            $form=$request->validated();
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $form['image'] = $imageName;
            if($form['qte']==0) $form['in_stock'] = false;
            else{
                if($form['in_stock']=="true") $form['in_stock'] = true;
                else $form['in_stock'] = false;
            }
            $product=$this->ProductRepositorieInterface->create($form);
            return response()->json([
                'success' => true,
                'product' => $product->title,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }

   
    public function update(Request $request,$id)
    {
        try {
            $form=$request->validate([
                'title' => 'required|string',
                'price' => 'required|numeric|min:0',
                'discounted_price' => 'nullable|numeric|min:0',
                'reference' => 'required|string|unique:products,reference,'.$id.',id',
                'description' => 'required|string',
                'image' => 'required',
                'qte' => 'required|integer|min:0',
                'id_sub_catg' => 'required|integer|exists:sub_categories,id',
                'in_stock' => 'required',
            ]);
            
            $product=Product::find($id);
            if($product->image==$request->image) $imageName=$product->image;
            else{
                $image = $request->file('image');
                $imageName =time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
            }
            $form['image'] = $imageName;
            if($form['qte']==0) $form['in_stock'] = false;
            else{
                if($form['in_stock']=="true") $form['in_stock'] = true;
                else $form['in_stock'] = false;
            }

            // $product->update($form);
            $this->ProductRepositorieInterface->update($id,$form);
            
            return response()->json([
                'success' => true,
                'message' => 'Product updated',
            ]);
        } 
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

   
    public function destroy($id)
    {
        try{
            // $product=product::find($id);
            // $product->delete();
            $this->ProductRepositorieInterface->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Product deleted',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function popular(){
        $products = $this->ProductRepositorieInterface->popular();
        if (count($products)>0) {
            return response()->json([
                'exist' => true,
                'products' => $products
            ]);
        } else {
            return response()->json([
                'exist' => false,
                'message' => 'Products not found',
            ]);
        }
    }
    public function getProducts_SubCategory($subCategory){
        $products = $this->ProductRepositorieInterface->getProducts_SubCategory($subCategory);
        if (count($products)>0) {
            return response()->json([
                'exist' => true,
                'products' => $products
            ]);
        } else {
            return response()->json([
                'exist' => false,
                'message' => 'Products not found',
            ]);
        }
    }
}
