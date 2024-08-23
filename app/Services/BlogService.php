<?php
namespace App\Services;

use App\Models\BlogModel;
use Illuminate\Support\Facades\DB;

class BlogService
{
    protected $model;
    function __construct()
    {
        $this->model = new BlogModel();
    }

    function getRecordsWithPagination($cond = '', $per_page = 0, $page=1){
        DB::statement('SET @sl := '.($page == 1?0:($page-1)*$per_page));
        if(!empty($cond)){
            $this->model->where($cond);
        }
        return $this->model->selectRaw('*,@sl := @sl +1 as seq')->paginate($per_page);
    }

    function getRowData($id){
        return $this->model->findorfail($id);
    }

    function SaveData($data, $id = 0){
        if($id > 0){
            $this->model = $this->getRowData($id);
        }
        $this->model->fill($data);
        return $this->model->save();
    }

    function deleteData($id){        
        return $this->model->find($id)->delete();
    }

    function approveData($id){
        $this->model = $this->getRowData($id);
        $this->model->blog_status=1;
        return $this->model->save();
    }
}