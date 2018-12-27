<?php
/**
 * Created by PhpStorm.
 * User: Marc LAW: zunly@hotmail.com
 * Date: 2018/12/27
 * Time: 10:54
 */
namespace App\Http\Controllers;

use  \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy(Status $status)
    {
        //删除前要做验证
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }

    //保存微博
    public function store(Request $request)
    {
        //先对要保存的数据进行校验
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        //保存微博
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        //发送消息
        session()->flash('success', '发布成功！');

        //回到原请求地址
        return redirect()->back();
    }
}