@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="offset-2 col-md-6">
            <form action="{{$action}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$data['blog_id']??old('id')??'0'}}">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{$data['blog_title']??old('title')??''}}" required>
                    <p class="text-danger">{{ $errors->blog->first('title') }}</p>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" type="text" name="description" id="description" rows="15" required>{{$data['blog_description']??old('description')??''}}</textarea>
                    <p class="text-danger">{{ $errors->blog->first('description') }}</p>
                </div>
                <div class="form-group">
                    {{$data['blog_image']??old('image')??''}}<br/>
                    <label for="image">Image</label>
                    <input class="form-control" type="file" name="image" id="image" value="" {{(($data['blog_id']??0) <= 0?'required':'')}} >
                    <p class="text-danger">{{ $errors->blog->first('image') }}</p>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection