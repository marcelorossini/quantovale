<?php

use Illuminate\Support\Facades\DB;

function CalcValProduct($id)
{
    $aProducVal = DB::table('products_hist')
                  ->select('price_min','price_max')
                  ->where('id_product',$id)
                  ->first();

    $nValor = 0;
    if (isset($aProducVal->price_min)) {
        $nValor = $aProducVal->price_min;
    } elseif (isset($aProducVal->price_max)) {
        $nValor = $aProducVal->price_max;
    }

    return $nValor;
}
