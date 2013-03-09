<?php
//cek data
if(isset($_GET['cek'])) {
    $data = array(
        'msg' => 'no',
        'nama' => 'Tidak Ada di Referensi',
    );
    
    if(isset($_GET['kddept'])) {
        $kddept=$_GET['kddept'];
        $data = array(
            'msg' => 'yes',
            'nama' => $kddept,
        );
    }
    
    if(isset($_GET['kdunit'])) {
        $kdunit=$_GET['kdunit'];
        $data = array(
            'msg' => 'yes',
            'nama' => $kdunit,
        );
    }
    
    if(isset($_GET['kdsatker'])) {
        $kdsatker=$_GET['kdsatker'];
        $data = array(
            'msg' => 'yes',
            'nama' => $kdsatker,
        );
    }
    echo json_encode($data);
}
//submit fomr
if(isset($_GET['kddept']) && isset($_GET['kdunit']) && isset($_GET['kdsatker'])) {
    $data = array(
        'msg' => 'ok',
        'nama' => 'Berhasillll',
    );
    
    echo json_encode($data);
}
?>
