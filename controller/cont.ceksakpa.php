<?php
function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if(isset($_GET['data'])){
    session_start();

    $username=$_SESSION['username'];
    //print_r($username);
    
    $kddept= substr($username, 0, 3);
    $kdunit= substr($username, 3, 2);
    $kdsatker= substr($username, 5, 6);
    $baes1satker=$kddept.'.'.$kdunit.'.'.$kdsatker;
    
    $arr=array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
    );
    
    $satker = new Satker($arr);
    $data_satker = $satker->getSatker();
    $kewe=$satker->getKewenangan();
    $data=array(
        'kdsatker' => $baes1satker,
        'nmsatker' => $data_satker['nmsatker'],
        'kddekon' => $kewe['kddekon'],
    );
    
    echo json_encode($data);
}

if(isset($_GET['cek'])){
    $kddekon=$_REQUEST['kddekon'];
    $tgl_awal=$_REQUEST['tgl_awal'];
    $tgl_akhir=$_REQUEST['tgl_akhir'];
    $jns_rekon=$_REQUEST['jns_rekon'];
    session_start();

    $username=$_SESSION['username'];

    
    $kddept= substr($username, 0, 3);
    $kdunit= substr($username, 3, 2);
    $kdsatker= substr($username, 5, 6);
    $rekon = new Rekon();
    switch ($jns_rekon) {
        case '1':
            $content = $rekon->rekonRealBelanja($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
            break;
        case '2':
            $content = $rekon->rekonPengembalianBelanja($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
            break;
        case '3':
            $content = $rekon->rekonPendapatanBPjk($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
            break;
        case '4':
            $content = $rekon->rekonPendapatanPajak($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
            break;
        case '5':
            $content = $rekon->rekonPenerimaanPembiayaan($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
            break;
        case '6':
            $content = $rekon->rekonPengeluaranPembiayaan($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
            break;
        case '7':
            $content = $rekon->rekonUP($kddept,$kdunit,$kdsatker, $tgl_awal,$tgl_akhir,$kddekon);
            break;
        default:
            break;
    }
    
    echo json_encode($content);
    
}
?>
