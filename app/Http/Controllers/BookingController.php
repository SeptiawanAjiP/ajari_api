<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Carbon\Carbon;
use Mailin;
use App;
use BothController;


class BookingController extends Controller
{
	public function __construct()
	{

	}

	public function calculate($durasi,$murid)
	{
		$weightDurasi = 30000;
		$weigthMurid = 15000;
		$discount = 5000;
		

		if($durasi==1){
			$total = $weightDurasi+(($murid-1)*$weigthMurid);
		}else if($durasi>=1 && $murid==1){
			$total = $weightDurasi*$durasi;
		}else if($durasi>=1 && $murid>=1){
			$total = ($weightDurasi*$durasi)+(($weigthMurid-5000)*$murid);
		}

		return $total;
	}

	public function price(Request $request)
	{
		$this->validate($request,[
			'durasi' => 'required',
			'jumlah_murid' => 'required']);
		$durasi = $request->durasi;
		$murid = $request->jumlah_murid;

		$total = BookingController::calculate($durasi,$murid);

		return response()->json([
			'status' => 'success',
			'total' => $total]);
	}



	public function formBook(Request $request)
	{
		$this->validate($request,[
			'id_mapel' => 'required',
			'tanggal' => 'required',
			'jam_mulai' => 'required',
			'durasi' => 'required',
			'jumlah_siswa' => 'required',
			'alamat' => 'required',
			'catatan' => 'required']);

		$durasi = $request->durasi;
		$murid = $request->jumlah_siswa;

		$biaya = BookingController::calculate($durasi,$murid);

		
		$input = $request->only(['id_mapel','tanggal','jam_mulai','durasi','jumlah_siswa','alamat','catatan']);
		$input['kode_booking'] = sha1(mt_rand(10000,99999).time().$input['id_mapel'].$input['tanggal'].$input['jam_mulai']);
		$input['id_user'] = $request->auth_user->id;
		$input['biaya']  = $biaya;
		$input['status'] = 'tunggu';

		app('db')->table('booking')
				->insert($input);

		$mapel = app('db')->table('mapel')
					->select('mapel.nama_mapel','kategori.nama_kategori')
					->from('mapel')
					->join('kategori','kategori.id_kategori','=','mapel.id_kategori')
					->where('mapel.id_mapel','=',$request->id_mapel)
					->first();
		

		$data['pemesan'] = $request->auth_user->username;
		$data['telepon'] = $request->auth_user->telepon;
		$data['mapel'] = $mapel->nama_mapel;
		$data['kategori'] = $mapel->nama_kategori;
		$data['tanggal'] = $request->tanggal;
		$data['jam_mulai'] = $request->jam_mulai;
		$data['alamat'] = $request->alamat;
		$data['catatan'] = $request->catatan;
		$data['durasi'] = $request->durasi;

		BookingController::sendBook($data);

		return response()->json([
			'status' => 'success',
			'message' => 'sukses booking']);
		
	}

	public function terimaBook(Request $request)
	{
		$this->validate($request,[
			'id_booking' => 'required',
			'id_mentor' => 'required']);

		app('db')->table('booking')
				->where('id_booking','=',$request->auth_user->id)
				->update(['status' => 'konfirmasi', 'id_mentor'=> $request->id_mentor]);

		return response()->json([
			'status' => 'success',
			'message' => 'sukses terima booking']);
	}

	public function batalBook(Request $request)
	{
		$this->validate($request,[
			'id_booking' => 'required']);


		app('db')->table('booking')
				->where('id_booking','=',$request->auth_user->id)
				->update(['status' => 'batal']);

		return response()->json([
			'status' => 'success',
			'message' => 'sukses tolak booking']);
	}

	public function sendBook($data)
	{
		$text = 'pemesan : '.$data['pemesan'].'
		telepon : '.$data['telepon'].'
		mapel : '.$data['kategori'].' | '.$data['mapel'].'
		tanggal : '.$data['tanggal'].'
		jam_mulai : '.$data['jam_mulai'].'
		durasi : '.$data['durasi'].'
		alamat : '.$data['alamat'].'
		catatan : '.$data['catatan'];
		
		$text = urlencode($text);
			
		$service_telegram = 'https://api.telegram.org/bot454317236:AAGHadU7UOHNTRtbjyibiGCTI0KzjPMXyVc/sendMessage?chat_id=476800148&text='.$text;
		$responseJson = file_get_contents($service_telegram);
		$response = json_decode($responseJson);

		return response()->json($response);
	}


	public function listBook(Request $request)
	{
		$id_user = $request->auth_user->id;

		$book = app('db')->table('booking')
					->select(['booking.id_booking','kategori.nama_kategori','mapel.nama_mapel','booking.status','booking.tanggal','booking.jam_mulai'])
					->from('mapel')
					->join('booking','booking.id_mapel','=','mapel.id_mapel')
					// ->join('mentors','mentors.id_mentor','=','booking.id_mentor')
					->join('kategori','kategori.id_kategori','=','mapel.id_kategori')
					->where('booking.id_user','=',$id_user)
					->whereIn('booking.status',['tunggu','konfirmasi'])
					->get();

		for($i=0;$i<count($book);$i++){
			if($book[$i]->status=='tunggu' || $book[$i]->status=='konfirmasi')
			{
				$book[$i]->mentor='';
				$book[$i]->path_foto='';
			}else{
				$mentor = app('db')->table('booking')
								->select(['mentors.username','mentors.path_foto'])
								->from('booking')
								->join('mentors','mentors.id_mentor','=','booking.id_mentor')
								->where('id_booking','=',$book[$i]->id_booking)
								->first();
				$book[$i]->mentor = $mentor->username;
				$book[$i]->mentor_foto =$mentor->path_foto;
			}
		}

		return response()->json([
			'status'=>'success',
			'list' => $book]);
	}

	public function listHistoryBook(Request $request)
	{
		$id_user = $request->auth_user->id;

		$book = app('db')->table('booking')
					->select(['booking.id_booking','kategori.nama_kategori','mapel.nama_mapel','booking.status','booking.tanggal','booking.jam_mulai'])
					->from('mapel')
					->join('booking','booking.id_mapel','=','mapel.id_mapel')
					// ->join('mentors','mentors.id_mentor','=','booking.id_mentor')
					->join('kategori','kategori.id_kategori','=','mapel.id_kategori')
					->where('booking.id_user','=',$id_user)
					->whereIn('booking.status',['selesai','tolak'])
					->get();

		for($i=0;$i<count($book);$i++){
			if($book[$i]->status=='selesai'||$book[$i]->status=='tolak')
			{
				$book[$i]->mentor='';
				$book[$i]->path_foto='';
			}else{
				$mentor = app('db')->table('booking')
								->select(['mentors.username','mentors.path_foto'])
								->from('booking')
								->join('mentors','mentors.id_mentor','=','booking.id_mentor')
								->where('id_booking','=',$book[$i]->id_booking)
								->first();
				$book[$i]->mentor = $mentor->username;
				$book[$i]->mentor_foto =$mentor->path_foto;
			}
		}

		return response()->json([
			'status'=>'success',
			'list' => $book]);
	}


}

?>