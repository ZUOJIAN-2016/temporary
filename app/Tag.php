<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'name', 'description'
    ];

    protected $hidden = [
        'opt1'
    ];

    // 定义 Tag 与活动的多对多关系
    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'activities_tags', 'tags_id', 'activities_id');
    }
}
