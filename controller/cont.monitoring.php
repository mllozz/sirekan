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

?>
