<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function all()
    {
        $categories=Category::all();
        
       
        return response()->json([
            'message' =>"جميع الاقسام",
            'data' => $categories
        ],200);

    }


    public function show($id)
    {
        $category=Category::find($id);
        if($category==null){
            return response()->json([
                'message'=>"القسم غير موجود"
            ]);
        }
       
        return response()->json([
            'data' => $category
        ],200);

    }




    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:255'
        ]
        );
        if ($validator->fails()) {
            return response()->json([
                'message' => 'حدث خطأ',
                'errors' => $validator->errors()
            ],422);
        }

        $category = Category::create([
            'name'=>$request->name,
            
        ]);

        return response()->json([
            'message' => '  تم اضافه قسم جديد بنجاح',
            'data' => $category
        ],200);
    }

    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'name'=>"required|string|max:255"
        ]);
        if($validator->fails())
        {
            return response()->json([
                'message'=>'حدث خطأ',
                'errors'=>$validator->errors()
            ]);
        }
        $category=Category::find($id);
        if($category==null)
        {
            return response()->json([
                'message'=>"القسم غير موجود"
            ]);
        }
        $category->update([
            'name'=>$request->name
        ]);

        return response()->json([
            'message' => ' تم تعديل القسم بنجاح',
            'data' => $category
        ],200);

    }


    public function delete($id)
    {
        $category=Category::find($id);
        if($category==null){
            return response()->json([
                'message'=>"القسم غير موجود"
            ]);
        }
        $category->delete();

        return response()->json([
            'message' => 'تم حذف القسم بنجاح',
        ],200);

    }



    }

