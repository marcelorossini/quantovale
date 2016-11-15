<?php

use Illuminate\Support\Facades\DB;

function CalcValProduct($id) {
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

function Mes($nMes) {
    if ($nMes == 1) {
        $sMes = "Janeiro";
    } elseif ($nMes == 2) {
        $sMes = "Fevereiro";
    } elseif ($nMes == 3) {
        $sMes = "Março";
    } elseif ($nMes == 4) {
        $sMes = "Abril";
    } elseif ($nMes == 5) {
        $sMes = "Maio";
    } elseif ($nMes == 6) {
        $sMes = "Junho";
    } elseif ($nMes == 7) {
        $sMes = "Julho";
    } elseif ($nMes == 8) {
        $sMes = "Agosto";
    } elseif ($nMes == 9) {
        $sMes = "Setembro";
    } elseif ($nMes == 10) {
        $sMes = "Outubro";
    } elseif ($nMes == 11) {
        $sMes = "Novembro";
    } elseif ($nMes == 12) {
        $sMes = "Dezembro";
    } else {
        $sMes = "Erro";
    }

    return $sMes;
}
