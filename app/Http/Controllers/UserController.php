<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAccess;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $data['code'] = generateCode("User", 'U');
            $data['users'] = User::latest()->get();

            return response()->json($data);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function userProfile()
    {
        return view('administration.user.profile');
    }

    public function create()
    {
        if (!checkAccess('user')) {
            return view('error.unauthorize');
        }

        return view('administration.user.create');
    }

    public function store(UserRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $userunique = User::where('username', $request->username)->first();
        if (!empty($userunique)) return send_error("This username have been already exists", null, 422);
        $emailunique = User::where('email', $request->email)->first();
        if (!empty($emailunique)) return send_error("This email have been already exists", null, 422);

        try {
            $check = DB::table('users')->where('deleted_at', '!=', NULL)->where('username', $request->username)->first();;
            if (!empty($check)) {
                DB::select("UPDATE users SET deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new User();
                $data->code = generateCode("User", 'U');
                $userKeys = $request->except('id', 'password', 'image', 'code');
                foreach (array_keys($userKeys) as $key) {
                    $data->$key = $request->$key;
                }
                $data->password = Hash::make($request->password);
                if ($request->hasFile('image')) {
                    $data->image = imageUpload($request, 'image', 'uploads/user', trim($data->code));
                }
                $data->last_update_ip = request()->ip();
                $data->save();
            }
            return response()->json("User insert successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(UserRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $userunique = User::where('id', '!=', $request->id)->where('username', $request->username)->first();
        if (!empty($userunique)) return send_error("This username have been already exists", null, 422);
        $emailunique = User::where('id', '!=', $request->id)->where('email', $request->email)->first();
        if (!empty($emailunique)) return send_error("This email have been already exists", null, 422);

        try {
            $data = User::find($request->id);
            $userKeys = $request->except('id', 'password', 'image');
            foreach (array_keys($userKeys) as $key) {
                $data->$key = $request->$key;
            }
            if (!empty($request->password)) {
                $data->password = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/user', trim($request->code));
            }
            $data->updated_at     = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("User profile update successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = User::find($request->id);
            $data->status = 'd';
            $data->update();

            $data->delete();
            return response()->json("User delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function userStatus(Request $request)
    {
        try {
            if ($request->id != 1) {
                $data = User::find($request->id);
                $data->status = $request->status;
                $data->update();

                return response()->json('User status change successfully', 200);
            } else {
                return send_error('This user can not change status', null, 422);
            }
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function userAccess($id)
    {
        if (!checkAccess('userAccess')) {
            return view('error.unauthorize');
        }

        $check = User::where('id', $id)->first();
        if (!empty($check)) {
            if ($check->id == 1 || $check->role == 'Superadmin') {
                Session::flash('error', 'User not found');
                return redirect()->route('user.create');
            }
            $user = $check;
        } else {
            Session::flash('error', 'User not found');
            return redirect()->route('user.create');
        }
        return view('administration.user.useraccess', compact('user'));
    }

    public function getUserAccess(Request $request)
    {
        try {
            $data = UserAccess::where('user_id', $request->userId)->first();
            return response()->json($data);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function addUserAccess(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $check = UserAccess::where('user_id', $user->id)->first();
            if (!empty($check)) {
                $check->access = empty($request->access) ? NULL : json_encode($request->access, true);
                $check->updated_at = Auth::user()->id;
                $check->last_update_ip = request()->ip();
                $check->updated_at = Carbon::now();
                $check->update();
                $msg = "User access update successfully";
            } else {
                $data = new UserAccess();
                $data->user_id = $user->id;
                $data->access = json_encode($request->access, true);
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();

                $msg = "User access create successfully";
            }

            $user->action = !empty($request->action) ? implode(",", $request->action) : NULL;
            $user->update();

            return response()->json($msg, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }


    public function userprofileUpdate(Request $request)
    {
        $user = Auth::user();

        if (!empty($request->current_password) || !empty($request->password) || !empty($request->confrim_password)) {
            $validator = Validator::make($request->all(), [
                "email" => "required|unique:users,email," . $user->id,
                "current_password" => "required",
                "password"         => "required",
                'confirm_password' => 'required_with:password|same:password'
            ], ['password.required' => 'New password field required']);
        } else {
            $validator = Validator::make($request->all(), [
                "email" => "required|unique:users,email," . $user->id,
                "image" => "nullable",
            ]);
        }
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $data = User::find($user->id);
            $data->email = $request->email;
            if (!empty($request->current_password) || !empty($request->password) || !empty($request->confrim_password)) {
                if (Hash::check($request->current_password, $user->password)) {
                    $data->password = Hash::make($request->password);
                } else {
                    return send_error("Current password does not match", null, 422);
                }
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/user', trim($data->code));
            }

            $data->update();
            return response()->json("User Profile Updated", 200);
        } catch (\Throwable $e) {
            return send_error("Something went wrong", $e->getMessage());
        }
    }

    public function userActivity()
    {
        return view('administration.user.activity');
    }

    public function getUserActivity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required',
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $data = UserActivity::with('user')->where('user_id', $request->userId)->latest()->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroyUserActivity(Request $request)
    {
        if (count($request->activities) == 0) return send_error("Activities is empty", null, 422);
        try {
            if ($request->deleteStatus == 'hard') {
                foreach ($request->activities as $key => $item) {
                    UserActivity::where('id', $item['id'])->first()->forceDelete();
                }
            } else {
                foreach ($request->activities as $key => $item) {
                    UserActivity::where('id', $item['id'])->first()->delete();
                }
            }
            return response()->json('User activity delete successfully');
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    //user check
    public function checkUser(Request $request)
    {
        $checkuser = User::where('username', $request->username)->first();
        if (empty($checkuser)) {
            $data['status'] = 'false';
        } else {
            $data['status'] = 'true';
        }
        return response()->json($data);
    }
}
