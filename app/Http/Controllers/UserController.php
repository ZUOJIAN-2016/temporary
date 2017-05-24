<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // 若用户已经登陆则直接返回用户登录凭证
        if (Session::$segment->get('user.login', false)) {
            return Session::$segment->get('user.model');
        }

        // 如果所需字段不全返回 400 Bad Request
        if (!$request->has(['login_name', 'password'])) {
            abort(400, 'Bad Request!');
        }

        try {
            $user = User::where('login_name', $request->input('login_name'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            // 没有找到用户也返回 401
            abort(401, 'Unauthorized!');
        }

        if (!password_verify($request->input('password'), $user->password)) {
            // 密码不符返回 401
            abort(401, 'Unauthorized!');
        }

        // 登陆成功
        Session::$segment->set('user.login', true);
        Session::$segment->set('user.model', $user);
        return response()->json($user);
    }

    public function logout()
    {
        Session::$segment->set('user.login', null);
        Session::$segment->set('user.model', null);
        return response()->json(['status' => 'success', 'message' => 'Done!']);
    }

    public function create(Request $request)
    {
        // 用户已登陆的情况
        if (Session::$segment->get('user.login', false)) {
            // Todo 使用用户授权策略控制权限
            abort(403, '当前状态您无法创建用户！');
        }

        // 验证输入是否含必需字段且能通过验证
        // 暂时没有使用 Validator
        if (!$request->has(User::REQUIRED_COLUMN) or !User::validate($request->input())) {
            abort(400, 'Bad Request!');
        }

        // Todo 根据 Key 决定建立用户的类型
        $user = new User;
        $user->fill($request->input());
        $user->type = User::TYPE_STUDENT;
        $user->logined = false;
        $user->save();

        Session::$segment->set('user.login', true);
        Session::$segment->set('user.model', $user);

        return $user;
    }

    public function profile()
    {
        return Auth::user();
    }

    // Todo 使用用户授权策略控制用户权限
    public function view($loginName)
    {
        try {
            $user = User::where('login_name', $loginName)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404, 'Not Found!');
        }
        $user = $user->toArray();
        foreach (User::PRIVATE_COLUMN as $key) {
            unset($user[$key]);
        }
        return response()->json($user);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $response = [];
        foreach (User::MODIFIABLE_COLUMN as $key) {
            if ($request->has($key)) {
                $user->{$key} = $request->input($key);
                $response[$key] = $request->input($key);
            }
        }
        $user->save();
        return response()->json($response);
    }
}
