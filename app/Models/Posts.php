<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tags;

class Posts extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'author', 
        'content'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function tags()
    {
        return $this->hasMany('App\Models\Tags');
    }
}