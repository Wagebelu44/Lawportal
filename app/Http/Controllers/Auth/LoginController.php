<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Validator;
use App\Attendence;
use App\Logged_detail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $data = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ])->validate();

        $credentials = $request->all();
        $remember = false;
        if(isset($credentials['remember']) && $credentials['remember'] == 'on') {
            $remember = true;
        }
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'active' => 1], $remember)) {
            $userrole_id = get_usermeta( Auth::user()->id, '_userrole_id' );

            $logged_detail = new Logged_detail;
            $logged_detail->user_id = Auth::user()->id;
            $logged_detail->logged_at = date('Y-m-d H:i:s');
            $logged_detail->save();

            $request->session()->put('logged_detail_id', $logged_detail->id);

            if(Auth::user()->id != 29) {
                $user_attendence = Attendence::select('id')->whereDate('logged_at', date('Y-m-d') )->where('user_id', Auth::user()->id)->get()->toArray();

                if(empty($user_attendence)) {

                    
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    
                    $response = Http::get('https://ipapi.co/json/');

                    if( $response->getStatusCode() == 200 ){

                        $fileContents = $response->getBody();

                        $obj = json_decode($fileContents);

                    }

                    $city   = isset($obj->city) ? $obj->city : '';
                    $region = isset($obj->region) ? $obj->region : '';
                    $country = isset($obj->country_name) ? $obj->country_name : '';
                    $postal = isset($obj->postal) ? $obj->postal : '';
                    $latitude = isset($obj->latitude) ? $obj->latitude : '';
                    $longitude = isset($obj->longitude) ? $obj->longitude : '';
                    $ip = isset($obj->ip) ? $obj->ip : '';
                   
                    $attendence = new Attendence;
                    $attendence->user_id = Auth::user()->id;
                    $attendence->user_ip = $ip;
                    $attendence->city = $city;
                    $attendence->region = $region;
                    $attendence->country = $country;
                    $attendence->postal = $postal;
                    $attendence->latitude = $latitude;
                    $attendence->longitude = $longitude;
                    $attendence->user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $attendence->logged_at = date('Y-m-d H:i:s');

                    $attendence->save();

                    session()->flash("attendeeSuccessMsg", "Your attendence has been taken");
                }
            }
            
            return redirect()->intended('/');
        }else {
            session()->flash("loginErrorMsg", "Wrong Credentials");
            return redirect('login');
        }   
    }

    public function logout(Request $request)
    {

        $attendence = Attendence::whereDate('logged_at', date('Y-m-d'))->first();
        if($attendence) {
            $attendence->logged_at = date('Y-m-d H:i:s', strtotime($attendence->logged_at));
            if(empty($attendence->logged_out_at)) {
                $attendence->logged_out_at = date('Y-m-d H:i:s');
            }
            $attendence->save();
        }

        if ($request->session()->has('logged_detail_id')) {
            $logged_detail_id = $request->session()->get('logged_detail_id');
            $logged_detail = Logged_detail::find($logged_detail_id);
            $logged_detail->logged_at = date('Y-m-d H:i:s', strtotime($logged_detail->logged_at));
            if(empty($logged_detail->logged_out_at)) {
                $logged_detail->logged_out_at = date('Y-m-d H:i:s');
            }
            $logged_detail->save();
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }
}
