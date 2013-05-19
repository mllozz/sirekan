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
    $kddept = $_POST['kddept'];
    $kdunit = $_POST['kdunit'];
    $kdsatker = $_POST['kdsatker'];
    $kdakses = $_POST['kdakses'];
    $tgl_surat = $_POST['tgl_surat'];
    $no_surat = $_POST['no_surat'];
    $kddekon=$_POST['kddekon'];
    $data = '';
    $kppn = new Kppn();

    $kdkppn = $kppn->getKppn();

    $arrSatker = array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
        'kddekon' => $kddekon,
    );

    $satker = new Satker($arrSatker);

    $kdkppnSatker = $satker->getSatker();
    if($kdakses=='1'){
        $username=$_POST['username'];
    }else {
        $username=$kddept . '' . $kdunit . '' . $kdsatker. '' .$kddekon;
    }
    if ($kdkppnSatker['kdkppn'] == $kdkppn->kdkppn) {
        $arr = array(
            'kddept' => $kddept,
            'kdunit' => $kdunit,
            'kdsatker' => $kdsatker,
            'kddekon' => $kddekon,
            'kdakses' => $kdakses,
            'username' => $username,
        );
        $user = '';
        if ($kdakses == '1') {
            $user = new UserAdmin($arr);
        }
        if ($kdakses == '2') {
            $user = new UserSatker($arr);
        }

        $cekUser = User::checkAvailability($user);
        if ($cekUser) {
            $data = User::saveUser($user);

            $arr2 = array(
                'id_user' => $data['id_user'],
                'no_surat' => $no_surat,
                'tgl_surat' => $tgl_surat,
                'id_jns_trs' => 1,
            );

            $log = new Loguser($arr2);
            $cekLog = $log->saveLog();
            if ($cekLog) {
                $data['msg'] = 'ok';
                $data['info'] = 'berhasil';
            } else {
                $data['msg'] = 'ok';
                $data['info'] = 'berhasil tetapi log tidak tersimpan';
            }
        } else {
            $data = array(
                'msg' => 'no',
                'info' => 'User untuk satker ' . $user->username . ' sudah ada'
            );
        }
    } else {
        $data = array(
            'msg' => 'no',
            'info' => 'Satker bukan mitra kerja KPPN ' . $kdkppn->nmkppn,
        );
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
