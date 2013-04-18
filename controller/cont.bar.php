<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if (isset($_GET['detail'])) {
    session_start();

    $username = $_SESSION['username'];
//print_r($username);

    $kddept = substr($username, 0, 3);
    $kdunit = substr($username, 3, 2);
    $kdsatker = substr($username, 5, 6);
    $baes1satker = $kddept . '.' . $kdunit . '.' . $kdsatker;

    $arr = array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
    );

    $satker = new Satker($arr);
    $data_satker = $satker->getSatker();
    $kewe = $satker->getKewenangan();
    $data = array(
        'kdsatker' => $baes1satker,
        'nmsatker' => $data_satker['nmsatker'],
        'kddekon' => $kewe['kddekon'],
    );

    echo json_encode($data);
}
if (isset($_REQUEST['cetak'])) {
    
    session_start();

    $username = $_SESSION['username'];

    $kddept = substr($username, 0, 3);
    $kdunit = substr($username, 3, 2);
    $kdsatker = substr($username, 5, 6);
    $baes1satker = $kddept . '.' . $kdunit . '.' . $kdsatker;

    $arr = array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
    );

    $satker = new Satker($arr);
    $kewe = $satker->getKewenangan();
    
    $kddekon = $_POST['kddekon'];
    $periode = $_POST['periode'];
    $error = true;
    $msg='';
    $bulan = (int) date('m');
    if ($kddekon != $kewe['kddekon']) {
        //$msg = 'Kode Kewenangan Salah';
        echo json_encode($error);
    } elseif (((int) $periode) > $bulan) {
        //$msg = 'Periode Rekonsiliasi Salah';
        echo json_encode($error);
    } else {
        $log=new LogRekon();
        $cek=$log->getLog($kddept, $kdunit, $kdsatker, $kddekon, $periode);
        if(!$cek){       
            //$msg='Rekonsiliasi Belum Dilakukan';
            echo json_encode($error);
        }else {
            if($cek['id_status_rekon']=='2'){
                //rekon benar cetak pdf
                $bar=new Pdf_Print();
                //$error = false;
                //$msg='Rekonsiliasi Benar';
                $bar->createBar();
            }else{
                //$msg='Rekonsiliasi Masih Salah';
                echo json_encode($error);
            }
        }
    }

//    $data = array(
//        'error'=> $error,
//        'msg' => $msg,
//    );
    //echo json_encode($data);
}
?>
