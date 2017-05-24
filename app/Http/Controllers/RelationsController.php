<?php
/**
 * Created by PhpStorm.
 * User: 黃蕴
 * Date: 2017/5/24
 * Time: 13:25
 */

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
class RelationsController extends Controller
{
    //用户的活动列表
    public function activity_list($id)
    {
        try
        {
            $user_activity = User::find($id)->activity;
            $user_activity_id = $user_activity->id;
            foreach($user_activity_id as $item)
            {
                $activity = Activity::where('id',$item)->firstOrFail;
                return response($activity, '200')->header('Content-Type', 'html');
            }

        }
        catch (ModelNotFoundException $exception)
        {
            abort(404, 'Not Found!');
        }

    }
}