<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App;
use Auth;
use Helpers;

class AjariController extends Controller
{
	public function __construct()
	{

	}

	public function index()
	{

	}


	public function formField(Request $request)
	{
		$this->validate($request,[
			'id_kategori' => 'required']);

		$id_kategori = $request->id_kategori;

		

		$mapel = app('db')->table('mapel')
						->select(['id_mapel','nama_mapel',])
						->where('id_kategori','=',$id_kategori)
						->where('show','=','1')
						->get();

		$durasi = app('db')->table('durasi')
					->select(['durasi'])
					->where('show','=','1')
					->get();

		$jumlahMurid = app('db')->table('jumlah_murid')
					->select(['jumlah'])
					->where('show','=','1')
					->get();

		return response()->json([
			'status' => 'success',
			'mapel' => $mapel,
			'durasi' => $durasi,
			'jumlah_murid' => $jumlahMurid]);
	}

}

?>