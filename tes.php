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
//
//$bar=new Periode();
//$pernya=$bar->getPeriodeByPer('02');
//
//echo $pernya['nmbulan'];

//$user=new \UserAdmin();
//    
//    $data=$user->getUserBlok();
//    
//    print_r($data);
//    $jml_aktif=0;
//    $jml_blokir=0;
//    for($i=0;$i<count($data);$i++){
//        if($data[$i]==1){
//            $jml_blokir++;
//        }else{
//            $jml_aktif++;
//        }
//    }
//    
//    $arr=array(
//        'aktif'=>$jml_aktif,
//        'blokir'=> $jml_blokir
//    );

//$rekon=new Rekon();
//
//
//print_r(date('m'));
//$data=$rekon->getRekonBenarSalah('02');
//$satker=new Satker();
//    
//    $jml_satker=$satker->getJmlSatker();
//    
//    $arr=array(
//        'belum' => $jml_satker['jml']-((int) $data[1]['jml_rek']+ (int) $data[2]['jml_rek']),
//        'benar' => $data[1]['jml_rek'],
//        'salah' => $data[2]['jml_rek']
//    );
//print_r($arr);

//$j='01508635162KD';
//echo(substr($j, 11, 2));
//session_start();
//
//$akses = $_SESSION['akses'];
//$kdakses = $akses[0];
//$nmakses = $akses[1];

//$user=new UserAdmin();
//
//$data_user=User::getUser('33');
//$arr=  get_object_vars($data_user);
//
//$akses=User::getAkses($arr['kdakses']);
//
//print_r($akses);

//$pdf=new Pdf_Print();
//$pdf->createPdfUser('015', '08', '635162', 'KD', 'oi980', 'kjhkajsd');
$query="SELECT DISTINCT * FROM ";
$query .= "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, IF(ISNULL(A.KDBAES1), ";
        $query .= "B.KDBAES1, A.KDBAES1) AS KDBAES1, IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= "IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= "IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= "IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, IF(ISNULL(A.RPHREAL), 0, A.RPHREAL) AS RPSAU, ";
        $query .= "IF(ISNULL(B.RPHREAL), 0, B.RPHREAL) AS RPSAI,IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA') HASIL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, LEFT(NODOK1, 20) AS NODOK1, ";
        $query .= "TGLDOK1, LEFT(KDPERK, 6) AS KDPERK, ";
        $query .= "KDSDCP, KDPROGRAM, KDGIAT, KDSGIAT, RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1, NODOK1, TGLDOK1,";
        $query .= " PERKSAU KDPERK,  KDSDCP,  KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, ";
        $query .= " SUM(RPHREAL) RPHREAL FROM rekon_tglsau ";
        $query .= "where tglpost >= '2012-01-01' AND tglpost <= '2012-01-31' ";
        $query .= "AND LEFT(kdbaes1,3) = '015' AND substr(kdbaes1,4,2) = '08' ";
        $query .= " AND kdsatker = '635162' AND kddekon='KD' ";
        $query .= "AND kdtrn='3' AND substr(jnsdok1,2,2) in('01','99','03') ";
        $query .= " and kdkem='0' and left(perksau, 1) in ('5','6') ";
        $query .= " GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1";
        $query .= " ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, KDBAES1, KDSATKER, PERKSAU, JNSDOK1, ";
        $query .= " TGLDOK1, NODOK1 ) C ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDSGIAT, ";
        $query .= "KDBAES1, KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1) B GROUP BY KDBAES1, ";
        $query .= "KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK ORDER BY KDBAES1, ";
        $query .= "KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) A ";
        $query .= "LEFT OUTER JOIN (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, NODOK1, TGLDOK1, PERKSAI AS KDPERK, KDSDCP,  ";
        $query .= "KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) RPHREAL FROM rekon_tglsai ";
        $query .= "where tglpost >= '2012-01-01' AND tglpost <= '2012-01-31' ";
        $query .= "AND LEFT(kdbaes1,3) = '015' AND substr(kdbaes1,4,2) = '08' ";
        $query .= " AND kdsatker = '635162' AND kddekon='KD' ";
        $query .= " AND kdtrn='3' AND substr(jnsdok1,2,2) in('01','99','03') ";
        $query .= " and kdkem='0' and left(perksai, 1) in ('5','6') ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ) D ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK ";
        $query .= "ORDER BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) B ON A.KDPERK=B.KDPERK ";
        $query .= "AND A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= "AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 ";
        $query .= "AND A.NODOK1=B.NODOK1 ";//ORDER BY A.KDBAES1, A.KDSATKER, A.JNSDOK1, A.TGLDOK1, A.NODOK1, A.KDPERK";
        
        $query .= " UNION SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, IF(ISNULL(A.KDBAES1), ";
        $query .= "B.KDBAES1, A.KDBAES1) AS KDBAES1, IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= "IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= "IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= "IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, IF(ISNULL(A.RPHREAL), 0, A.RPHREAL) AS RPSAU, ";
        $query .= "IF(ISNULL(B.RPHREAL), 0, B.RPHREAL) AS RPSAI,IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA') HASIL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, LEFT(NODOK1, 20) AS NODOK1, ";
        $query .= "TGLDOK1, LEFT(KDPERK, 6) AS KDPERK, ";
        $query .= "KDSDCP, KDPROGRAM, KDGIAT, KDSGIAT, RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1, NODOK1, TGLDOK1,";
        $query .= " PERKSAU KDPERK,  KDSDCP,  KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, ";
        $query .= " SUM(RPHREAL) RPHREAL FROM rekon_tglsau ";
        $query .= " where tglpost >= '2012-01-01' AND tglpost <= '2012-01-31' ";
        $query .= " AND LEFT(kdbaes1,3) = '015' AND substr(kdbaes1,4,2) = '08' ";
        $query .= " AND kdsatker = '635162' AND kddekon='KD' ";
        $query .= " AND kdtrn='3' AND substr(jnsdok1,2,2) in('01','99','03') ";
        $query .= " and kdkem='0' and left(perksau, 1) in ('5','6') ";
        $query .= " GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1";
        $query .= " ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, KDBAES1, KDSATKER, PERKSAU, JNSDOK1, ";
        $query .= " TGLDOK1, NODOK1 ) C ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDSGIAT, ";
        $query .= "KDBAES1, KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1) B GROUP BY KDBAES1, ";
        $query .= "KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK ORDER BY KDBAES1, ";
        $query .= "KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) A ";
        $query .= "RIGHT OUTER JOIN (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, NODOK1, TGLDOK1, PERKSAI AS KDPERK, KDSDCP,  ";
        $query .= "KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) RPHREAL FROM rekon_tglsai ";
        $query .= " where tglpost >= '2012-01-01' AND tglpost <= '2012-01-31' ";
        $query .= " AND LEFT(kdbaes1,3) = '015' AND substr(kdbaes1,4,2) = '08' ";
        $query .= " AND kdsatker = '635162' AND kddekon='KD' ";
        $query .= " AND kdtrn='3' AND substr(jnsdok1,2,2) in('01','99','03') ";
        $query .= " and kdkem='0' and left(perksai, 1) in ('5','6') ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ) D ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK ";
        $query .= "ORDER BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) B ON A.KDPERK=B.KDPERK ";
        $query .= "AND A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= "AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 ";
        $query .= "AND A.NODOK1=B.NODOK1 )";//ORDER BY A.KDBAES1, A.KDSATKER, A.JNSDOK1, A.TGLDOK1, A.NODOK1, A.KDPERK";
echo $query;
?>