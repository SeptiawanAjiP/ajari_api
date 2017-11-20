<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Carbon\Carbon;
use Mailin;
use App;
use App\Ajari;
use Helpers;

class UserController extends Controller
{

	protected $jwt;

	
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
        $this->basepath = rtrim(preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']), '/api');
        $this->url_destination = $this->basepath.'/api/img/user/';
        $this->base_url = "http://localhost/ajari/img/user/";

    }

	public function login(Request $request)
	{
		$this->validate($request,[
			'type' => 'required']);

		if($request->type=='fb'){
			$this->validate($request,[
    		'email' => 'required',
    		'username' => 'required']);
    		$input = $request->only(['email','username']);

    		$input['qr_code'] = sha1(mt_rand(10000,99999).time().$input['email']);
    		$input['path_foto'] = '';
			$input['create_at'] = Carbon::now();

    		$user = App\User::withoutGlobalScopes()->where('email', $request->input('email'))->first();

    		if($user==null){
    			app('db')->table('users')
						->insert($input);
				$user = App\User::withoutGlobalScopes()->where('email', $request->input('email'))->first();		
    		}

    		return response()->json([
		            'status' => 'success',
		            'token' => $this->jwt->fromUser($user),
		            'data' => $user
        		]);

		}else if($request->type == 'google'){
			$this->validate($request,[
				'email' => 'required',
				'username' => 'required']);

			$input = $request->only(['email','username']);
			$input['qr_code'] = sha1(mt_rand(10000,99999).time().$input['email']);
    		$input['path_foto'] = '';
			$input['create_at'] = Carbon::now();

			$user = App\User::withoutGlobalScopes()->where('email', $request->input('email'))->first();

    		if($user==null){
    			app('db')->table('users')
						->insert($input);
				$user = App\User::withoutGlobalScopes()->where('email', $request->input('email'))->first();		
    		}

    		return response()->json([
		            'status' => 'success',
		            'token' => $this->jwt->fromUser($user),
		            'data' => $user
        	]);
		}else if($request->type == 'telepon'){
			$this->validate($request,[
				'telepon' => 'required']);
			$user = App\User::withoutGlobalScopes()->where('telepon', $request->input('telepon'))->first();

			if($user==null){
    			return response()->json([
		            'status' => 'fail',
		            'message' => 'Nomor telepon belum terdaftar di Ngajar.in'
        		]);		
    		}else{
    			return response()->json([
		            'status' => 'success',
		            'message' => 'Nomor telah terdaftar, sistem akan melakukan verifikasi melalui sms'
        		]);
    		}
		}
	}

	public function getDataPhone(Request $request)
	{
		$this->validate($request,[
			'telepon' => 'required',
			'id_verification' => 'required']);
		$user = App\User::withoutGlobalScopes()->where('telepon', $request->input('telepon'))->first();

		if($user==null){
    		return response()->json([
		            'status' => 'fail',
		            'message' => 'Nomor telepon belum terdaftar di Ngajar.in'
        		]);		
    	}else{
    		return response()->json([
		            'status' => 'success',
		            'token' => $this->jwt->fromUser($user),
		            'data' => $user
        	]);	
    	}

	}

	public function registerPhone(Request $request)
	{
		$this->validate($request,[
			'username' => 'required',
			'email' => 'required',
			'telepon' => 'required|unique:users',
			'id_verification' => 'required']);

		$input = $request->only(['username','email','telepon','id_verification']);
		$input['qr_code'] = sha1(mt_rand(10000,99999).time().$input['telepon']);
    	$input['path_foto'] = '';
    	$input['type'] = 'phone';
		$input['create_at'] = Carbon::now();

		app('db')->table('users')
						->insert($input);
		$user = App\User::withoutGlobalScopes()->where('telepon', $request->input('telepon'))->first();	
		return response()->json([
		            'status' => 'success',
		            'token' => $this->jwt->fromUser($user),
		            'data' => $user
        	]);

	}


	public function uploadFoto(Request $request)
	{
		$this->validate($request,[
			'photo' => 'required|mimes:jpeg,jpg,png,bmp']);

		if($request->hasFile('photo')){
			if($request->file('photo')->isValid()){
				$user = $request->auth_user;

				$photoName = $user->id.'-user-'.str_slug($user->nama, '-').time().'.'.$request->file('photo')->getClientOriginalExtension();

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

	public function userPoin(Request $request)
	{
		$id_user = $request->auth_user->id;

		$penimbang = 5;

		$tot = app('db')->table('booking')
					->select(['id_booking'])
					->where('id_user','=',$id_user)
					->count();

		return response()->json([
			'status' => 'success',
			'poin' => $tot*$penimbang]);
	}

	public function logout()
	{
		try{
			$logout = false;
			$this->jwt->invalidate($logout);
		}catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            // return response()->json(['token_expired'], 500);
            return response()->json(['status' => 'success', 'message' => 'Berhasil Logout.']);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['status' => 'fail', 'message' => 'Token Invalid.']);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['status' => 'fail' ,'message' => $e->getMessage()]);

        } catch (\Exception $e){
            return response()->json(['status' => 'fail' ,'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil Logout.']);
	}

	
}


?>