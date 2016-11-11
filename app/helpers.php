<?php

use Illuminate\Support\Facades\DB;

function CalcValProduct($id)
{
    $aProducVal = DB::table('products_hist')
                  ->select('price_min','price_max')
                  ->where('id_product',$id)
                  ->first();

    $nValor = 0;
    if (isset($aProducVal->price_min) && $aProducVal->price_min > 0) {
        $nValor = $aProducVal->price_min;
    } elseif (isset($aProducVal->price_max) && $aProducVal->price_max > 0) {
        $nValor = $aProducVal->price_max;
    }

    return $nValor;
}
