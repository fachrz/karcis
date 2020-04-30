<?php

namespace App\Http\Controllers;

use App\kc_admin_model;
use App\kc_users_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function showAdminAccountPage()
    {
        $adminModel = kc_admin_model::select('username', 'admin_name', 'level')->get();

        return view('admin.account.AdminAccount', [
            'adminData' => $adminModel
        ]);
    }

    public function addAdminAccount(Request $request)
    {
              
        $adminModel = kc_admin_model::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'admin_name' => $request->input('admin-name'),
            'level' => $request->input('privileges'),
        ]);

        if ($adminModel) {
            return redirect('/admin/adminaccount')->with(['Sucess' => 'Admin berhasil di daftarkan']);
        }else {
            return redirect('/admin/adminaccount')->with(['Error' => 'Admin gagal di daftarkan']);
        }        
    }

    public function deleteAdminAccount(Request $request)
    {
        $adminModel = kc_admin_model::where('username', $request->username);

        if ($adminModel->delete()) {
            return redirect()->back()->with(['Sucess' => 'Admin berhasil di hapus']);
        }else {
            return redirect()->back()->with(['Error' => 'Admin gagal di daftarkan']);
        }
        
    }

    public function getAdminData(Request $request)
    {
        $adminModel = kc_admin_model::where('username', $request->username)->first();

        return response([
            'adminData' => $adminModel
        ]);
    }

    public function editAdminAccount(Request $request)
    {

        if ($request->input('password') == '') {
            $adminModel = [
                'admin_name' => $request->input('admin-name'),
                'level' => $request->input('update-privileges'),
            ];
        }else {
            $adminModel = [
                'password' => Hash::make($request->input('password')),
                'admin_name' => $request->input('admin-name'),
                'level' => $request->input('update-privileges'),
            ];
        }
        
        kc_admin_model::where('username', $request->username)
          ->update($adminModel);

        return redirect()->back()->with(['Success' => 'Edit data berhasil']);
    }

    /**
     * User Account Page
     */
    public function showUserAccountPage()
    {
        $usersModel = kc_users_model::select('email', 'first_name', 'last_name', 'telp', 'karcis_point', 'accont_type');

        return view('admin.account.UsersAccount', [
            'usersModel' => $usersModel
        ]);
    }
}
