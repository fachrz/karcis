<?php

namespace App\Http\Controllers;

use Lcobucci\JWT\Builder;
use Illuminate\Http\Request;
use App\UsersModel;
use App\kc_users_model;
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
     * Register Request
     * 
     * method ini bertangung jawab dalam menerima request untuk registrasi.
     * method ini tidak melakukan registrasi.
     */
    public function registerRequest(Request $request)
    {

        $account = [
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'first_name' => $request->input('first-name'),
            'last_name' => $request->input('last-name'),
            'telp' => $request->input('telp'),
            'account_type' => 'email',
        ];

        $accountCheck = $this->accountCheck($account['email']);

        if ($accountCheck == null) {
            $register = $this->accountRegister($account);

            if ($register['msg_code'] == '0sc8v14') {
                 return redirect('/register')->with(['Success' => 'Pendaftaran Berhasil Silahkan Login!']);
            }else{
                 return redirect('/register')->with(['Error' => 'Pendaftaran Berhasil Silahkan Login!']);
            }
        }else{
            return redirect('/register')->with(['Error' => 'Maaf Email telah terdaftar']);
        }
    }

    /**
     * Register Account
     * 
     * method ini bertangung jawab untuk melakukan registrasi akun
     */
    public function accountRegister(array $account)
    {

        $user = kc_users_model::create($account);

        if ($user) {
            return [
                'message' => 'Account_Registered_Success',
                'msg_code' => '0sc8v14'
            ];
        }else{
            return [
                'message' => 'Account_Registered_Failed',
                'msg_code' => '0er8v14'
            ];
        }
    }

    /**
     * Account Check
     * 
     * Method ini bertangung jawab untuk melakukan check akun yang terdaftar
     */
    public function accountCheck($email){

        $users = kc_users_model::select('email', 'account_type', 'password')->where('email', $email)->first();

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
        $usersmodel = kc_users_model::where('email', $email)->first();

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
        $users = new kc_users_model();
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
