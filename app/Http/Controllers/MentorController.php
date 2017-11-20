<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Carbon\Carbon;
use Mailin;
use App;

class MentorController extends Controller
{

	protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
        $this->basepath = rtrim(preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']), '/api');
        $this->url_destination = $this->basepath.'/api/img/mentor/';
    }

	public function register(Request $request)
	{
		$this->validate($request, [
			'username' => 'required',
			'email' => 'required|unique:users|email',
			'password' => 'required|min:5',
			'telepon' => 'required' ]);

		$request->merge(['password' =>app('hash')->make($request->password)]);


		$input = $request->only(['username','email','password','telepon']);
		$input['create_at'] = Carbon::now();

		$user = app('db')->table('mentors')
						->insert($input);

		return response()->json([
			'status' => 'success',
			'message' => 'Akun mentor berhasil dibuat, segera lakukan aktifasi melalui email Anda']);
	}

	public function uploadFoto(Request $request)
	{
		$this->validate($request,[
			'photo' => 'required|mimes:jpeg,jpg,png,bmp']);

		if($request->hasFile('photo')){
			if($request->file('photo')->isValid()){
				$user = $request->auth_user;

				$photoName = $user->id.'-'.str_slug($user->nama, '-').time().'.'.$request->file('photo')->getClientOriginalExtension();

				$destination = $this->url_destination;
				try{
					$request->file('photo')->move(
						$destination,
						$photoName);
					app('db')->table('users')
						->where('id','=','1')
						->update(['path_foto' => $photoName]);
					
				}catch(\Exception $e){
					return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
				}

				$user = App\User::where('email', $request->input('email'))->first();

				return response()->json([
	            	'status' => 'success',
	            	'message' => 'berhasil upload'
       			 ]);


			}
		}
	}

	public function login(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email|max:255',
			'password' => 'required',]);

		try{
			if(! $token = $this->jwt->attempt($request->only('email','password'))){
				return response()->json([
					'status' => 'fail',
					'message' => 'email atau password salah']);
			}
		}catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
			 return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan sistem.']);
		}

		 $mentor = App\Mentor::where('email', $request->input('email'))->first();

		 if($mentor==null){
		 	return response()->json([
		 		'status' => 'fail',
		 		'message' => 'email dan password tidak valid']);
		 }

		return response()->json([
            'status' => 'success',
            'token' => $token,
            'data' => $mentor
        ]);
	}

}


?>