<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        if(count($categories)>0) return response()->json([
            'exist' => true,
            'categories'=>$categories
        ]);
        else return response()->json([
            'exist' => false,
            'message' => 'No categories',
        ]);
    }
    public function getCategory_Subcategories(){
        $categories=Category::with('sub_categories')->get();
        if(count($categories)>0) return response()->json([
            'exist' => true,
            'categories'=>$categories
        ]);
        else return response()->json([
            'exist' => false,
            'message' => 'No categories',
        ]);
    }

    public function store(Request $request){
        try {
            
            $form=$request->validate([
                'name' => 'required|string|unique:categories,name',
            ]);
            $category=Category::where('name',$form['name'])->first();
            if(!$category){
                $category=Category::create($form);
                return response()->json([
                    'success' => true,
                    'message' => 'category added',
                    'category' => $category->name,
                ]);
            }
            else return response()->json([
                'success' => false,
                'message' => 'category already exist',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        
    }
    public function destroy($category){
        try{
            $category=Category::find($category);
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'category deleted',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request,$id){
        try{
            $form=$request->validate([
                'name' => 'required|string|unique:categories,name,' . $id . ',id',
            ]);
            $category=Category::find($id);
            $category->name=$form['name'];
            $category->save();
            return response()->json([
                'success' => true,
                'message' => 'category updated',
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
