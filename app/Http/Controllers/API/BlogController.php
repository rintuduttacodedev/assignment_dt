<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    //
    protected $service;
    function __construct(BlogService $blogService)
    {
        $this->service = $blogService;
    }

    public function getData(Request $request, $blog_id=null){
        $cond = '';
        if(!empty($blog_id)){
            return response()->json(['status' => true, 'message' => '', 'data'=>$this->service->getRowData($blog_id)]);
        }
        $data = $this->service->getRecordsWithPagination($cond.'blog_status=1',10,$request->page??1);
        return response()->json(['status' => true, 'message' => '', 'data'=>$data->toArray()]);
    }

    public function saveBlog(Request $request, $id=''){
        $rules = [
            'title' => 'required|max:255|unique:blog,blog_title,'.$id.',blog_id',
            'description' => 'required',
            'image' => ($id == ''?'required|':'').'image|max:2048|mimes:jpeg,jpg,png,gif',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'title.required' => 'blog title name is required',
            'title.max' => 'blog title name is maximum 255 characters long',
            'title.unique' => 'This blog title has already exist',
            'image.required' => 'please upload blog feature image',
            'image.max' => 'Image max size 2MB',
            'image.mimes' => 'Image only support jpeg,jpg,png,gif',
            'description.required' => 'blog description is required',
        ]);
        
        if($validator->fails()){
            return response()->json(['status' => false, 'message' => implode('|--|',$validator->errors()->all()), 'data'=>null]);;
        }
        $data = ['blog_title'=>$request->title,'blog_description'=>$request->description,'created_by'=>$request->user()->id??0];
        if($id == ''){
            $data['blog_status'] = 3;
        }
        if(isset($request->image)){                    
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['blog_image'] = 'images/'.$imageName;
        }
        $this->service->SaveData($data,$id);        
        return response()->json(['status' => true, 'message' => 'Blog created successfully', 'data'=>null]);
    }

    public function delete(Request $request){

    }
}
