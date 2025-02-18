<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use mysql_xdevapi\Exception;

class UsersController extends Controller
{

  public function __construct()
  {
      // 除了 show create store index 方法，其他方法都需要登录
      $this->middleware('auth', [
        'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
      ]);

      // 只允许未登录用户访问注册页面, 即 create 方法
      $this->middleware('guest', [
          'only' => ['create']
      ]);
  }

    /**
     * Show all users.
     *
     * @return Factory｜View｜Application
     */
    public function index(): Factory|View|Application
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }


    /**
     * Show the form for signup.
     *
     * @return Application|Factory|View
     */
    public function create(): Factory|View|Application
    {
        return view('users.create');
    }

    /**
     * Show user information.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user): View|Factory|Application
    {
        return view('users.show', compact('user'));
    }

    /**
     * Store a new user.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', 'Congratulations on your successful registration!');
        return redirect('/');
    }

    /**
     * Send email confirmation
     */
    protected function sendEmailConfirmationTo ($user): void
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'hana@gmail.com';
        $name = 'hana\'s blog';
        $to = $user->email;
        $subject = 'Congratulations on your successful registration!';

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    /**
     * Show the form for editing user information.
     *
     * @param User $user
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(User $user): View|Factory|Application
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * Update user information
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', 'Congratulations on your successful update!');
        return redirect()->route('users.show', $user);
    }

    /**
     * Delete user.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', 'Congratulations on your successful delete!');
        return back();
    }

    /**
     * Confirm email.
     *
     * @param $token
     * @return RedirectResponse
     */
    public function confirmEmail($token): RedirectResponse
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', 'Congratulations, activation successful.');
        return redirect()->route('users.show', [$user]);
    }
}
