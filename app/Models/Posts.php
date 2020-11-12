<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Posts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'author', 'content'
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