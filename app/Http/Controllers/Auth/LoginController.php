<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Notifications\VerifyRegistation;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


/*
  
  @override login function

*/

    public function login(Request $request){

    $this->validate($request,[

    'email' => 'required|email',
    'password'  => 'required',

    ]);

   //find user by this email

    $user =User::Where('email',$request->email)->first();

    if($user->status== 1){

    //login the user

         if(Auth::guard('web')->attempt(['email'=>$request->email,'password'=>$request->password],$request->remember)){
             return redirect()->intended(route('index'));
          }
          else{
             session()->flash('error', 'Invalid Login !!');
            return redirect()->route('login');
          }
       }

    else {
      // Send him a token again
      if (!is_null($user)) {

        // $user->notify(new VerifyRegistation($user));

        Mail::to($user->email)->send(new VerificationEmail($user));
     
        session()->flash('success', 'A New confirmation email has sent to you.. Please check and confirm your email');
        return redirect()->route('login');
      }

      else {

        session()->flash('errors', 'Please login first !!');
        return redirect()->route('login');
      }
    }

    }
    
    
    /*------------------------------------------------------------------------------Gooogle Login ------------------------------------------------*/
    
    
    public function googleLogin(){
        return Socialite::driver('google')->redirect();
    }
    
    
    public function googleLoginCallback(){
        $google_user = Socialite::driver('google')->user();
        $finduser  = User::where('email',$google_user->email)->first();
        if($finduser){
           Auth::guard('web')->login($finduser);
          return redirect()->intended(route('index'));
        }else{
            $user = new User();
            $user->firstname = $google_user->user['given_name'];
            $user->lastname = $google_user->user['family_name'];
            $user->username = $google_user->name;
            $user->password = Hash::make('12345');
            $user->email = $google_user->email;
            $user->avatar = $google_user->avatar;
            $user->remember_token = $google_user->token;
            $user->save();
            
            Auth::guard('web')->login($user);
            
          return redirect()->intended(route('index'));
        }
        
    }
    
     /*------------------------------------------------------------------------------Facebook Login ------------------------------------------------*/
    
    public function facebookLogin(){
         return Socialite::driver('facebook')->redirect();
    }
    
    
    public function facebookLoginCallback(){
        
        $facebook_user = Socialite::driver('facebook')->user();
        
        $finduser  = User::where('email',$facebook_user->email)->first();
        if($finduser){
           Auth::guard('web')->login($finduser);
          return redirect()->intended(route('index'));
        }else{
            $user = new User();
            
            $fullname = $facebook_user->name;
            $fullname_array = $array = explode(' ', $fullname);
            
            $user->firstname = $fullname_array[0];
            $user->lastname = $fullname_array[1];
            $user->username = $fullname;
            $user->password = Hash::make('12345');
            $user->email = $facebook_user->email;
            $user->avatar = $facebook_user->avatar;
            $user->save();
            
            Auth::guard('web')->login($user);
            
          return redirect()->intended(route('index'));
        }
        
    }
    
    
    
      /*------------------------------------------------------------------------------Github Login ------------------------------------------------*/
    
    public function githubLogin(){
         return Socialite::driver('github')->redirect();
    }
    
    
    public function githubLoginCallback(){
        
        $github_user = Socialite::driver('github')->user();
       
        $finduser  = User::where('email',$github_user->email)->first();
        if($finduser){
           Auth::guard('web')->login($finduser);
          return redirect()->intended(route('index'));
        }else{
            $user = new User();
            
            $fullname = $github_user->name;
            $fullname_array = $array = explode(' ', $fullname);
            
            $user->firstname = $fullname_array[0];
            $user->lastname = $fullname_array[1];
            $user->username = $fullname;
            $user->password = Hash::make('12345');
            $user->email = $github_user->email;
            $user->avatar = $github_user->avatar;
            $user->save();
            
            Auth::guard('web')->login($user);
            
          return redirect()->intended(route('index'));
        }
        
    }
    
    
    
      /*------------------------------------------------------------------------------Linkedin Login ------------------------------------------------*/
    
    public function linkedinLogin(){
         return Socialite::driver('linkedin')->redirect();
    }
    
    
    public function linkedinLoginCallback(){
        
        $linkedin_user = Socialite::driver('linkedin')->user();
        
        $finduser  = User::where('email',$linkedin_user->email)->first();
        if($finduser){
           Auth::guard('web')->login($finduser);
          return redirect()->intended(route('index'));
        }else{
            $user = new User();
            
            $fullname = $linkedin_user->name;
            $fullname_array = $array = explode(' ', $fullname);
            
            $user->firstname = $fullname_array[0];
            $user->lastname = $fullname_array[1];
            $user->username = $fullname;
            $user->password = Hash::make('12345');
            $user->email = $linkedin_user->email;
            $user->avatar = $linkedin_user->avatar;
            $user->save();
            
            Auth::guard('web')->login($user);
            
          return redirect()->intended(route('index'));
        }
        
    }
    
    
    
      /*------------------------------------------------------------------------------Instagram Login ------------------------------------------------*/
      
      
      //scoialite driver does not provide instagram login service, so we use instagram api call
      
    
    public function instagramLogin(){
         
           $appId = config('services.instagram.client_id');
           $redirectUri = urlencode(config('services.instagram.redirect'));
           return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");
    }
    
    
    public function instagramLoginCallback(Request $request){
        
     $code = $request->code;
     
    if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Instagram.');

        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');
    
        $client = new Client();
    
        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => $appId,
                'app_secret' => $secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]
        ]);
        
      
    
        if ($response->getStatusCode() != 200) {
            return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
        }
    
        $content = $response->getBody()->getContents();
        $content = json_decode($content);
    
        $accessToken = $content->access_token;
        $userId = $content->user_id;
    
        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");
    
        $content = $response->getBody()->getContents();
        $oAuth = json_decode($content);
    
        // Get instagram user name 
        $username = $oAuth->username;
        
        $users = ['email'=>$username,'token'=>$userId,'username'=>$username];
        
        $users = (object) $users;
        
         $finduser  = User::where('email',$users->email)->first();
        if($finduser){
           Auth::guard('web')->login($finduser);
           return redirect()->intended(route('index'));
        }else{
            $user = new User();
            $user->username = $users->username;
            $user->password = Hash::make('12345');
            $user->email = $users->email;
            $user->save();
            
            Auth::guard('web')->login($user);
            
            return redirect()->intended(route('index'));
        }
        
         
        
    }




}
