<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller{

    function CategoryPage():View{
        return view('pages.dashboard.category-page');
    }

    function CategoryList(Request $request){
        $user_id = $request->header('id');
        return Category::where('user_id', $user_id)->get();
    }

    function CategoryCreate(Request $request){
        //------
        $user_id = $request->header('id');
        return Category::create([
            'name'=> $request->input('name'),
            'user_id' => $user_id
        ]);

    //------

        // try{
        //   $user_id = $request->header('id');
        //   Category::create([
        //    'name'=> $request->input('name'),
        //    'user_id' => $user_id
        //   ]);
        // return response()->json([
        //   'status' => 'success',
        //   'message' => 'Category created successfully',
        //  ], 200);
    
        // }catch(Exception $e){
        //   return response()->json([
        //     'status' => 'Failure',
        //     'message' => 'Fail to create Category',
        //    ]);
        // }
    }

    function CategoryByID(Request $request){
        // sleep(5);
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$customer_id)->where('user_id',$user_id)->first();
    }
    
    function CategoryUpdate(Request $request){
        //-------
        $user_id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('id',$category_id)->where('user_id',$user_id)->update([
            'name'=> $request->input('name')
        ]);

    //-------

        // try{
        //   $user_id = $request->header('id');
        //   $category_id = $request->input('id');
        //   $name = $request->input('name');
    
        //  $count = Category::where('user_id', $user_id)->where('name',$name)->count();
        //  if($count > 0){
        //   return response()->json([
        //     'status' => 'Already Exists',
        //     'message' => 'Category Name already exists',
        //       ],200);
            
        //  }else{
        //   Category::where('user_id',$user_id)->where('id',$category_id)->update([
        //     'name'=> $name
        //      ]);
        //      return response()->json([
        //      'status' => 'success',
        //      'message' => 'Category Updated Successfully',
        //        ],200);
        //  }

        // }catch(Exception $e){
        //   return response()->json([
        //     'status' => 'failure',
        //     'message' => $e->getMessage()
        //    ],200);    
        // }
      
    }
    
    function CategoryDelete(Request $request){
        //-------
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id',$category_id)->where('user_id',$user_id)->delete();
    
    //-------

        // try{
        //   $user_id = $request->header('id');
        //   $category_id = $request->input('id');
        
        //  // check if this category have any product
        //  $count =Product::where('category_id','=',$category_id)->
        //                   where('user_id',$user_id)->count();
      
        //  if($count < 1 ){
    
        // Category::where('user_id', $user_id)
        //   ->where('id', $category_id)
        //   ->delete();
    
        //   return response()->json([
        //     'status' => 'success',
        //     'message' => 'Category Delete',
        //    ],200);
        //  }else{
        //   return response()->json([
        //     'status' => 'Failure',
        //     'message' => 'Fail to Delete Category, because there are some product under this category',
        //    ],200);
        //  }
      
        //  }catch(Exception $e){
        //   return response()->json([
        //     'status' => 'Failure',
        //     'message' => 'something went wrong',
        //    ],200);
    
        // }
    }
    
    function CategoryTotal(Request $request){
        $user_id = $request->header('id');
        return Category::where('user_id', $user_id)->count();
      }

}
