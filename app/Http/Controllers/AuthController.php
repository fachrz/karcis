<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    /*
    //////////////////////////////////////
    //    Authentication Controller    //
    ////////////////////////////////////
    * Created By Fachrz
    */
    
    /**
     * Show Login Form
     *
     */
    public function showLoginForm()
    {
        return \view('LoginPage');
    }

    /**
     * Show Register Form
     *
     */
    public function showRegisterForm()
    {
        return \view('RegisterPage');
    }

    /**
     * Register
     * 
     * Daftar Account
     */
    public function register()
    {
        #validation
        $validatedData = validator(request()->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'no_telp' => 'required|numeric',
            'confirm_password' => 'required|same:password'
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong', 
            'first_name.required' => 'Nama depan tidak boleh kosong',
            'no_telp.required' => 'Nomor Telepon tidak boleh kosong',
            'no_telp.numeric' => 'Nomor Telepon tidak valid',
            'confirm_password.required' => 'Konfirmasi Password tidak boleh kosong',
            'confirm_password.same' => 'Password tidak sama'
        ]);

        $validatedData->validate();
        
        if (is_null($this->accountCheck(request()->input('email')))) {
            try {
                User::create([
                    'email' => request()->input('email'),
                    'password' => Hash::make(request()->input('password')), 
                    'first_name' => request()->input('first_name'), 
                    'last_name' => request()->input('last_name'), 
                    'telp' => request()->input('no_telp'), 
                    'karcis_point' => 0, 
                    'account_type' => 'email'
                ]);

                return redirect('/register')->with(['Success' => 'Registrasi Akun berhasil']);
            } catch (\Throwable $th) {
                // return $th;
                return redirect('/register')->with('Error', 'Registrasi Akun gagal, terjadi masalah dengan server!');
            }
        }else{
            return redirect('/register')->with('Error', 'Email telah terdaftar')->withInput();  
        }    
    }

    /**
     * Account Check
     * 
     * Method ini bertangung jawab untuk melakukan check akun yang terdaftar
     */
    public function accountCheck($email){

        $users = User::select('email', 'account_type', 'password')->where('email', $email)->first();

        return $users;
    }

    /**
     * Authenticating Users and create their Session
     *
     */
    public function emailAuthentication(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $account = $this->accountCheck($email);

        if ($account == null) {
            return redirect('/login')->with(['error' => 'Email kamu tidak terdaftar!!']);
        }else if ($account->account_type == 'email') {
            if (Hash::check($password, $account->password)) {

                $session_create = $this->createUserSession($email);
                
                if ($session_create['msg_code'] == '0sc4p25') {
                    return \redirect('/');
                }   
            }else {
                return redirect('/login')->with(['error' => 'Password yang anda masukan salah!!']);
            }
        }else if($account->account_type != 'email'){
            return redirect('/login')->with(['error' => "Akun kamu tidak didaftarkan dengan email, silahkan login melalui Akun ". ucfirst($account->account_type)]);
        }
    }

    public function thirdPartyAuthentication(Request $request){

        $email = $request->email;
        $account_type = $request->login_type;

        $account = [
            'email' => $request->email,
            'thumbnail' => $request->thumbnail,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'account_type' => $request->login_type,
        ];

        $users = $this->accountCheck($email);

        if($users == null){

            $accountRegister = $this->accountRegister($account);
            if ($accountRegister) {
                $this->createUserSession($account['email']);

                return response([
                    'message' => 'Account_Registered_successful',
                    'msg_code' => '0sc8v17',
                ]);
            }else {
                return response([
                    'message' => 'Account_not_Found',
                    'msg_code' => '0sc8v14',
                    'message' => "akun tidak terdaftar, silahkan daftar terlebih dahulu!!"
                ]);
            }
        }else if ($users->account_type != 'email') {

            $this->createUserSession($email);

            return response([
                'message' => 'Session_Created_Successfully',
                'msg_code' => '0sc4p25',
            ]);

        }else{

            return response([
                'message' => 'Account_Has_Registered',
                'msg_code' => '0wr8v14',
                'message' => "Akun kamu tidak di daftarkan dengan Akun $account_type, Silahkan login melalui {$users->account_type}!!"
            ]);

        }
    }

    public function createUserSession($email){
        $usersmodel = User::where('email', $email)->first();

        Session::put('email', $usersmodel->email);
        Session::put('first_name', $usersmodel->first_name);
        Session::put('thumbnail', $usersmodel->thumbnail);
        Session::put('status', 1);

        return [
            'message' => 'Session_Created_Successfully',
            'msg_code' => '0sc4p25'
        ];
    }

    public function thirdPartyRegister(Request $request){
        $users = new User();
        $users->email = $request->email;
        $users->username = $request->username;
        $users->account_type = $request->thumbnail;
        $users->save();
    }

    /**
     * Delete Session and Logout
     *
     */
    public function logout()
    {
            Session::flush();
            return \redirect('/');
    }
}
