<?php

namespace App\Http\Controllers;

use App\Mail\RegMail;
use App\User;
use Illuminate\Http\Request;

/**
 * artisan make:controller --resource --model=User AbcController
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show', 'create', 'store', 'confimEmailToken']
        ]);

        // 只有游客才可以访问注册页面
        $this->middleware('guest', [
            'only' => ['create', 'store']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // 此种校验方式不友好，没有错误提示
        $data = $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:5|confirmed'
        ]);
        $data['password'] = bcrypt($data['password']);
        // 添加用户
        $user = User::create($data);
        // 发送邮件
        \Mail::to($user)->send(new RegMail($user));
        session()->flash('success', '请查看邮箱完成注册验证');
        return redirect()->route('home');
        // 自动登陆
        // $status = \Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        /*if (!empty($status)) {
            session()->flash('success', '注册成功，已经为你自动登陆系统');
            // 自动登陆成功后跳转到首页
            return redirect()->route('home');
        }*/
    }

    /**
     * 关注或取消关注
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow(User $user)
    {
        $user->followToggle(\Auth::user()->id);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $blogs = $user->blogs()->paginate('5');
        if (\Auth::check()) {
            $followTitle = $user->isFollow(\Auth::user()->id) ? '取消关注' : '关注';
        } else {
            $followTitle = "";
        }
        return view('user.show', compact('user', 'blogs', 'followTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name' => 'required|min:3',
            'password' => 'nullable|min:5|confirmed'
        ]);
        $user->name = $request->name;
        if ($request->password) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        session()->flash('success', '修改成功');
        return redirect()->route('user.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        // 删除模型，删除表记录
        $user->delete();
        session()->flash('success', '删除成功');
        return redirect()->route('user.index');
    }

    public function confimEmailToken($token)
    {
        $user = User::where('email_token', $token)->first();
        if ($user) {
            $user->email_active = true;
            $user->save();
            session()->flash('success', '验证成功');
            // \Auth::attempt($user);
            \Auth::login($user);
            return redirect('/');
        }
        session()->flash('danger', '邮箱验证失败');
        return redirect('/');
    }
}
