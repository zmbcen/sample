<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);       #$this->validate()方法返回一个字典

       #这里attempt第一个参数用来让输入的数据在数据库中进行匹配，匹配成功返回true，用户登录成功，匹配失败返回false
       #这里的第二个参数是是否开启“记住我”功能的布尔值，若请求中有remeber字段，则开启记住我功能
       if (Auth::attempt($credentials,$request->has('remember')))

       {
           session()->flash('success', '欢迎回来！');
           return redirect()->route('users.show', [Auth::user()]);
       }
       else
       {
           session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
           return redirect()->back();   #回到当前页面，即重新刷新该页面
       }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }
}