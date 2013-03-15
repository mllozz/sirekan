<?php

//cek data
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
                    //'nama' => $data_satker['kddept'] . '.' . $data_satker['kdunit'] . '.' . $data_satker['kdsatker'] . '.' . $data_satker['nmsatker'],
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
//submit form rekam user
if (isset($_POST['kddept']) && isset($_POST['kdunit']) && isset($_POST['kdsatker']) && isset($_POST['kdakses'])) {
    $kddept=$_POST['kddept'];
    $kdunit=$_POST['kdunit'];
    $kdsatker=$_POST['kdsatker'];
    $kdakses=$_POST['kdakses'];
    $data='';
    $arr=array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
        'kdakses' => $kdakses,
        'username' => $kddept.''.$kdunit.''.$kdsatker,
    );
    $user='';
    if($kdakses=='1') {
        $user=new UserAdmin($arr);
    } 
    if($kdakses=='2') {
        $user=new UserSatker($arr);
    }
    
    $cekUser=User::checkAvailability($user);
    if($cekUser) {
        $data=User::saveUser($user);
        $data['msg']='ok';
        $data['info']='berhasil';
    } else {
        $data=array(
            'msg' => 'no',
            'info' => 'User untuk satker '.$user->username.' sudah ada'
        );
    }   
    echo json_encode($data);
}
?>
