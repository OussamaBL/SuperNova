<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Sub_Category;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    public function index()
    {
        $sub_categories = Sub_Category::with('category')->get();
        if (count($sub_categories)>0) {
            return response()->json([
                'exist' => true,
                'sub_categories' => $sub_categories
            ]);
        } else {
            return response()->json([
                'exist' => false,
                'message' => 'Sub categories not found',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        try {
            $form=$request->validate([
                "name"=>'required|string|unique:sub_categories,name',
                "id_catg"=>'required|integer|exists:categories,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/sub_categories'), $imageName);

            $sub_category=Sub_Category::create([
                "name"=>$form['name'],
                "id_catg"=>$form['id_catg'],
                "image"=>'sub_categories/'.$imageName
            ]);

            return response()->json([
                'success' => true,
                'sub_category' => $sub_category->name,
            ]);
        } 
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sub_Category  $sub_Category
     * @return \Illuminate\Http\Response
     */
    public function show(Sub_Category $sub_Category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sub_Category  $sub_Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Sub_Category $sub_Category)
    {
        //
    }

   
    public function update(Request $request,$id)
    {
        try {
            $form=$request->validate([
                "name"=>'required|string|unique:categories,name,' . $id . ',id',
                "id_catg"=>'required|integer|exists:categories,id',
                // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $sub_category=Sub_Category::find($id);
            if($sub_category->image==$request->image) $imageName=$sub_category->image;
            else{
                $image = $request->file('image');
                $imageName ='sub_categories/'. time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/sub_categories'), $imageName);
            }
            $sub_category->name=$form['name'];
            $sub_category->id_catg=$form['id_catg'];
            $sub_category->image=$imageName;
            $sub_category->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Sub-category updated',
            ]);
        } 
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($sub_Category)
    {
        try{
            $sub_Category=Sub_Category::find($sub_Category);
            $sub_Category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Sub category deleted',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
