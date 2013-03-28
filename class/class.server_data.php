<?php

class Server_Data {

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }
    
    public function prosesData($kddept, $kdunit, $kdsatker, $kddekon){
        $sai=$this->getDataSAI($kddept, $kdunit, $kdsatker, $kddekon);
        $sau=$this->getDataSau($kddept, $kdunit, $kdsatker, $kddekon);
        if(count($sai)>=0  && count($sau)>=0){
            $insert_sai=$this->insertRekonGLSai($sai);
            $insert_sau=$this->insertRekonGLSau($sau);
            if($insert_sai && $insert_sau) {
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function deleteLokal($kdbaes, $kdsatker, $kddekon){
        if(($this->cekLokalSai($kdbaes, $kdsatker, $kddekon)) && !($this->cekLokalSau($kdbaes, $kdsatker, $kddekon))){
            $del=$this->deleteRekonSaiLokal($kdbaes, $kdsatker, $kddekon);
            if(!$del){
                return false;
            }
            return true;
        }elseif(!($this->cekLokalSai($kdbaes, $kdsatker, $kddekon)) && ($this->cekLokalSau($kdbaes, $kdsatker, $kddekon))){
            $del=$this->deleteRekonSauLokal($kdbaes, $kdsatker, $kddekon);
            if(!$del){
                return false;
            }
            return true;
        }elseif(($this->cekLokalSai($kdbaes, $kdsatker, $kddekon)) && ($this->cekLokalSau($kdbaes, $kdsatker, $kddekon))){
            $del=$this->deleteRekonSaiLokal($kdbaes, $kdsatker, $kddekon);
            $del1=$this->deleteRekonSauLokal($kdbaes, $kdsatker, $kddekon);
            if(!$del || !$del1){
                return false;
            }
            return true;
        }else{
            return true;
        }
        
    }
    
    protected function cekLokalSai($kdbaes, $kdsatker, $kddekon){
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM rekon_tglsai WHERE KDBAES1='$kdbaes' AND ";
        $query .= "KDSATKER='$kdsatker' AND KDDEKON='$kddekon'  AND thnang='$thnang'";
        
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }
    protected function cekLokalSau($kdbaes, $kdsatker, $kddekon){
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        
        $query = "SELECT * FROM rekon_tglsau WHERE KDBAES1='$kdbaes' AND ";
        $query .= "KDSATKER='$kdsatker' AND KDDEKON='$kddekon'  AND thnang='$thnang'";
        
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }
    
    //import data sa
    protected function deleteRekonSaiLokal($kdbaes, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "DELETE FROM rekon_tglsai WHERE KDBAES1='$kdbaes' AND ";
        $query .= "KDSATKER='$kdsatker' AND KDDEKON='$kddekon'  AND thnang='$thnang'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    protected function getDataSAI($kddept, $kdunit, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $kdkppn = $set['kdkppn'];
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT KDBAES1,KDKANWIL,KDWILAYAH,KDKPPN,KDSATKER,KDFUNGSI,KDSFUNG,KDPROGRAM,";
        $query .="KDGIAT,KDSGIAT,KDKEM,KDKAS,KDVAL,KDTRN,KDMAKMAP,KDDK,PERKSAI,PERKSAI1,PERKKOR,";
        $query .="PERKKOR1,KDKM,KDSDCP,THNANG,PERIODE,RPHREAL,FLAGREV,KDBAPEL,KDES1PEL,JNSDOK1,NODOK1,";
        $query .="TGLDOK1,KDDEKON,REGISTER,KDJENDOK,KDKANWILK,TGLPOST,REVISIKE,KDCRBAY,";
        $query .="NOKARWAS,KDBEBAN,KDJNSBAN,KDBLU,CAD1,CAD2,CAD3,KDKPKNL,STAT_REKON,TRN_BMN,KDOUTPUT ";
        $query .=" from t_glsai where thnang = '$thnang' and kdkppn ='$kdkppn' AND ";
        $query .="rphreal<>0 and LEFT(kdbaes1,3)  like  '$kddept' ";
        $query .="AND right(kdbaes1,2)  like  '$kdunit' AND kdsatker  like  '$kdsatker' AND ";
        $query .="kddekon like '$kddekon' and ((convert(perksai,signed)<>'0' ";
        $query .="AND LEFT(perksai,4)<>1137 AND (LEFT(perksai,1)<>2 or LEFT(perksai,1)<>3)  and ";
        $query .="(kdjendok<>'19' or kdjendok='19')) or ";
        $query .="(LEFT(kdmakmap,3) in ('811','821')   and kdjendok<>'19'))";

        $result = $conn->prepare($query);
        $result->execute();

        $resultarray = array();
        if ($result->rowCount() >= 1) {
            while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
                return $resultarray[] = $row;
            }
        }
        return false;
    }

    protected function insertRekonGLSai($data = array()) {
        if (!is_array($data)) {
            return false;
        }
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $values = $this->valuesOfArray($data);
        $query = "INSERT INTO rekon_tglsai VALUES " . implode(', ', $values);
        //print_r($query);
        $result = $conn->prepare($query);

        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    ///import data sakpa
    protected function deleteRekonSauLokal($kdbaes, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "DELETE FROM rekon_tglsau WHERE KDBAES1='$kdbaes' AND ";
        $query .= "KDSATKER='$kdsatker' AND KDDEKON='$kddekon'  AND thnang='$thnang'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    protected function getDataSau($kddept, $kdunit, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $kdkppn = $set['kdkppn'];
        $db = Database::getInstance();
        $conn = $db->getConnection(2);

        $query = "(SELECT KDBAES1, KDWILAYAH, KDKANWIL, KDKPPN, KDSATKER, KDFUNGSI, KDSFUNG, ";
        $query .="KDPROGRAM,KDGIAT, KDOUTPUT, KDMAKMAP, KDSDCP, THNANG, PERIODE,";
        $query .="RPHREAL, JNSDOK1, NODOK1, TGLDOK1, KDTRN, KDKAS, KDDEKON, KDJENDOK,";
        $query .="KDKANWILK, TGLPOST, KDCRBAY, KDBEBAN, KDJNSBAN, KDDK,";
        $query .="PERKSAU, PERKSAU1, PERKKUN, PERKKUN1, PERKKOR, PERKKOR1, REGISTER, KDBANKPOS, KPPNPAS,";
        $query .="NOREGIS, KDVALAS, NILKURS, TGLKURS, NOKARWAS, KDKEM, KDVAL, KDKM, CAD1, CAD2, KDBAES1PAS from t_glsaun ";
        $query .=" where thnang  = '$thnang' and kdkppn =  '$kdkppn' AND rphreal<>0 AND LEFT(kdbaes1,3)  like  '$kddept' ";
        $query .=" AND substr(kdbaes1,4,2)  like  '$kdunit' AND kdsatker like  '$kdsatker' AND kddekon like '$kddekon' and ";
        $query .=" convert(perksau,signed)<>'0' ";
        $query .="AND LEFT(perksau,4)<>1137 AND (LEFT(perksau,1)<>2 or LEFT(perksau,1)<>3) and kdtrn in (0,2,3) ";
        $query .="AND LEFT(perksau,2)<>41) UNION ALL (SELECT KDBAES1, KDWILAYAH, ' ' KDKANWIL, ";
        $query .="KDKPPN, KDSATKER, KDFUNGSI, KDSFUNG, ";
        $query .="KDPROGRAM, KDGIAT, KDOUTPUT, KDMAKMAP, KDSDCP, THNANG, PERIODE,";
        $query .="RPHREAL, JNSDOK1, NODOK1, TGLDOK1, KDTRN, KDKAS, KDDEKON, KDJENDOK,";
        $query .="KDKANWILK, TGLPOST, KDCRBAY, KDBEBAN, KDJNSBAN, KDDK,";
        $query .="PERKSAU, PERKSAU1, '' PERKKUN, '' PERKKUN1, '' PERKKOR, '' PERKKOR1,  REGISTER, '' KDBANKPOS, '' KPPNPAS,";
        $query .=" '' NOREGIS, '' KDVALAS, '' NILKURS, '' TGLKURS, NOKARWAS, KDKEM, ";
        $query .="KDVAL, KDKM, CAD1, CAD2, ''  KDSATKERPAS from t_glsaud ";
        $query .="where thnang  = '$thnang' and kdkppn =  '$kdkppn' AND rphreal<>0 AND LEFT(kdbaes1,3)  like  '$kddept' ";
        $query .="AND substr(kdbaes1,4,2)  like  '$kdunit' AND kdsatker  like  '$kdsatker'  AND ";
        $query .="kddekon like '$kddekon'  and convert(perksau,signed)<>'0' ";
        $query .="AND LEFT(perksau,4)<>1137 AND (LEFT(perksau,1)<>2 or LEFT(perksau,1)<>3) and kdtrn in (0,2,3) ";
        $query .="AND LEFT(perksau,2)<>41 ) UNION ALL (SELECT KDBAES1, KDWILAYAH, '', KDKPPN, KDSATKER, KDFUNGSI, KDSFUNG, ";
        $query .="KDPROGRAM, KDGIAT, KDOUTPUT, KDMAKMAP, KDSDCP, THNANG, PERIODE,";
        $query .="RPHREAL, JNSDOK1, NODOK1, TGLDOK1, KDTRN, KDKAS, KDDEKON, '',";
        $query .="KDKANWILK, TGLPOST, '' KDCRBAY, '' KDBEBAN, '' KDJNSBAN, KDDK,";
        $query .="PERKSAU, PERKSAU1, PERKKUN, PERKKUN1, PERKKOR, PERKKOR1, '' REGISTER, KDBANKPOS, '' KPPNPAS,";
        $query .=" '' NOREGIS, '' KDVALAS, '' NILKURS, '' TGLKURS, '' NOKARWAS, KDKEM, ";
        $query .="KDVAL, KDKM, CAD1, '', '' from t_glsaus ";
        $query .="where thnang  = '$thnang' and kdkppn =  '$kdkppn' AND rphreal<>0 AND LEFT(kdbaes1,3)  like  '$kddept' ";
        $query .="AND substr(kdbaes1,4,2)  like  '$kdunit' AND kdsatker  like  '$kdsatker'  AND ";
        $query .="kddekon like '$kddekon'  and convert(perksau,signed)<>'0' ";
        $query .="AND LEFT(perksau,4)<>1137 AND (LEFT(perksau,1)<>2 or LEFT(perksau,1)<>3) and kdtrn in (0,2,3) ";
        $query .=" AND LEFT(perksau,2)<>41 ) UNION ALL (SELECT KDBAES1PAS ";
        $query .="KDBAES1,KDWILAYAH,KDKANWIL,KDKPPN,KDSATKERPAS KDSATKER,KDFUNGSI, KDSFUNG, ";
        $query .="KDPROGRAM, KDGIAT, KDOUTPUT, KDMAKMAP, KDSDCP, THNANG, PERIODE,";
        $query .="RPHREAL, JNSDOK1, NODOK1, TGLDOK1, KDTRN, KDKAS, KDDEKON, KDJENDOK,";
        $query .="KDKANWILK, TGLPOST, KDCRBAY, KDBEBAN, KDJNSBAN, KDDK,";
        $query .="PERKSAU, PERKSAU1, PERKKUN, PERKKUN1, PERKKOR, PERKKOR1, REGISTER, KDBANKPOS, KPPNPAS,";
        $query .="NOREGIS, KDVALAS, NILKURS, TGLKURS, NOKARWAS, KDKEM, KDVAL, KDKM, CAD1, CAD2, KDBAES1PAS from t_glsaun ";
        $query .=" where thnang  = '$thnang' and kdkppn =  '$kdkppn' AND rphreal<>0 AND LEFT(kdbaes1pas,3)  like  '$kddept'  ";
        $query .="AND substr(kdbaes1pas,4,2) like '$kdunit' AND kdsatkerpas  like  '$kdsatker'  AND kddekon like '$kddekon' ";
        $query .=" AND LEFT(perkkun,3) in ('811', '821'))";


        $result = $conn->prepare($query);
        $result->execute();

        $resultarray = array();
        if ($result->rowCount() >= 1) {
            while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
                return $resultarray[] = $row;
            }
        }
        return false;
    }

    protected function insertRekonGLSau($data = array()) {
        if (!is_array($data)) {
            return false;
        }
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $values = $this->valuesOfArray($data);
        $query = "INSERT INTO rekon_tglsau(";
        $query .="KDBAES1, KDWILAYAH, KDKANWIL, KDKPPN, KDSATKER, KDFUNGSI, KDSFUNG, ";
        $query .="KDPROGRAM,KDGIAT, KDOUTPUT, KDMAKMAP, KDSDCP, THNANG, PERIODE,";
        $query .="RPHREAL, JNSDOK1, NODOK1, TGLDOK1, KDTRN, KDKAS, KDDEKON, KDJENDOK,";
        $query .="KDKANWILK, TGLPOST, KDCRBAY, KDBEBAN, KDJNSBAN, KDDK,";
        $query .="PERKSAU, PERKSAU1, PERKKUN, PERKKUN1, PERKKOR, PERKKOR1, REGISTER, KDBANKPOS, KPPNPAS,";
        $query .="NOREGIS, KDVALAS, NILKURS, TGLKURS, NOKARWAS, KDKEM, KDVAL, KDKM, CAD1, CAD2, KDBAES1PAS) ";
        $query .="VALUES " . implode(', ', $values);

        $result = $conn->prepare($query);

        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    protected function valuesOfArray($array = array()) {
        foreach ($array as $rowValues) {
            foreach ($rowValues as $key => $rowValue) {
                $rowValues[$key] = "'" . trim($rowValues[$key], ' ') . "'";
            }
            $values[] = "(" . implode(', ', $rowValues) . ")";
        }
        return $values;
    }

}

?>
