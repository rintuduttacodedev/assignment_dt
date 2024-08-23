@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-sm btn-primary mb-5" href="{{route('admin.blog.request_control','add')}}">Add New Blog</a>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="bg-dark">
                    <tr>
                        <th>Sl.</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
    
                <tbody>
                    @if($datas->count() > 0)
                    @foreach($datas as $data)
                    <tr>
                        <td>{{$data->seq}}</td>
                        <td>{{$data->blog_title}}</td>
                        <td>
                            @if($data->blog_status == 1)
                            <span class="text-success">Active</span>
                            @elseif($data->blog_status == 2)                            
                            <span class="text-dark">In-Active</span>
                            @elseif($data->blog_status == 3)                            
                            <span class="text-warnning">Unapproved</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.blog.request_control',['action_type'=>'edit','blog_id'=>$data->blog_id])}}">Edit</a>
                            @if($data->blog_status == 3)
                            <a href="{{route('admin.blog.request_control',['action_type'=>'approve','blog_id'=>$data->blog_id])}}">Approve</a>
                            @endif
                            <a href="{{route('admin.blog.request_control',['action_type'=>'delete','blog_id'=>$data->blog_id])}}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <td colspan="3" align="center">No Record Found</td>
                    @endif
                </tbody>
    
                <tfoot class="bg-default">
                    <tr>
                        <th>Sl.</th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
    
            </table>
        </div>
        <div class="col-md-12">
            {{ $datas->links() }}
        </div>
    </div>
</div>
@endsection