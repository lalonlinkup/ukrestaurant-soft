<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Session::forget('module');
        Session::put('module', 'dashboard');

        return view('administration.dashboard');
    }

    public function module($module)
    {
        Session::forget('module');
        Session::put('module', $module);

        return view('administration.dashboard');
    }

    public function company()
    {
        return view('administration.settings.company_profile');
    }

    public function updateCompany(Request $request)
    {
        try {
            $company = CompanyProfile::first();
            $company->name = $request->name;
            $company->title = $request->title;
            $company->phone = $request->phone;
            $company->email = $request->email;
            $company->address = $request->address;
            $company->map_link = $request->map_link;
            $company->facebook = $request->facebook;
            $company->instagram = $request->instagram;
            $company->twitter = $request->twitter;
            $company->youtube = $request->youtube;
            if ($request->hasFile('logo')) {
                if (File::exists($company->logo)) {
                    File::delete($company->logo);
                }
                $company->logo = imageUpload($request, 'logo', 'uploads/logo', '');
            }
            if ($request->hasFile('favicon')) {
                if (File::exists($company->favicon)) {
                    File::delete($company->favicon);
                }
                $company->favicon = imageUpload($request, 'favicon', 'uploads/favicon', '');
            }
            $company->update();
            return response()->json(['status' => true, 'message' => 'Company profile update successfully']);
        } catch (\Throwable $th) {
            return send_error('Something went wrong', $th->getMessage());
        }
    }

    public function getCompany()
    {
        $company = CompanyProfile::first();
        return response()->json($company);
    }

    // admin logout
    public function Logout()
    {
        try {
            UserActivity::create([
                'user_id' => Auth::user()->id,
                'page_name' => 'Logout',
                'login_time' => NULL,
                'logout_time' => Carbon::now(),
                'ip_address' => request()->ip(),
            ]);
            Auth::guard('web')->logout();
            Session::forget('module');
            Session::flash('success', 'Logout successfully');
            return redirect('/');
        } catch (\Throwable $e) {
            return send_error('Something went wrong', $e->getMessage());
        }
    }
}