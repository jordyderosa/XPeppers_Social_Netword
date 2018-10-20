<?php 
namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function getWelcome()
    {
        return view('welcome');
    }

    public function SignUp(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:users',
            'name' => 'required|max:120',
            'password' =>'required|min:4'
        ]);
        $email=$request['email'];
        $name=$request['name'];
        $password=bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = $password;
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }
    public function SignIn(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' =>'required'
        ]);


        if(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']]))
        {
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}