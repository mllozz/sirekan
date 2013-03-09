<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}


if (isset($_POST['user']) && isset($_POST['pass'])) {
    session_start();
    $message = array();
    $username = $_POST['user'];
    $password = $_POST['pass'];

    if (empty($username) || empty($password)) {
        $message[] = "Tidak boleh kosong";
    }


    $data = array(
        'username' => $username,
        'password' => $password,
    );

    $cek = User::cekUser($data);

    if (!$cek['is_true']) {
        $message[] = $cek['message'];
    } else {
        $id_user=$cek['id_user'];
        $data_user=User::getUser($id_user);
        $arr=  get_object_vars($data_user);

        $akses=User::getAkses($arr[3]);

        //inisiasi object satker
        $satker = new Satker($arr);
        $data_satker = $satker->getSatker($satker);
        
        
        //buat session
        $_SESSION['isLogged']=true;        
        $_SESSION['satker']=  $data_satker;
        $_SERVER['akses']=$akses;
        
        echo 'correct';
    }

    $error = count($message);
    if ($error > 0) {
        for ($i = 0; $i < $error; $i++) {
            echo ucwords($message[$i]);
        }
    }
} else {
    header('Location: ../index.php');
}
?>