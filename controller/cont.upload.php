<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

$error = "";
$msg = "";
$direktori = 'adk';
$ekstensi = array('012', '112', '212', '120', '312', '1212');
$size = 2000000; //2mb
$rekon = array();
if (empty($_FILES['file_adk']['tmp_name']) || $_FILES['file_adk']['tmp_name'] == 'none') {
    $error = 'File Tidak Ada';
} elseif (empty($_POST['dekon'])) {
    $error = 'Jenis Kewenangan Harus Diisi';
} else {
    $kddekon = $_POST['dekon'];
    $id_rekon = $_POST['id_rekon'];
    if ($id_rekon == '2') {
        $periode = $_POST['periode'];
    }else {
        $periode='00';
    }
    session_start();
    $username = $_SESSION['username'];

    $kddept = substr($username, 0, 3);
    $kdunit = substr($username, 3, 2);
    $kdsatker = substr($username, 5, 6);

    $arr = array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
    );

    $satker = new Satker($arr);
    $data_satker = $satker->getKewenangan();

    $setup = new Setup();
    $set = $setup->getSetup();

    if ($kddekon != $data_satker['kddekon']) {
        $error = 'Jenis Kewenangan Salah';
    } else {
        //$msg .= " File Name: " . $_FILES['file_adk']['name'] . ", ";
        //$msg .= " File Size: " . @filesize($_FILES['file_adk']['tmp_name']) . ", ";
        //$msg .= " Dekon : " . $_POST['dekon'];
        $tmp = explode('.', $_FILES['file_adk']['name']);
        $fileEks = $tmp[count($tmp) - 1];
        $fileName = $tmp[0];

        if (in_array($fileEks, $ekstensi)) {
            if ($_FILES['file_adk']['size'] <= $size) {
                $id_sa = substr($fileName, 0, 2);
                $id_sai = substr($fileName, 0, 4);
                $per = substr($fileName, -2);

                if ($id_rekon == '1') {
                    $nmFile = 'SA' . $data_satker['kddekon'] . '' . $kddept . '' . $kdunit . '' . $kdsatker . '.0' . substr($set['thnang'], -2);
                } else {
                    $nmFile = 'KPPN_' . $data_satker['kddekon'] . '' . $kddept . '' . $kdunit . '' . $kdsatker . '' . $periode . '' . '.0' . substr($set['thnang'], -2);
                }

                if ($_FILES['file_adk']['name'] != $nmFile) {
                    $error = 'File ADK Salah atau Bukan Untuk Periode Ini';
                } elseif ($id_rekon == '1' && $id_sa != 'SA') {
                    $error = 'File Bukan Untuk Rekon Saldo Awal';
                } elseif ($id_rekon == '2' && $id_sai != 'KPPN') {
                    $error = 'File Bukan Untuk Rekon SAI';
                } elseif ($id_rekon == '2' && $per != $periode) {
                    $error = 'File Bukan Untuk Rekon Periode Ini';
                } else {
                    if (file_exists('../adk/' . $_FILES['file_adk']['name'])) {
                        copy('../adk/' . $_FILES['file_adk']['name'], '../adk/bck_' . $_FILES['file_adk']['name']);
                    }
                    $save = move_uploaded_file($_FILES['file_adk']['tmp_name'], '../' . $direktori . '/' . $_FILES['file_adk']['name']);
                    if ($save) {
                        /**
                         * bisa juga tanpa if
                         * $msg = 'Rekonsiliasi Sedang Diproses';
                          $rekon=array(
                          'id_rekon' => $id_rekon,
                          'kdbaes' => $kddept . '' . $kdunit,
                          'kdsatker' => $kdsatker,
                          'nama_file' => $_FILES['file_adk']['name'],
                          );
                         */
                        $data_log=array(
                            'kddept' => $kddept,
                            'kdunit' => $kdunit,
                            'kdsatker' => $kdsatker,
                            'kddekon' => $kddekon,
                            'tgl_rekon' => date('Y-m-d H:i:s'),
                            'id_jns_rekon' => '',
                            'periode' => $periode,
                            'id_status_rekon' => 1,
                        );
                        $log=new LogRekon($data_log);
                        $cek=$log->cekLog($kddept, $kdunit, $kdsatker, $kddekon, $periode);
                        if($cek) {
                            $log->updateLog($kddept, $kdunit, $kdsatker, $kddekon, $periode, 1);
                        }else {
                            $log->insertLog($log);
                        }
                        if ($id_rekon == '1') {
                            $msg = 'Rekon Saldo Awal Sedang Diproses';
                            $rekon = array(
                                'id_rekon' => $id_rekon,
                                'kddekon' => $kddekon,
                                'nama_file' => $_FILES['file_adk']['name'],
                            );
                        } elseif ($id_rekon == '2') {
                            $msg = 'Rekon SAI Sedang Diproses';
                            $rekon = array(
                                'id_rekon' => $id_rekon,
                                'kddekon' => $kddekon,
                                'periode' => $periode,
                                'nama_file' => $_FILES['file_adk']['name'],
                            );
                        } else {
                            $error = 'Rekonsiliasi Tidak Ada';
                        }
                    } else {
                        $error = 'Gagal save file';
                    }
                }
            } else {
                $error = 'Ukuran File terlalu besar';
            }
        } else {
            $error = 'Bukan File Rekon';
        }

        
        @unlink($_FILES['file_adk']);
    }
}

$data = array(
    'error' => $error,
    'msg' => $msg,
    'rekon' => $rekon,
);

echo json_encode($data);
//echo "{";
//echo "error: '" . $error . "',\n";
//echo "msg: '" . $msg . "'\n";
//echo "}";
?>
