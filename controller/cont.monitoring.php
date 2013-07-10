<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if(isset($_REQUEST['user_pie'])){
    
    $user=new \UserAdmin();
    
    $data=$user->getUserBlok();
    $jml_aktif=0;
    $jml_blokir=0;
    for($i=0;$i<count($data);$i++){
        if($data[$i]['blok']==1){
            $jml_blokir++;
        }else{
            $jml_aktif++;
        }
    }
    
    $arr=array(
        'aktif'=>$jml_aktif,
        'blokir'=> $jml_blokir
    );
    echo json_encode($arr);
}

if(isset($_REQUEST['rekon_pie'])){
       
    if(isset($_REQUEST['periode'])){
        $periode=$_REQUEST['periode'];
    }else{
        $periode=date('m');
    }
    
    $rekon= new Rekon();
    
    $data= $rekon->getRekonBenarSalah($periode);
    
    $satker=new Satker();
    
    $jml_satker=$satker->getJmlSatker();
    
    $arr=array(
        'belum' => $jml_satker['jml']-((int) $data[1]['jml_rek']+ (int) $data[2]['jml_rek']),
        'benar' => $data[1]['jml_rek'],
        'salah' => $data[2]['jml_rek']
    );
    
    echo json_encode($arr);
}

if(isset($_REQUEST['status_rekon'])){
    $satker=new Satker();
    $log=new LogRekon();
    $data=array();
       
    $all_satker=$satker->getAllSatker();
    $j=0;
    foreach($all_satker as $rows){
        $data[$j]=array(
            'kddept'=>$rows['kddept'],
            'kdunit'=>$rows['kdunit'],
            'kdsatker'=>$rows['kdsatker'],
            'kddekon'=>$rows['kddekon'],
            'jan'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '01'),
            'feb'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '02'),
            'mar'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '03'),
            'apr'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '04'),
            'mei'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '05'),
            'jun'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '06'),
            'jul'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '07'),
            'ags'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '08'),
            'sep'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '09'),
            'okt'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '10'),
            'nov'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '11'),
            'des'=>$log->getStatusRekon($rows['kddept'], $rows['kdunit'], $rows['kdsatker'], $rows['kddekon'], '12'),
        );
        $j++;
    }
    
    echo json_encode($data);
    
}

if(isset($_REQUEST['stat_user'])){
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
    $sat=$satker->getSatker();
    $data_satker = $satker->getKewenangan();
    
    $log=new LogRekon();
    $rekon=new Rekon();
    
    $bln_ini=date('m');
    $hsl_rekon=$log->getLog($kddept, $kdunit, $kdsatker, $data_satker['kddekon'], $bln_ini);
    $tgl_rekon='Belum Rekon';
    $status_rekon='Belum Rekon';
    if($hsl_rekon!=false){
        $tgl_rekon=$hsl_rekon['tgl_rekon'];
        if($hsl_rekon['id_status_rekon']=='2' || $hsl_rekon['id_status_rekon']=='3'){
            //$status_rekon='Benar';
            $status_rekon=$rekon->cekRekonBenarSalah($kddept, $kdunit, $kdsatker, $bln_ini, $data_satker['kddekon']);
        }else {
            $status_rekon='Salah';
        }
    }
    
    $data=array(
        'kddept' => $kddept,
        'kdunit' => $kdunit,
        'kdsatker' => $kdsatker,
        'kddekon' => $data_satker['kddekon'],
        'nmsatker' => $sat['nmsatker'],
        'tgl_rekon' => $tgl_rekon,
        'id' => $hsl_rekon['id_status_rekon'],
        'hasil' => $status_rekon,
    );
    
    echo json_encode($data);
}

if(isset($_REQUEST['history'])){
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
    $sat=$satker->getSatker();
    $data_satker = $satker->getKewenangan();
    
    $periode=new Periode();
    
    $log=new LogRekon();
    $histori=$log->getHistory($kddept, $kdunit, $kdsatker, $data_satker['kddekon']);
    $data=array();
    for($i=0;$i<count($histori);$i++){
        if($histori[$i]['periode']=='00'){
            $data[$i]=array(
                'periode'=>'Saldo Awal',
                'nm_status_rekon'=>$histori[$i]['nm_status_rekon'],
            );
        }else {
            $per=$periode->getPeriodeByPer($histori[$i]['periode']);
            $data[$i]=array(
                'periode'=>$per['nmbulan'],
                'nm_status_rekon'=>$histori[$i]['nm_status_rekon'],
            );
        }
    }
    
    echo json_encode($data);
}
?>
