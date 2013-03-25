<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if (isset($_POST['rekon'])) {

    session_start();
    $username = $_SESSION['username'];

    $kdbaes = substr($username, 0, 5);
    $kdsatker = substr($username, 5, 6);
    $ulang = $_POST['rekon'];
    $id_rekon = $_POST['id'];
    $nama_file = $_POST['nama'];

    //rekon saldo awal
    
        $rekon = new Rekon();
        if ($id_rekon == '1') {
            $cek = $rekon->cekRekonSA($kdbaes, $kdsatker);
        }else{
            //rekon sakpa
            echo json_encode('Rekon SAKPA');
        }
        if ($cek && $ulang == 0) {
            echo json_encode('pernah');
        } else {
            if ($ulang == 1) {
                if ($id_rekon == '1') {
                    $delete = $rekon->deleteRekonSA($kdbaes, $kdsatker);
                }else{
                    //rekon sakpa
                    echo json_encode('Rekon SAKPA');
                }
                //echo json_encode('rekon normal');
                if (!$delete) {
                    echo json_encode('Data Lama Gagal Dihapus');
                }
            }
            $adk=new Adk();
            $content = $adk->getAdkFile($nama_file);
            if ($id_rekon == '1') {
                $insert = $rekon->insertGLSA($content);
            } else {
//                $insert = $rekon->insertGLSAI($content);
                echo json_encode('Rekon SAKPA');
            }
            if ($insert) {
                //posting dan ambil data
                
                //cocokkan
                
                //return hasil
                echo json_encode('Berhasil Rekon');
            } else {
               echo json_encode('Gagal Membaca ADK, File Corrupt atau Kosong');
            }
            
        }
        
    //echo json_encode('Dataneeeee');
}
?>
