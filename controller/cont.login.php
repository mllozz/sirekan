<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}


if (isset($_POST['user']) && isset($_POST['pass'])) {
    
    $message = array();
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $cap=$_POST['cap'];

    if (empty($username) || empty($password) || empty($cap)) {
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
        $blokir=new Blokir();
        $isBlokir=$blokir->isBlokir($id_user);
        session_start();
        if($cap != $_SESSION['cap'] OR $_SESSION['cap']=='')  {
            $message[]='Kode Verifikasi Salah';
        }elseif($isBlokir) {
            $message[] = "User diblokir, silahkan hubungi KPPN";
        } else {
            $data_user=User::getUser($id_user);
            $arr=  get_object_vars($data_user);

            $akses=User::getAkses($arr['kdakses']);
            
            //inisiasi object satker
            //$satker = new Satker($arr);
            //$data_satker = $satker->getSatker();
            //session_start();
            //buat session
            $_SESSION['isLogged']=true;  
            $_SESSION['username']=$arr[0];
            //$_SESSION['satker']=  $data_satker;
            $_SESSION['akses']=$arr['kdakses'];

            echo 'correct';
        }
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

//@8gwi@uf
?>
