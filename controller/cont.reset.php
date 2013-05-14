<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if (isset($_GET['cek'])) {

    $data = array(
        'msg' => 'no',
        'nama' => 'Tidak Ada di Referensi',
    );

    if (isset($_GET['kddept'])) {
        $kddept = $_GET['kddept'];
        $dept_obj = new Dept();

        $dept = $dept_obj->getDept($kddept);
        if ($dept != false) {
            $data = array(
                'msg' => 'yes',
                'nama' => $dept->nmdept,
            );
        }
    }

    if (isset($_GET['kdunit'])) {
        if (empty($_GET['kddept'])) {
            $data = array(
                'msg' => 'no',
                'nama' => 'Kode Departemen Harus Diisi',
            );
        } else {
            $kddept = $_GET['kddept'];
            $kdunit = $_GET['kdunit'];

            $arr = array(
                'kddept' => $kddept,
                'kdunit' => $kdunit,
            );

            $unit_obj = new Unit($arr);

            $unit = $unit_obj->getUnit();

            if ($unit != false) {
                $data = array(
                    'msg' => 'yes',
                    'nama' => $unit->nmunit,
                );
            } else {
                $data = array(
                    'msg' => 'no',
                    'nama' => 'Tidak Ada di Referensi',
                );
            }
        }
    }

    if (isset($_GET['kdsatker'])) {
        if (empty($_GET['kddept']) || empty($_GET['kdunit'])) {
            $data = array(
                'msg' => 'no',
                'nama' => 'Kode Dept dan Kode Unit Harus diisi',
            );
        } else {
            $kdsatker = $_GET['kdsatker'];
            $kddept = $_GET['kddept'];
            $kdunit = $_GET['kdunit'];

            $arr = array(
                'kddept' => $kddept,
                'kdunit' => $kdunit,
                'kdsatker' => $kdsatker,
            );

            $satker = new Satker($arr);

            $data_satker = $satker->getSatker();

            if (is_array($data_satker)) {
                $data = array(
                    'msg' => 'yes',
                    'nama' => $data_satker['nmsatker'],
                );
            } else {
                $data = array(
                    'msg' => 'no',
                    'nama' => 'Tidak Ada di Referensi',
                );
            }
        }
    }
    echo json_encode($data);
}

if (isset($_POST['kddept']) && isset($_POST['kdunit']) && isset($_POST['kdsatker']) 
        && isset($_POST['username'])  && isset($_POST['no_surat']) && isset($_POST['tgl_surat'])) {

    $kddept = $_POST['kddept'];
    $kdunit = $_POST['kdunit'];
    $kdsatker = $_POST['kdsatker'];
    $username = $_POST['username'];
    $no_surat = $_POST['no_surat'];
    $tgl_surat = $_POST['tgl_surat'];
    $kddekon=$_POST['dekon'];
    
    $user_cek=$kddept.$kdunit.$kdsatker.$kddekon;

    if (empty($kddept) || empty($kdunit) || empty($kdsatker) || empty($username) || empty($no_surat)|| empty($tgl_surat)) {
        $data = array(
            'msg' => 'no',
            'info' => 'Semua Harus Diisi',
        );
    } else {
        if($username!=$user_cek){
            $data = array(
                'msg' => 'no',
                'info' => 'Username Salah',
            );
        } else {
            $arr=array(
                'kddept' => $kddept,
                'kdunit' => $kdunit,
                'kdsatker' => $kdsatker,
                'username' => $kddept.''.$kdunit.''.$kdsatker.''.$kddekon,
            );
            
            $isAdmin=User::isAdmin($username);
            
            if($isAdmin) {
                $arr['kdakses']=1;
                $user=new UserAdmin($arr);
            }
            if(!$isAdmin) {
                $arr['kdakses']=2;
                $user=new UserSatker($arr);
            }

            $isExist=User::checkAvailability($user);
            
            if(!$isExist) {
                $reset=User::resetPass($user);
                if($reset) {
                    $arr2=array(
                        'username' => $kddept.''.$kdunit.''.$kdsatker.''.$kddekon,
                        'password' => '',
                    );
                    $users=User::cekUser($arr2);
                    $arr2=array(
                        'id_user' => $users['id_user'],
                        'no_surat' => $no_surat,
                        'tgl_surat' => $tgl_surat,
                        'id_jns_trs' => 2,
                    );

                    $log = new Loguser($arr2);
                    $cekLog = $log->saveLog();
                    if($cekLog) {
                        $data=$reset;
                        $data['msg']='ok';
                    } else {
                        $data=$reset;
                        $data['msg']='ok';
                        $data['info'] = 'Berhasil reset tapi log tidak tersimpan';
                    }
                } else {
                    $data = array(
                        'msg' => 'no',
                        'info' => 'Gagal Reset Password',
                    );
                }
            } else {
                $data = array(
                    'msg' => 'no',
                    'info' => 'Username Tidak Terdaftar',
                );
            }
            
        }
        
    }

    echo json_encode($data);
}

if(isset($_REQUEST['pdf'])){
    $kddept=$_POST['kddept'];
    $kdunit=$_POST['kdunit'];
    $kdsatker=$_POST['kdsatker'];
    $kddekon=$_POST['kddekon'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    
    $bar=new Pdf_Print();
    $bar->createPdfUser($kddept, $kdunit, $kdsatker, $kddekon, $username, $password);
}
?>
