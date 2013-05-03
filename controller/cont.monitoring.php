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
//    $bulan=array();
//    $periode=new Periode();
//    $bulan_akhir=(int) date('m');
//    $all_bulan=$periode->getPeriode();
//    
//    for($i=0;$i<count($all_bulan);$i++){
//        $bulan[$i]=$all_bulan['kdperiode'];
//    }
        
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

?>
