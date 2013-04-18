<?php

function __autoload($class_name) {
    include 'class/class.' . strtolower($class_name) . '.php';
}

//$data = array(
//	'kode_ba' =>'015' ,
//	'kode_es' => '08',
//	'kode_satker' => '635172',
//	'nama_satker' => 'KPPN Mana Saaja',
//);
//$satker = new Satker($data);
//echo $satker;
//$bag=$_GET['data'];
//$db= Database::getInstance();
//$mysql=$db->getConnection($bag);
//if($bag==2) {
//	$query='select * from t_kppn';
//} else {
//	$query='select * from users';
//}
//$result=$mysql->query($query) or trigger_error(mysqli_connect_error());
//$result=$mysql->prepare($query);
//$result->execute();
//if($result==false) {
//	echo 'ra iso';
//}
//$data=$result->fetch_assoc();
//$data=$result->fetch();
//	print_r($data);
//	echo '<br />';
//	echo '<br />';
//	echo '<br />';
//	
//	$kppn=new Kppn();
//	$data=$kppn->getNamaKppn();
//	
//	//print_r($data);
//	
//	echo '<br />';
//	echo '<br />';
//	
//	echo $data->nmkppn;
//        
//        echo date('Y-m-d H:i:s');
//$input = 'bl';
//$data = array('orange', 'blue', 'green', 'red', 'pink', 'brown', 'black');
//        
//$result = array_filter($data, function ($item) use ($input) {
//    if (stripos($item, $input) !== false) {
//        return true;
//    }
//    return false;
//});
//
//var_dump($result);

//$data_log = array(
//    'kddept' => '015',
//    'kdunit' => '08',
//    'kdsatker' => '635162',
//    'tgl_rekon' => date('Y-m-d H:i:s'),
//    'id_jns_rekon' => '',
//    'periode' => '',
//    'id_status_rekon' => 1,
//);
//$log = new LogRekon($data_log);
//$log->insertLog($log);
//$adk=new LogRekon();
//$c=$adk->getJmlRecordAdk('SAKD01508635162.012');
////
//var_dump($c);
//$adk->insertLogServer('01508', '635162', 'KD', '00', '604', 'TAL')
//print_r(date('m'));

//$rekon=new Rekon();

//$tes=$rekon->cekRekonBenarSalah('015', '08', '635162', '05', 'KD');
//var_dump($tes);
//if(in_array(false, $tes)){
//    echo 'ya';
//}
//var_dump($tes);
//$msg='';
//        $hasil=false;
//$rekon=new Rekon();
//        $log=new LogRekon();
//        $arr=$rekon->cekRekonBenarSalah('015', '08', '635162', '02', 'KD');
//        if(in_array(false, $arr)){
//            $log->updateLog('015', '08', '635162',  'KD', '02', 3);
//            $msg='Rekonsiliasi Ada Yang Salah';
//        }else {
//            $log->updateLog('015', '08', '635162',  'KD', '02', 2);
//            $hasil=true;
//            $msg='Rekonsiliasi Benar, Silahkan Cetak BAR dan Lampiran';
//        }
//        
//        $data=array(
//            'hasil' => $hasil,
//            'msg' => $msg,
//            'bagian' => $arr,
//        );
//        print_r($data);

$bar=new Pdf_Print();
$bar->createBar();
?>