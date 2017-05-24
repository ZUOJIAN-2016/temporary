<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'name', 'starts_at', 'ends_at', 'introduction', 'description', 'status', 'target'
    ];

    protected $hidden = [
        'opt1', 'opt2', 'opt3'
    ];

    // 定义活动与组织间的多对多关系
    public function organizations()
    {
        return $this->belongsToMany('App\Organization', 'activities_organizations', 'activities_id', 'organizations_id')
                    ->withTimestamps()
                    ->withPivot('relation');
    }


    // 定义活动与 Tag 之间的多对多关系
    public function tags()
    {
        return $this->belongsToMany('App\Tags', 'activities_tags', 'activities_id', 'tags_id');
    }

}

