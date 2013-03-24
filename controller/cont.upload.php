<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

$error = "";
$msg = "";
$direktori = 'adk';
$ekstensi = array('012', '112', '212', '120', '312', '1212');
$size = 2000000; //2mb
if (empty($_FILES['file_adk']['tmp_name']) || $_FILES['file_adk']['tmp_name'] == 'none') {
    $error = 'File Tidak Ada';
} elseif (empty($_POST['dekon'])) {
    $error = 'Jenis Kewenangan Harus Diisi';
} else {
    $kddekon = $_POST['dekon'];
    $id_rekon = $_POST['id_rekon'];
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
                if ($id_rekon == '1' && $id_sa != 'SA') {
                    $error = 'File Bukan Untuk Rekon Saldo Awal';
                } elseif ($id_rekon == '2' && $id_sai != 'KPPN') {
                    $error = 'File Bukan Untuk Rekon SAI';
                } else {
                    $save = move_uploaded_file($_FILES['file_adk']['tmp_name'], 
                            '../' . $direktori . '/' . $_FILES['file_adk']['name']);
                    if ($save) {
//                        $msg .= " File Name: " . $_FILES['file_adk']['size'] . ", ";
//                        $msg .= " Read and Rekon";
                        $adk=new Adk();
                        $content=$adk->getFile($filename, $id_rekon);
                        var_dump(substr($content,0,100));
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

        //for security reason, we force to remove all uploaded file
        @unlink($_FILES['file_adk']);
    }
}

$data=array(
    'error'=>$error,
    'msg' => $msg,
);

echo json_encode($data);
//echo "{";
//echo "error: '" . $error . "',\n";
//echo "msg: '" . $msg . "'\n";
//echo "}";
?>
