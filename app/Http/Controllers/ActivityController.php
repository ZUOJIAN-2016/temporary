<?php


namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Activity;
class ActivityController extends Controller
{
//草稿
    public function draft(Request $request)
     {
         $activity = new Activity();
         if(Auth::user())
         {
            $draft = $request->all();
            foreach($draft as $key=>$value)
             {
               $activity->{$key} = $value;
               $response[$key] = $value;
             }
             $activity->status='draft';
         }
     }

     //活动是否通过审核以及（不知道怎么写）建议（？）
    public function suggestion($id)
     {
         try
           {
               $activity = Activity::find($id);
               return response($activity->status, '200')->header('Content-Type', 'html');
           }
         catch (ModelNotFoundException $exception)
           {
               abort(404,'Not Found!');
               return 0;
           }
     }

     //获取活动的信息
    public  function information(Request $request,$id)
     {
        try
        {
            $activity = Activity::find($id);
            return response()->json($activity);
        }
        catch(ModelNotFoundException $e)
        {
            abort(404,'Not found');
            return 0;
        }

     }

     //编辑活动信息
    public function edit_information(Request $request,$id)
     {
         try
         {
             $activity = Activity::find($id);
             $information_update = $request->all();
             foreach($information_update as $key=>$value)
               {
                  $activity{$key}->$value;
               }
               $activity->save();
         }
         catch(ModelNotFoundException $e)
         {
             abort(404,'Not found');
             return 0;
         }
     }
 }