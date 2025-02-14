<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\File;

class ProjectController extends Controller
{
    //
    public function hidden()
    {
        $Projects=Project::with(['category','images'])->where('hidden','=',1)->get();
        return response()->json([
            'message' =>" جميع المشاريع المخفيه",
            'data' => $Projects,
        ],200);
    }

    public function appear()
    {
        $Projects=Project::with(['category','images'])->where('hidden','=',0)->get();
        return response()->json([
            'message' =>"كل المشاريع المتاحه حاليا",
            'data' => $Projects
        ],200);
    }

    public function all()
    {
         $Projects=Project::with(['images','category'])->get();
        return response()->json([
            'message' =>"جميع المشاريع ",
            'data' => $Projects,
        ],200);

    }


    public function show($id)
    {
        $project=Project::with(['images','category'])->findOrFail($id);
        if($project==null){
            return response()->json([
                'message'=>"المشروع غير موجود"
            ]);
        }   
        
        return response()->json([
            'data' => $project,
           
        ],200);

    }


    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'title'=>'required|string|max:255',
            'descriptions'=>'required|string|min:10',
            'url'=>'required|string',
            'image'=>"required|array",
            'image.*'=>'image|mimes:png,jpeg,jpg|max:5120',
            'tool'=>'required|string',
            'hidden'=>'required|boolean',
            'category_id'=>'required|exists:categories,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'حدث خطأ',
                'errors' => $validator->errors()
            ],422);
        }
        $project = Project::create([
            'title'=>$request->title,
            'descriptions'=>$request->descriptions,
            'url'=>$request->url,
            'tool'=>$request->tool,
            'hidden'=>$request->hidden,
            'category_id'=>$request->category_id  
        ]);
        foreach($request->file('image') as $img)
        {
            $path=Storage::putFile("images",$img);
            Image::create([
                'project_id'=>$project->id,
                'image'=>$path
            ]);
        }
        $images=$project->images;
        $category=$project->category;
        return response()->json([
            'message' => '  تم اضافه مشروع جديد بنجاح',
            'data' => $project
        ],200);
    }


    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'title'=>'required|string',
            'descriptions'=>'required|string|min:10',
            'url'=>'required|string',
            'image'=>'array',
            'image.*'=>'image|mimes:png,jpeg,jpg|max:5120',
            'tool'=>'required|string',
            'hidden'=>'required|boolean',
            'category_id'=>'required|exists:categories,id'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'message'=>'حدث خطأ',
                'errors'=>$validator->errors()
            ]);
        }
        $project=Project::find($id);
        if($project==null)
        {
            return response()->json([
                'message'=>"المشروع غير موجود"
            ]);
        }
        $project->update([
            'title'=>$request->title,
            'descriptions'=>$request->descriptions,
            'url'=>$request->url,
            'tool'=>$request->tool,
            'hidden'=>$request->hidden,
            'category_id'=>$request->category_id 
        ]);

        if($request->hasFile('image'))
        {   foreach($request->file('image') as $index => $img)
            {
                if(isset($project->images[$index]))
                { 
                    $image = $project->images[$index];
                    Storage::delete($image->image);
                    $path=Storage::putFile("images",$img);
                    $image->update([
                        'image'=>$path
                    ]);
                }
                else{
                    $path=Storage::putFile("images",$img);
                     Image::create([
                    'project_id'=>$project->id,
                    'image'=>$path
                ]);}
            }   
        }
        $project->save();
        $images=$project->images;
        $category=$project->category;
        return response()->json([
            'message' => ' تم تعديل المشروع بنجاح',
            'data' => $project
        ],200);

    }



    public function delete($id)
    {
        $project=Project::find($id);
        if($project==null){
            return response()->json([
                'message'=>"المشروع غير موجود"
            ]);
        }
        foreach($project->images as $image){
            Storage::delete($image->image);
        }
        $project->delete();

        return response()->json([
            'message' => 'تم حذف المشروع بنجاح',
            
        ],200);
    }

    public function categorries($id)
    {
        $projects=Project::with(['images'])->where("category_id","=",$id)->get();
        if($projects ->isEmpty())
        {
            return response()->json([
                'message'=>"لا يوجد مشاريع فى هذا القسم",
                
            ],400);
        }
        
        return response()->json([
            'message'=>"كل المشاريع الموجوده فى هذا القسم",
            'data'=>$projects
            
        ],200);

    }




    }



