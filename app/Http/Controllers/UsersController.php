<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;
use Log;

class UsersController extends Controller
{
    public function __construct()
    {
        //中间件类似于切面
        $this->middleware('auth', [
            //除了下面这些方法, 其他都需要登陆auth才能操作
            //加入confirm, 因为confirm也是需要不登陆也能操作的
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail', 'getConfirm']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        //改成不仅搜索user, 还搜索user发的所有帖子.
        //然后传参的时候, 传两个,
        $statuses = $user->statuses()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('users.show', compact('user', 'statuses'));
        //return view('users.show', compact('user'));
    }

    //基本上, controller里面的function name跟view的名字是一样的
    public function index()
    {
        $users = User::paginate(10);
        //$users = User::all();
        return view('users.index', compact('users'));
    }

    //这个方法1. 让我知道log怎么用, 2. 知道了view的文件名没有blade后缀, 就不会被渲染.
    public function getConfirm(Request $request)
    {
        //Log::debug('getConfirm');
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Log::debug('name: ' . $user->name . "/email: " . $user->email);

        return view('emails.confirm', compact('user'));
    }

    public function store(Request $request)
    {
        //Log::debug('store_bak');
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //现在是注册后去首页, 告知需要激活
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
        //原来是注册完直接登陆
        //Auth::login($user);
        //session()->flash('success', '欢迎您, '.$user->name.' ,您将在这里开启一段新的旅程~');
        //return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        //先对user授权
        $this->authorize('destroy', $user);
        $user->delete();
        //往前台flash消息
        session()->flash('success', '成功删除用户！');
        return back();
    }

    //发送激活邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    //前端会从邮件中看到这个链接, 访问过来, 传值是一个token
    public function confirmEmail($token)
    {
        //这里体现了Laravel没人性的一面, 直接拿token搜索
        $user = User::where('activation_token', $token)->firstOrFail();

        //也不写判断, 是否为空啊什么的, 直接就是$user->activated复制, 再save
        //据说这个搜索如果不成功, 会直接404, 我靠.
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}
