<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;


class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
        ]);
       #$this->validate()方法返回一个字典
       #这里attempt第一个参数用来让输入的数据在数据库中进行匹配，匹配成功返回true，用户登录成功，匹配失败返回false
       #这里的第二个参数是是否开启“记住我”功能的布尔值，若请求中有remeber字段，则开启记住我功能
        if (Auth::attempt($credentials,$request->has('remember')))
        {
            if(Auth::user()->activated)
            {
                session()->flash('success', '欢迎回来！');
                #登录成功后，将用户重定向到它之前访问的界面，接收一个默认地址参数
                return redirect()->intended(route('users.show', [Auth::user()]));  #Auth::user()可以用来获取当前登录的用户
            }else
            {
                Auth::logout();
                session()->flash("warning","您的账号为激活,请检查邮箱中的注册邮件来激活");
                return redirect('/');
            }
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