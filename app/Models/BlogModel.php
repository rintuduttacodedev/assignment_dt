<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'blog';

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'blog_id';

    /**
     * The attributes that are mass assignable.
    */
    protected $fillable = [
        'blog_title',
        'blog_description',
        'blog_image', 
        'blog_status',
        'created_by',
    ];
}
