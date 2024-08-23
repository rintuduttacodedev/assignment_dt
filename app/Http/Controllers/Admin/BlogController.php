<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class BlogController extends Controller
{
    //
    function index(Request $request,BlogService $blogService){
        $datas = $blogService->getRecordsWithPagination('',10,$request->page??1);
        return view('admin.blog.list',compact('datas'));
    }

    function handleRequest(Request $request,BlogService $blogService, $request_type, $id= 0){
        if($request_type == 'add' || $request_type == 'edit'){
            if($request->getMethod() == 'POST'){
                $rules = [
                    'title' => 'required|max:255|unique:blog,blog_title,'.$request->id.',blog_id',
                    'description' => 'required',
                    'image' => ($request_type != 'edit'?'required|':'').'image|max:2048|mimes:jpeg,jpg,png,gif',
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
                    return Redirect::back()->withInput($request->all())->withErrors($validator,'blog');
                }
                $data = ['blog_title'=>$request->title,'blog_description'=>$request->description,'created_by'=>$request->user()->id];
                if(isset($request->image)){                    
                    $imageName = time().'.'.$request->image->extension();
                    $request->image->move(public_path('images'), $imageName);
                    $data['blog_image'] = 'images/'.$imageName;
                }
                $blogService->SaveData($data,$request->id);
                return Redirect::to(route('admin.blog.list'))->with('success', 'Product created successfully.');
            }else{
                $action = route('admin.blog.request_control',$request_type);
                $data = [];
                if($id > 0){
                    $data = $blogService->getRowData($id);
                }
                return view('admin.blog.add_edit_form',compact('action','data'));
            }
        }
        if($request_type == 'delete'){
            $blogService->deleteData($id);
            return Redirect::to(route('admin.blog.list'))->with('success', 'Product deleted successfully.');
        }
        
        if($request_type == 'approve'){
            $blogService->approveData($id);
            return Redirect::to(route('admin.blog.list'))->with('success', 'Product Approve successfully.');
        }
    }
}
