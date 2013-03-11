<?php
function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}
if(isset($_POST['password']) && isset($_POST['password_baru']) && isset($_POST['password_ulangi'])) {
    $password=$_POST['password'];
    $password_baru=$_POST['password_baru'];
    $password_ulangi=$_POST['password_ulangi'];
    
    if(empty($password) || empty($password_baru) || empty($password_ulangi)) {
        $data=array(
            'msg' => 'no',
            'info' => 'Semua Harus diisi',
        );
    } else {
        
        if($password_baru!=$password_ulangi) {
            $data=array(
                'msg' => 'no',
                'info' => 'Konfirmasi Password Tidak Sama',
            );
        } else {
            session_start();
            $username=$_SESSION['username'];
            $arr=array(
                'username' => $username,
                'password' => $password,
            );
            //cek user
            $cek=User::cekUser($arr);
            if(!$cek['is_true'])  {
                $data=array(
                    'msg' => 'no',
                    'info' => 'Password yang anda masukkan salah',
                );
            } else {
                $id_user=$cek['id_user'];
                $password_baru=md5($password_baru);
                $update=User::updateUser($id_user,$password_baru);
                if($update) {
                    $data=array(
                        'msg' => 'ok',
                        'info' => 'Password Berhasil diubah, silahkan logout dan login lagi',
                    );
                } else {
                    $data=array(
                        'msg' => 'no',
                        'info' => 'Gagal ubah password',
                    );
                }
            }
        }
    }
    echo json_encode($data);
}

?>
