<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'password', 'login_name', 'mac_addr'
    ];

    protected $hidden = [
        'password', 'id', 'updated_at', 'opt1', 'opt2', 'opt3'
    ];

    // 定义用户与组织之间的多对多关系
    public function organizations()
    {
        return $this->belongsToMany('App\Organization', 'users_organizations', 'users_id', 'organizations_id')
                    ->withTimestamps()
                    ->withPivot('relation');
    }
   //定义用户与活动的多对多关系
    public function users()
    {
        return $this->belongsToMany('App\Activity', 'users_activities', 'users_id', 'activity_id')
            ->withTimestamps()
            ->withPivot('relation');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }


    /*            以下为自定义属性          */
    /* ************************************ */

    static public function validate(array $attr)
    {
        // todo 验证输入是否合法
        return true;
    }

    /* 只有用户自己才能看到的信息以及具有极高权限管理员才能看到的信息字段 */
    const PRIVATE_COLUMN = ['login_name', 'mac_addr'];
    /* 创建一个新用户必须提供的字段 */
    const REQUIRED_COLUMN = ['name', 'login_name', 'password'];
    const MODIFIABLE_COLUMN = ['mac_addr', 'name'];

    const TYPE_ROOTADMIN = -1;
    const TYPE_STUDENT = 0;
}
