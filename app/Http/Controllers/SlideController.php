<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use Carbon\Carbon;
use File;
use Image;

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
		$this->validate($request, [
			'gambar_slide' 	=> 'required|image|mimes:jpg,png,jpeg|file|max:1024',
			'ket_gambar'	=> 'required',
		],
		[
			'gambar_slide.required' => 'Gambar Banner Slide Belum Dipilih',
			'gambar_slide.image' 	=> 'Gambar Banner Slide Harus Berbentuk File Gambar',
			'gambar_slide.mimes' 	=> 'Ekstensi Yang Diijinkan Harus *.png, *.jpg, *.jpeg',
			'gambar_slide.max'  	=> 'Ukuran File Tidak Boleh Lebih dari 1 MB',
			'ket_gambar.required'	=> 'Keterangan Gambar Harus Diisi',
		]);

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
		$slide->keterangan_slide	= $request->ket_gambar;
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
		//
	}
	
	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id)
	{
		//
	}
	
	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		//
	}

	public function data(Request $request) {
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
			0 =>'id', 
			1 =>'gambar_slide',
			2=> 'keterangan_slide',
			3=> 'id',
		);

		$totalData = Slide::count();

		$totalFiltered = $totalData; 

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');

		if(empty($request->input('search.value')))
		{            
			$slides = Slide::offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
		} 
		else 
		{
			$search = $request->input('search.value'); 

			$slides =  Slide::where('keterangan_slide','LIKE',"%{$search}%")
					->offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();

			$totalFiltered = Slide::where('id','LIKE',"%{$search}%")
							->orWhere('keterangan_slide', 'LIKE',"%{$search}%")
							->count();
		}

		$data = array();
		if(!empty($slides))
		{
			foreach ($slides as $slide)
			{
				// $show =  route('posts.show',$post->id);
				// $edit =  route('posts.edit',$post->id);

				$nestedData['id'] = $slide->id;
				$nestedData['gambar_slide'] = '<img src="../images/slider-main/'.$slide->gambar_slide.'" style="max-width: 100%;">';
				$nestedData['keterangan_slide'] = $slide->keterangan_slide;
				// <a href='{ $show }' ...
				$nestedData['action'] = "<div class='btn-group mb-3' role='group' aria-label='Basic example'>
											<a href='#' class='btn btn-sm btn-primary'><i class='fas fa-edit'></i></a>
											<button type='button' class='btn btn-sm btn-info'><i class='fas fa-eye'></i></button>
											<button type='button' class='btn btn-sm btn-danger'><i class='fas fa-trash-alt'></i></button>
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
}