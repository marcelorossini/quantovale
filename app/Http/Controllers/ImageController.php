<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
	public function index($id_product, $filename)
		{
	    // storage_path('app') - path to /storage/app folder
	    $path = storage_path('app') . '/product/images/'.$id_product.'/'.$filename;
			
	    $file = \File::get($path);
	    $type = \File::mimeType($path);

	    return \Response::make($file,200)
	        ->header("Content-Type", $type);
		}
}
