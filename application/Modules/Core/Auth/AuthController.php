<?php


namespace Application\Modules\Core\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return Inertia::render('Core/Auth/Login');
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed In');
        }

        return redirect('login')->withSuccess('Login Details are invalid');
    }

//    public function registration()
//    {
//        return view('auth.registration');
//    }
//
//    public function customRegistration(Request $request)
//    {
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|min:6',
//        ]);
//
//        $data = $request->all();
//        $check = $this->create($data);
//
//        return redirect("dashboard")->withSuccess('You have signed-in');
//    }

//    public function create(array $data)
//    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password'])
//        ]);
//    }

    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }

}