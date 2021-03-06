<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SlideController extends Controller
{
	public $path;

	public function __construct()
	{
		//Path Gambar
		$this->pathGambar = public_path('/images/slider-main');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('panel.banner');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate(
			$request,
			[
				'gambar_slide' 	=> 'required|image|mimes:jpg,png,jpeg|file|max:1024',
				'ket_gambar'	=> 'required',
			],
			[
				'gambar_slide.required' => 'Gambar Banner Slide Belum Dipilih',
				'gambar_slide.image' 	=> 'Gambar Banner Slide Harus Berbentuk File Gambar',
				'gambar_slide.mimes' 	=> 'Ekstensi Yang Diijinkan Harus *.png, *.jpg, *.jpeg',
				'gambar_slide.max'  	=> 'Ukuran File Tidak Boleh Lebih dari 1 MB',
				'ket_gambar.required'	=> 'Keterangan Gambar Harus Diisi',
			]
		);

		// Proses Gambar Banner Slide
		if (!File::isDirectory($this->pathGambar)) {
			// Buat Folder slider-main dalam folder image
			File::makeDirectory($this->pathGambar, 0777, true, true);
		}

		$gambar_slide = $request->file('gambar_slide');
		if ($request->hasFile('gambar_slide')) {
			$fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $gambar_slide->getClientOriginalExtension();
			Image::make($gambar_slide)->resize(1600, 800)->save($this->pathGambar . '/' . $fileName);
		} else {
			$fileName = '';
		}

		$slide 						= new Slide;
		$slide->gambar_slide 		= $fileName;
		$slide->keterangan_slide	= strip_tags($request->ket_gambar);
		$slide->save();

		return redirect('/panel/slide')->with('sukses', 'Data Banner Slide Berhasil Disimpan');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$slides = Slide::find($id);
		return response()->json($slides);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$this->validate(
			$request,
			[
				'gambar_slide_edit' 	=> 'image|mimes:jpg,png,jpeg|file|max:1024',
				'ket_gambar_edit'		=> 'required'
			],
			[
				'gambar_slide_edit.image' 		=> 'Gambar Banner Slide Harus Berbentuk File Gambar',
				'gambar_slide_edit.mimes' 		=> 'Ekstensi Yang Diijinkan Harus *.png, *.jpg, *.jpeg',
				'gambar_slide_edit.max'  		=> 'Ukuran File Tidak Boleh Lebih dari 1 MB',
				'ket_gambar_edit.required'		=> 'Keterangan Gambar Harus Diisi'
			]
		);

		// Proses Gambar Banner Slide
		if (!File::isDirectory($this->pathGambar)) {
			// Buat Folder slider-main dalam folder image
			File::makeDirectory($this->pathGambar, 0777, true, true);
		}

		$gambar_slide = $request->file('gambar_slide_edit');
		if ($request->hasFile('gambar_slide_edit')) {
			$fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $gambar_slide->getClientOriginalExtension();
			Image::make($gambar_slide)->resize(1600, 800)->save($this->pathGambar . '/' . $fileName);
		} else {
			$fileName = '';
		}

		$id 			= $request->idEdit;
		$ket_slide 		= strip_tags($request->ket_gambar_edit);
		// $status_tampil 	= $request->status_tampil_edit;

		$slide = Slide::find($id);

		// Jika Gambar Banner Slide diubah
		if ($gambar_slide) {
			// Hapus Foto Banner Slide di Folder slider-main
			File::delete($this->pathGambar . '/' . $slide->gambar_slide);

			$slide->gambar_slide = $fileName;
		}

		$slide->keterangan_slide	= strip_tags($ket_slide);
		// $slide->status_tampil	= $status_tampil;
		$slide->update();

		return redirect('/panel/slide')->with('sukses', 'Data Banner Slide Berhasil Diubah');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$id    = $request->idDelete;

		$slide = Slide::find($id);

		// Hapus Foto Banner Slide di Folder slider-main
		File::delete($this->pathGambar . '/' . $slide->gambar_slide);

		$slide->delete();

		return redirect('/panel/slide')->with('sukses', 'Data Banner Slide Berhasil Dihapus');
	}

	public function data(Request $request)
	{
		// $data = Slide::latest()->get();
		// return datatables($data)
		//     ->addColumn('action', function($data) {
		//         $tombol = 
		//                     '<button type="button" class="btn btn-sm btn-primary"><i
		// 					class="fas fa-edit"></i></button>
		// 					<button type="button" class="btn btn-sm btn-info"><i
		// 					class="fas fa-eye"></i></button>
		// 					<button type="button" class="btn btn-sm btn-danger"><i
		// 					class="fas fa-trash-alt"></i></button>';
		//         return $tombol;
		//     })
		//     ->rawColumns(['action'])
		//     ->make(true);

		$columns = array(
			0 => 'id',
			1 => 'gambar_slide',
			2 => 'keterangan_slide',
			3 => 'status_tampil',
		);

		$totalData = Slide::count();

		$totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');

		if (empty($request->input('search.value'))) {
			$slides = Slide::offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();
		} else {
			// $search = $request->input('search.value');
			$search = implode('* ', explode(' ', $request->input('search.value'))) . '*';

			$slides = Slide::whereRaw("MATCH (keterangan_slide) AGAINST(? IN BOOLEAN MODE)", array($search))
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();
			// $slides = Slide::where('keterangan_slide','LIKE',"%{$search}%")
			// 		->offset($start)
			// 		->limit($limit)
			// 		->orderBy($order, $dir)
			// 		->get();

			$totalFiltered = Slide::whereRaw("MATCH (keterangan_slide) AGAINST(? IN BOOLEAN MODE)", array($search))
				->count();

			// $totalFiltered = Slide::where('id','LIKE',"%{$search}%")
			// 				->orWhere('keterangan_slide', 'LIKE',"%{$search}%")
			// 				->count();
		}

		$data = array();
		if (!empty($slides)) {
			foreach ($slides as $slide) {
				$nestedData['id'] = $slide->id;
				$nestedData['gambar_slide'] = '<img src="../images/slider-main/' . $slide->gambar_slide . '" style="max-width: 100%;">';
				$nestedData['keterangan_slide'] = $slide->keterangan_slide;
				$nestedData['status_tampil'] = $slide->status_tampil == 1 ?
					"<button type='button' class='btn btn-sm btn-success' onClick='editStatus(" . $slide->id . ")'><i class='fas fa-eye'></i></button>" :
					"<button type='button' class='btn btn-sm btn-danger' onClick='editStatus(" . $slide->id . ")'><i class='fas fa-eye-slash'></i></button>";
				$nestedData['action'] = "<div class='btn-group mb-3' role='group' aria-label='Basic example'>
											<button type='button' class='btn btn-sm btn-primary' onClick='editBanner(" . $slide->id . ")' title='Edit Data Banner Slide'><i class='fas fa-edit'></i></button>
											<button type='button' class='btn btn-sm btn-danger' onClick='hapusBanner(" . $slide->id . ",\"" . $slide->gambar_slide . "\")' title='Hapus Data Banner Slide'><i class='fas fa-trash-alt'></i></button>
										</div>";
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function update_status($id)
	{
		$slide = Slide::find($id);
		$status = $slide->status_tampil == '1' ? '0' : '1';

		$slide->status_tampil = $status;
		$slide->update();
	}
}