<?php

use DB;

function CalcValProduct($id)
{
    $aProducVal = DB::table('products_hist')
                  ->select('price_min','price_max')
                  ->where('id_product',$id)
                  ->first();

    return $aProducVal->price_min;
}
