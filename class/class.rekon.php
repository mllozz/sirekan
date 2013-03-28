<?php

class Rekon {

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }

    /**
     * Cek apakah pernah rekon saldo awal sebelumnya
     * @param type $kdbaes
     * @param type $kdsatker
     * @return boolean
     */
    public function cekRekonSA($kdbaes, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM adk_glsa WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND KDDEKON='$kddekon' AND THNANG<'$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function cekRekonSASp2d($kdbaes, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM t_glsai WHERE kdbaes1='$kdbaes' AND kdsatker='$kdsatker' AND kddekon='$kddekon' AND thnang<'$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah pernah rekon saldo awal sebelumnya
     * @param type $kdbaes
     * @param type $kdsatker
     * @return boolean
     */
    public function cekRekonSakpa($kdbaes, $kdsatker, $periode, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM adk_glsakpa WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND KDDEKON='$kddekon' AND  PERIODE<='$periode' AND THNANG='$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function cekRekonSakpaSp2d($kdbaes, $kdsatker, $periode, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM t_glsai WHERE kdbaes1='$kdbaes' AND kdsatker='$kdsatker' AND kddekon='$kddekon' AND  periode<='$periode' AND thnang='$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function insertAdkGLSA($data = array()) {
        if (!is_array($data)) {
            return false;
        }
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $values = $this->valuesOfArray($data);
        $query = "INSERT INTO adk_glsa VALUES " . implode(', ', $values);
        //print_r($query);
        $result = $conn->prepare($query);

        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function getAdkSA($kdbaes, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $kdkppn = $set['kdkppn'];
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "select kdbaes1,kdwilayah,kdkanwil,";
        $query.="kdkppn,kdsatker,kdfungsi,kdsfung,kdprogram,kdgiat,";
        $query.="kdsgiat,kdmakmap,kddk,kdsdcp,perksai,perksai1,perkkor,perkkor1,";
        $query.="thnang,periode,rphreal,tglkirim,tglupdate,jnsdok1,";
        $query.="nodok1,kdtrn,kdkas,kddekon,register,kdjendok,";
        $query.="kdkanwilk,tglpost,kdcrbay,noregis,kdvalas,nilkurs,nokarwas,";
        $query.="kdkem,kdval,kdkm,cad1,cad2,kdbeban,kdjnsban,kdkpknl,stat_rekon,trn_bmn,'$kdkppn' kppnasal,kdoutput ";
        $query.=" from adk_glsa ";
        $query .= " WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND KDDEKON='$kddekon' AND THNANG<'$thnang'";

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

    public function getAdkSakpa($kdbaes, $kdsatker, $periode, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $kdkppn = $set['kdkppn'];
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "select kdbaes1,kdwilayah,kdkanwil,";
        $query .= "kdkppn,kdsatker,kdprogram,kdgiat,";
        $query .= "kdmakmap,kddk,kdsdcp,perksai,perksai1,perkkor,perkkor1,";
        $query .= "thnang,periode,rphreal,if(tglkirim='0000-00-00','1000-01-01',TGLKIRIM) tglkirim,";
        $query .= "if(tglupdate='0000-00-00','1000-01-01',tglupdate) tglupdate,jnsdok1,";
        $query .= "nodok1,if(tgldok1='0000-00-00','1000-01-01',tgldok1) tgldok1,kdtrn,kdkas,kddekon,register,kdjendok,";
        $query .= "tglpost,kdcrbay,noregis,kdvalas,nilkurs,tglkurs,nokarwas,";
        $query .= "kdkem,kdval,kdkm,cad1,cad2,kdbeban,kdjnsban,kdkpknl,stat_rekon,trn_bmn,'$kdkppn' kppnasal,";
        $query .= "kdoutput,NOW() terima from adk_glsakpa";
        $query .= " WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND KDDEKON='$kddekon' AND PERIODE<='$periode' AND THNANG='$thnang'";

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

    public function insertGLSA($data = array()) {
        if (!is_array($data)) {
            return false;
        }
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $values = $this->valuesOfArray($data);

        $query = "INSERT INTO t_glsai";
        $query.="(kdbaes1,kdwilayah,kdkanwil,";
        $query.="kdkppn,kdsatker,kdfungsi,kdsfung,kdprogram,kdgiat,";
        $query.="kdsgiat,kdmakmap,kddk,kdsdcp,perksai,perksai1,perkkor,perkkor1,";
        $query.="thnang,periode,rphreal,tglkirim,tglupdate,jnsdok1,";
        $query.="nodok1,kdtrn,kdkas,kddekon,register,kdjendok,";
        $query.="kdkanwilk,tglpost,kdcrbay,noregis,";
        $query.="kdvalas,nilkurs,nokarwas,kdkem,kdval,kdkm,cad1,cad2,kdbeban,";
        $query.="kdjnsban,kdkpknl,stat_rekon,trn_bmn,kppnasal,KDOUTPUT) ";
        $query.="VALUES " . implode(', ', $values);

        $result = $conn->prepare($query);

        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function insertGLSakpa($data = array()) {
        if (!is_array($data)) {
            return false;
        }
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $values = $this->valuesOfArray($data);

        $query = "INSERT INTO t_glsai";
        $query.="(kdbaes1,kdwilayah,kdkanwil,";
        $query.="kdkppn,kdsatker,kdprogram,kdgiat,";
        $query.="kdmakmap,kddk,kdsdcp,perksai,perksai1,perkkor,perkkor1,";
        $query.="thnang,periode,rphreal,tglkirim,tglupdate,jnsdok1,";
        $query.="nodok1,tgldok1,kdtrn,kdkas,kddekon,register,kdjendok,";
        $query.="tglpost,kdcrbay,noregis,";
        $query.="kdvalas,nilkurs,tglkurs,nokarwas,kdkem,kdval,kdkm,cad1,cad2,kdbeban,";
        $query.="kdjnsban,kdkpknl,stat_rekon,trn_bmn,kppnasal,KDOUTPUT,tglterima) ";
        $query.="VALUES " . implode(', ', $values);
 
        $result = $conn->prepare($query);

        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function insertAdkGLSakpa($data = array()) {
        if (!is_array($data)) {
            return false;
        }
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $values = $this->valuesOfArray($data);
        $query = "INSERT INTO adk_glsakpa VALUES " . implode(', ', $values);
        //print_r($query);
        $result = $conn->prepare($query);

        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function deleteRekonSALokal($kdbaes, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "DELETE FROM adk_glsa WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND KDDEKON='$kddekon'  AND thnang<'$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function deleteRekonSASp2d($kdbaes, $kdsatker, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "DELETE FROM t_glsai WHERE kdbaes1='$kdbaes' AND kdsatker='$kdsatker' AND kddekon='$kddekon' AND thnang<'$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function deleteRekonSakpaLokal($kdbaes, $kdsatker, $periode, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "DELETE FROM adk_glsakpa WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND PERIODE<='$periode' AND THNANG='$thnang' AND KDDEKON='$kddekon'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function deleteRekonSakpaSp2d($kdbaes, $kdsatker, $periode, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "DELETE FROM t_glsai WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND PERIODE<='$periode' AND THNANG='$thnang' AND KDDEKON='$kddekon'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function valuesOfArray($array = array()) {
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
