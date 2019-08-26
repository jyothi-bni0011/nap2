<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('array_ids')) {

    function array_ids($arrays, $key_name) {

        if (!is_array($arrays)) {
            return [];
        }

        $data = [];
        foreach ($arrays as $array) {
            $data[] = array_key_exists($key_name, $array) ? $array->{$key_name} : [];
        }

        return $data;
    }

}

if (!function_exists('map_id_key')) {

    function map_id_key($arrays, $key_name) {

        if (!is_array($arrays)) {
            return [];
        }

        $data = [];
        foreach ($arrays as $array) {
            $data[$array->{$key_name}][] = $array;
        }

        return $data;
    }

}

if (!function_exists('error_message')) {

    function error_message($message = '') {
        return sprintf('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>%s</div>', $message);
    }

}

if (!function_exists('success_message')) {

    function success_message($message = '') {
        return sprintf('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>%s</div>', $message);
    }

}

function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null) {
// This function will search the revisions for a certain value
    // related to the associative key you are looking for.
    $keys = array();
    foreach ($dataArray as $key => $cur_value) {
        if ($cur_value[$key_to_search] == $search_value) {
            if (isset($other_matching_key) && isset($other_matching_value)) {
                if ($cur_value[$other_matching_key] == $other_matching_value) {
                    $keys[] = $key;
                }
            } else {
                // I must keep in mind that some searches may have multiple
                // matches and others would not, so leave it open with no continues.
                $keys[] = $key;
            }
        }
    }
    return $keys;
}
function pdfEncrypt($origFile, $password, $destFile) {
        require_once('fpdi/FPDI_Protection.php');

        $pdf =  new FPDI_Protection();
        $pdf->FPDF('P', 'in');

        $pagecount = $pdf->setSourceFile($origFile);

        for ($loop = 1; $loop <= $pagecount; $loop++) {
            $tplidx = $pdf->importPage($loop);
            $pdf->addPage();
            $pdf->useTemplate($tplidx);
        }
        $pdf->SetProtection(array(), $password);
        $pdf->Output($destFile, 'F');
//        return $destFile;
        return true;
    }