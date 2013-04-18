<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

//if (isset($_GET['server'])) {
//    $kddekon = $_POST['kddekon'];
//    if (isset($_GET['sakpa'])) {
//        $jns_rekon = $_POST['jns_rekon'];
//    }
//    $tgl_awal = $_POST['tgl_awal'];
//    $tgl_akhir = $_POST['tgl_akhir'];
//
//    session_start();
//
//    $username = $_SESSION['username'];
//
//    $kddept = substr($username, 0, 3);
//    $kdunit = substr($username, 3, 2);
//    $kdsatker = substr($username, 5, 6);
//    $kdbaes = substr($username, 0, 5);
//    $error = false;
//    $msg = '';
//    $ambil = new Server_Data();
//
//    $del = $ambil->deleteLokal($kdbaes, $kdsatker, $kddekon);
//    if ($del) {
//        $proses = $ambil->prosesData($kddept, $kdunit, $kdsatker, $kddekon);
//        if (!$proses) {
//            $error = 'Gagal Mencari data';
//        } else {
//            //proses pencocokan
//            if (isset($_GET['sakpa'])) {
//                $msg = array(
//                    'kddekon' => $kddekon,
//                    'tgl_awal' => $tgl_awal,
//                    'tgl_akhir' => $tgl_akhir,
//                    'jns_rekon' => $jns_rekon,
//                );
//            } else {
//                $msg = array(
//                    'kddekon' => $kddekon,
//                    'tgl_awal' => $tgl_awal,
//                    'tgl_akhir' => $tgl_akhir,
//                );
//            }
//        }
//    } else {
//        $error = 'Gagal Proses Data';
//    }
//
//
//    $data = array(
//        'msg' => $msg,
//        'error' => $error,
//    );
//
//    echo json_encode($data);
//}

if (isset($_GET['transfer'])) {
    $kddekon = $_POST['kddekon'];    
    session_start();

    $username = $_SESSION['username'];

    $kddept = substr($username, 0, 3);
    $kdunit = substr($username, 3, 2);
    $kdsatker = substr($username, 5, 6);
    $kdbaes = substr($username, 0, 5);
    $error = false;
    $ambil = new Server_Data();

    $del = $ambil->deleteLokal($kdbaes, $kdsatker, $kddekon);
    if ($del) {
        $proses = $ambil->prosesData($kddept, $kdunit, $kdsatker, $kddekon);
        if (!$proses) {
            $error = 'Gagal Mencari data';
        }
    } else {
        $error = 'Gagal Proses Data';
    }

    echo json_encode($error);
}
?>
