<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showUserLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            "username" => "required",
            "password" => "required",
        ], ['username.required' => 'Username is required','password.required' => 'Password is required']);

        try {
            $user = User::where('username', $request->username)->first();
            if (empty($user)) {
                return send_error("Unauthorized", ['username' => 'User not found'], 401);
            }
            if ($user->status == 'p') {
                return send_error("Unauthorized", ['username' => 'User Deactive'], 401);
            }

            if (Auth::guard()->attempt(credentials($request->username, $request->password))) {
                UserActivity::create([
                    'user_id' => $user->id,
                    'page_name' => "Dashboard",
                    'login_time' => Carbon::now(),
                    'ip_address' => request()->ip(),
                ]);
                Session::flash('success', 'Login successfully');
                return response()->json(['status' => true, 'message' => 'Successfully Login', 'user' => Auth::user()], 200);
            } else {
                return send_error("Unauthorized", ['username' => 'Username or password not valid'], 401);
            }
        } catch (\Throwable $th) {
            return send_error('Something went wrong', $th->getMessage(), 404);
        }
    }
}
