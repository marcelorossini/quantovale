<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
	public function index($id_product, $filename)
		{
			try {
				$path = storage_path('app') . '/product/images/'.$id_product.'/'.$filename;
				$file = \File::get($path);
			} catch (\Exception $e) {
				$path = storage_path('app') . '/product/product-error.jpg';
				$file = \File::get($path);
			}
			$type = \File::mimeType($path);

			return \Response::make($file,200)
					->header("Content-Type", $type);
		}
}
