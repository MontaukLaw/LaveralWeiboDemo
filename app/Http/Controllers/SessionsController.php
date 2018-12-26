<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //只能让guest访问登陆页面, 即已经登陆过的用户不能再登陆了.
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //goto登陆页面
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        //对提交的信息做基础验证, 看看有没有空值, 超长
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {

            //加上检查是否账户被激活
            if (Auth::user()->activated) {
                // 登录成功后的相关操作
                session()->flash('success', '欢迎回来！');
                //登陆成功之后, 如果之前是被踢出去的, 可以intend继续之前的访问地址去访问.
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
                //return redirect()->route('users.show', [Auth::user()]);
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
        } else {
            // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }

}
