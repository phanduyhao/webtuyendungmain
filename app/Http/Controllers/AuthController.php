<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function showRegister(){
        return view('auth.register',[
            'title' => 'Đăng ký tài khoản',
        ]);
    }

    /**
     * Đăng ký tài khoản.
     * @param Request $request
     */
    public function register(Request $request)
    {
       // Validate the request
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password'
        ], [
            'name.required' => 'Vui lòng nhập tên của bạn!',
            'email.required' => 'Vui lòng nhập email!',
            'email.email' => 'Email không hợp lệ!',
            'email.unique' => 'Email đã tồn tại!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'confirmPassword.required' => 'Vui lòng xác nhận mật khẩu!',
            'confirmPassword.same' => 'Mật khẩu xác nhận không khớp!'
        ]);
        $confirmPass = $request->confirmPassword;
        $pass = $request->password;
        if ($confirmPass == $pass) {
            // Kiểm tra xem email đã tồn tại chưa
            $emailExists = User::where('email', $request->email)->exists();

            if (!$emailExists) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role_id = $request->type;
                $user->save();
                Auth::login($user);
            } else {
                return back()->with('error', 'Email đã tồn tại');
            }
        } else {
            return back()->with('error', 'Xác nhận lại mật khẩu !');
        }
        return redirect('/'); // Điều hướng sau khi đăng ký
    }

    
    public function showLogin(){
        return view('auth.login',[
            'title' => 'Đăng nhập'
        ]);
    }

    /**
     * Đăng nhập.
     * @param Request $request
     */
   
     public function login(Request $request)
     {
         // Validate email và password
         $this->validate($request, [
             'email' => 'required|email',
             'password' => 'required',
         ], [
             'email.required' => 'Vui lòng nhập email !',
             'password.required' => 'Vui lòng nhập mật khẩu !',
             'email.email' => 'Email không hợp lệ'
         ]);
     
         // Lấy thông tin email và password
         $credentials = $request->only('email', 'password');
     
         // Kiểm tra thông tin đăng nhập
         if (Auth::attempt($credentials)) {
             // Đăng nhập thành công
             return redirect()->intended('/')->with('success', 'Đăng nhập thành công');
         }
     
         // Đăng nhập thất bại, trả về thông báo lỗi
         return back()->withErrors([
             'email' => 'Email hoặc mật khẩu không đúng',
         ])->withInput($request->only('email'));
     }

     public function showForgotPass(){
         return view('auth.forgotPass',[
             'title' => 'Quên mật khẩu'
         ]);
     }

     public function sendMailForgotPass(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ],[
            'email.required' => 'Vui lòng nhập email !',
            'email.exists' => 'Email không tồn tại !',
        ]);
    
        $token = Str::random(64);
    
        // Lưu token vào bảng password_resets
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);
    
        // Gửi email
        Mail::send('auth.emailResetPassword', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu');
        });
    
        return back()->with('success', 'Email đặt lại mật khẩu đã được gửi.');
    }

    public function showResetPassword($token) {
        return view('auth.resetPassword', ['token' => $token, 'title' => 'Đặt lại mật khẩu']);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);
    
        // Tìm email từ token
        $reset = DB::table('password_resets')->where('token', $request->token)->first();
    
        if (!$reset) {
            return back()->withErrors(['token' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }
    
        // Cập nhật mật khẩu
        $user = \App\Models\User::where('email', $reset->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
        }
    
        $user->password = bcrypt($request->password);
        $user->save();
    
        // Xóa token sau khi sử dụng
        DB::table('password_resets')->where(['email' => $reset->email])->delete();
    
        return redirect()->route('login')->with('success', 'Mật khẩu của bạn đã được đặt lại thành công.');
    }
    

    /**
     * Đăng xuất.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLogin');    
    }
}
