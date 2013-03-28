<?php

class Rekon {

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }

    public function rekonSaldo($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, ";
        $query .= "IF(ISNULL(A.KDBAES1), B.KDBAES1, A.KDBAES1) AS KDBAES1, ";
        $query .= "IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= "IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= "IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= "IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, ";
        $query .= "IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL) AS RPSAU, ";
        $query .= "IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL) AS RPSAI, ";
        $query .= "IF(A.RPHREAL=B.RPHREAL,'SAMA','BEDA') HASIL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, ";
        $query .= "SUM(-RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, LEFT(NODOK1, 40) AS NODOK1, ";
        $query .= "TGLDOK1, LEFT(KDPERK, 2) AS KDPERK, KDSDCP, ";
        $query .= "KDPROGRAM, KDGIAT, KDSGIAT, SUM(RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1, NODOK1, TGLDOK1, LEFT(PERKSAU ,4) KDPERK,  ";
        $query .= "KDSDCP, KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) RPHREAL FROM rekon_tglsau ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' AND ";
        $query .= "LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker'  AND kdtrn='2' AND substr(jnsdok1,2,2) in('02','03','99') ";
        $query .= " and left(perksau, 1) in ('5','6','7') ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, KDBAES1, ";
        $query .= "KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ) x ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDSGIAT, ";
        $query .= "KDBAES1, KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDSGIAT, KDBAES1, ";
        $query .= "KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1) xx ";
        $query .= "GROUP BY KDPERK, KDBAES1, KDSATKER, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDPERK, KDBAES1, KDSATKER, JNSDOK1, TGLDOK1, NODOK1) A LEFT OUTER JOIN ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, SUM(-RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= "LEFT(NODOK1, 40) AS NODOK1, TGLDOK1, LEFT(KDPERK, 2) AS KDPERK, ";
        $query .= "KDSDCP, KDPROGRAM, KDGIAT, KDSGIAT, SUM(RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, NODOK1, TGLDOK1, ";
        $query .= "LEFT(PERKSAI,4) AS KDPERK, KDSDCP, KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM rekon_tglsai where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kdtrn='2' AND substr(jnsdok1,2,2) in('02','03','99') ";
        $query .= " and left(perksai, 1) in ('5','6','7')   ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, KDBAES1, ";
        $query .= "KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1) z ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM,KDGIAT, KDSGIAT, KDBAES1, ";
        $query .= "KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDSGIAT, KDBAES1, ";
        $query .= "KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1) zz ";
        $query .= "GROUP BY KDPERK, KDBAES1, KDSATKER, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDPERK, KDBAES1, KDSATKER, JNSDOK1, TGLDOK1, NODOK1) B ";
        $query .= "ON A.KDPERK=B.KDPERK AND A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= "AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 ";
        $query .= "AND A.NODOK1=B.NODOK1 ORDER BY A.KDPERK, A.KDBAES1, A.KDSATKER, A.JNSDOK1, A.TGLDOK1, A.NODOK1";

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
