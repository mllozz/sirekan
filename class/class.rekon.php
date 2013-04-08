<?php

class Rekon {

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }

    public function cekRekonBenarSalah($kddept, $kdunit, $kdsatker, $periode, $kddekon) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $tgl_awal = $thnang . '-' . $periode . '-01';
        $tgl_akhir = $thnang . '-' . $periode . '-31';
        $UP = true;
        $Saldo = true;
        $RBelanja = true;
        $BPjk = true;
        $Pjk = true;
        $PBiaya = true;
        $KBiaya = true;
        $PBelanja = true;
        $rekonUP = $this->rekonUP($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonUP); $i++) {
            if ($rekonUP[$i]['HASIL'] == 'BEDA') {
                $UP = false;
                break;
            }
        }
        $rekonBP = $this->rekonPendapatanBPjk($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonBP); $i++) {
            if ($rekonBP[$i]['HASIL'] == 'BEDA') {
                $BPjk = false;
                break;
            }
        }
        $rekonP = $this->rekonPendapatanPajak($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonP); $i++) {
            if ($rekonP[$i]['HASIL'] == 'BEDA') {
                $Pjk = false;
               break;
            }
        }
        $rekonPBiaya = $this->rekonPenerimaanPembiayaan($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonPBiaya); $i++) {
            if ($rekonPBiaya[$i]['HASIL'] == 'BEDA') {
                $PBiaya = false;
                break;
            }
        }
        $rekonLBiaya = $this->rekonPengeluaranPembiayaan($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonLBiaya); $i++) {
            if ($rekonLBiaya[$i]['HASIL'] == 'BEDA') {
                $KBiaya = false;
                break;
            }
        }
        $rekonPBelanja = $this->rekonPengembalianBelanja($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonPBelanja); $i++) {
            if ($rekonPBelanja[$i]['HASIL'] == 'BEDA') {
                $PBelanja = false;
                break;
            }
        }
        $rekonRBelanja = $this->rekonRealBelanja($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonRBelanja); $i++) {
            if ($rekonRBelanja[$i]['HASIL'] == 'BEDA') {
                $RBelanja = false;
                break;
            }
        }
        $rekonSaldo = $this->rekonSaldo($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        for ($i = 0; $i < count($rekonSaldo); $i++) {
            if ($rekonSaldo[$i]['HASIL'] == 'BEDA') {
                $Saldo = false;
                break;
            }
        }
        $rekon = array(
            'UP' => $UP,
            'SALDO' => $Saldo,
            'RBelanja' => $RBelanja,
            'BPjk' => $BPjk,
            'Pjk' => $Pjk,
            'PBiaya' => $PBiaya,
            'KBiaya' => $KBiaya,
            'PBelanja' => $PBelanja,
        );
        if(in_array(false, $rekon)){
            $rek=new LogRekon();
            if($rekon['SALDO']==false){
                $rek->updateLog($kddept, $kdunit, $kdsatker, $kddekon, '00', 3);
            }else {
                $rek->updateLog($kddept, $kdunit, $kdsatker, $kddekon, $periode, 3);
            }    
        }
        return $rekon;
    }

    public function rekonUP($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, ";
        $query .= "IF(ISNULL(A.KDBAES1), B.KDBAES1, A.KDBAES1) AS KDBAES1, ";
        $query .= "IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= "IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= "IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= "IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, ";
        $query .= "IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL) AS RPSAU, ";
        $query .= "IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL) AS RPSAI,";
        $query .= "IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA') AS HASIL  ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, ";
        $query .= "JNSDOK1, LEFT(NODOK1, 20) AS NODOK1, ";
        $query .= "TGLDOK1, LEFT(KDPERK, 6) AS KDPERK, ";
        $query .= "RPHREAL FROM (SELECT KDBAES1, ";
        $query .= "KDSATKER,KDDEKON,JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, PERKSAU AS KDPERK,  ";
        $query .= "SUM(TRIM(RPHREAL)) RPHREAL ";
        $query .= "FROM rekon_tglsau ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= "AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND perksau is not null  ";
        $query .= "AND LEFT(perksau,4) = '1116'   ";
        $query .= "GROUP BY KDBAES1, KDSATKER,KDDEKON,";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK ";
        $query .= "ORDER BY KDBAES1, KDSATKER,KDDEKON,";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK ) D  ";
        $query .= "ORDER BY KDBAES1, KDSATKER, KDDEKON, ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK) E  ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, KDPERK ORDER BY KDBAES1, ";
        $query .= "KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) A ";
        $query .= "LEFT OUTER JOIN (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1,";
        $query .= "TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON,JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, PERKSAI AS KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM rekon_tglsai ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= "AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND perksai is not null ";
        $query .= "AND LEFT(perksai,4) = '1116'  ";
        $query .= "GROUP BY KDBAES1, ";
        $query .= "KDSATKER,KDDEKON,JNSDOK1, NODOK1, TGLDOK1, KDPERK ";
        $query .= "ORDER BY KDBAES1, KDSATKER,";
        $query .= "KDDEKON,JNSDOK1, NODOK1, TGLDOK1, KDPERK ) F  ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, KDPERK ORDER BY KDBAES1, ";
        $query .= "KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) B ";
        $query .= "ON A.KDPERK=B.KDPERK AND A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= "AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 AND A.NODOK1=B.NODOK1 ";
        $query .= "ORDER BY A.KDBAES1, A.KDSATKER, A.KDPERK, A.JNSDOK1, A.TGLDOK1, A.NODOK1";

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

    public function rekonPengeluaranPembiayaan($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, ";
        $query .= "IF(ISNULL(A.KDBAES1), B.KDBAES1, A.KDBAES1) AS KDBAES1, ";
        $query .= "IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= "IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= "IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= "IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, ";
        $query .= "IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL) AS RPSAU, ";
        $query .= "IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL) AS RPSAI,";
        $query .= "IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA') AS HASIL   ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, ";
        $query .= "KDPERK, SUM(RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1,";
        $query .= "TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1, ";
        $query .= "LEFT(NODOK1, 20) AS NODOK1, TGLDOK1, PERKSAU AS KDPERK, KDSDCP, ";
        $query .= "KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(TRIM(RPHREAL)) RPHREAL ";
        $query .= "FROM rekon_tglsau ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= "AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND ";
        $query .= "perksau IS NOT NULL AND kdtrn='3' ";
        $query .= "AND substr(jnsdok1,2,2) in('01','99','03') ";
        $query .= "and kdkem='0' and left(perksau, 2) in ('72')   ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1) D  ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK ORDER BY KDBAES1, KDSATKER, ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK) F  ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK ORDER BY KDBAES1, KDSATKER, ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK) A LEFT OUTER JOIN ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, PERKSAI AS KDPERK, KDSDCP, ";
        $query .= "KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) RPHREAL ";
        $query .= "FROM rekon_tglsai ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= "AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND perksai IS NOT NULL ";
        $query .= "AND kdtrn='3' AND substr(jnsdok1,2,2) in('01','99','03') ";
        $query .= "and kdkem='0' and left(perksai, 2) in ('72')    ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1) E  ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK ORDER BY KDBAES1, KDSATKER, ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK) B ON A.KDPERK=B.KDPERK AND ";
        $query .= "A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER AND ";
        $query .= "A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 AND A.NODOK1=B.NODOK1 ";
        $query .= "ORDER BY A.KDBAES1, A.KDSATKER, A.JNSDOK1, A.TGLDOK1, A.NODOK1, A.KDPERK";

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

    public function rekonPenerimaanPembiayaan($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, ";
        $query .= "IF(ISNULL(A.KDBAES1), B.KDBAES1, A.KDBAES1) AS KDBAES1, ";
        $query .= "IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= "IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= "IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= "IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, ";
        $query .= "IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL) AS RPSAU, ";
        $query .= "IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL) AS RPSAI,";
        $query .= "IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA') AS HASIL  ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK, SUM(-RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= "LEFT(NODOK1, 20) AS NODOK1, TGLDOK1, LEFT(KDPERK, 6) AS KDPERK, ";
        $query .= "KDSDCP, KDPROGRAM, KDGIAT, KDSGIAT, RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1,";
        $query .= "NODOK1, TGLDOK1, PERKSAU KDPERK,  KDSDCP,";
        $query .= "KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT,";
        $query .= "SUM(TRIM(RPHREAL)) RPHREAL FROM rekon_tglsau ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= "AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND perksau IS NOT NULL ";
        $query .= "AND kdtrn='3' and kdkem='0' ";
        $query .= "AND substr(jnsdok1,2,2) in('02','05','99','04') ";
        $query .= "and left(perksau, 2) in ('71') and left(perksau,2) not in ('41') ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1)  D ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDSGIAT, KDBAES1, KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1) E ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, KDPERK ORDER BY KDBAES1, ";
        $query .= "KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) A ";
        $query .= "LEFT OUTER JOIN (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK, SUM(-RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, PERKSAI AS KDPERK, KDSDCP, ";
        $query .= "KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) RPHREAL ";
        $query .= "FROM rekon_tglsai ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= "AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND perksai IS NOT NULL ";
        $query .= "AND kdtrn='3' and kdkem='0' ";
        $query .= "AND substr(jnsdok1,2,2) in('02','05','99','04') ";
        $query .= "and left(perksai, 2) in ('71') and left(perksai,2) not in ('41')  ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1) C ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, ";
        $query .= "KDPERK ORDER BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) B ";
        $query .= "ON A.KDPERK=B.KDPERK ";
        $query .= "AND A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= "AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 ";
        $query .= "AND A.NODOK1=B.NODOK1 ORDER BY A.KDBAES1, ";
        $query .= "A.KDSATKER, A.KDPERK, A.JNSDOK1, A.TGLDOK1, A.NODOK1";

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

    public function rekonPendapatanPajak($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {
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
        $query .= "IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL), 'SAMA', 'BEDA') HASIL, ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK, SUM(-RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= "LEFT(NODOK1, 20) AS NODOK1, TGLDOK1, ";
        $query .= "LEFT(KDPERK, 6) AS KDPERK, KDSDCP, KDPROGRAM, ";
        $query .= "KDGIAT, KDSGIAT, RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1, NODOK1, TGLDOK1, ";
        $query .= " PERKSAU KDPERK,  KDSDCP, KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT,";
        $query .= " SUM(TRIM(RPHREAL)) RPHREAL FROM rekon_tglsau ";
        $query .= " where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "  AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND perksau IS NOT NULL ";
        $query .= " AND kdtrn='3' and kdkem='0' ";
        $query .= " AND substr(jnsdok1,2,2) in('02','05','99','04') ";
        $query .= " and left(perksau,2) in ('41')   ";
        $query .= " GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= " KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= " ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= " KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ) D ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDSGIAT, KDBAES1, KDSATKER, KDPERK, ";
        $query .= "JNSDOK1, TGLDOK1, NODOK1) E GROUP BY KDBAES1, KDSATKER, ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK ";
        $query .= "ORDER BY KDBAES1, KDSATKER, JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, KDPERK) A LEFT OUTER JOIN ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK, SUM(-RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= "NODOK1, TGLDOK1, PERKSAI AS KDPERK, KDSDCP, ";
        $query .= "KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, ";
        $query .= "SUM(RPHREAL) RPHREAL FROM rekon_tglsai ";
        $query .= "where tglpost >= '$tgl_akhir' AND ";
        $query .= "tglpost <= '$tgl_awal' AND LEFT(kdbaes1,3) = '$kddept' ";
        $query .= "AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker'  AND kddekon='$kddekon' AND perksai IS NOT NULL ";
        $query .= " AND kdtrn='3' and kdkem='0' ";
        $query .= " AND substr(jnsdok1,2,2) in('02','05','99','04') and left(perksai, 2) in ('41') ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= "KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1) C  ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, ";
        $query .= "TGLDOK1, KDPERK ORDER BY KDBAES1, KDSATKER, ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK) B ON A.KDPERK=B.KDPERK AND ";
        $query .= " A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= " AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 AND A.NODOK1=B.NODOK1 ";
        $query .= " ORDER BY A.KDBAES1, A.KDSATKER, A.KDPERK, A.JNSDOK1, A.TGLDOK1, A.NODOK1";

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

    public function rekonPendapatanBPjk($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, ";
        $query .= " IF(ISNULL(A.KDBAES1), B.KDBAES1, A.KDBAES1) AS KDBAES1, ";
        $query .= " IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= " IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= " IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= " IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, ";
        $query .= " IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL) AS RPSAU, ";
        $query .= " IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL) AS RPSAI ,";
        $query .= " IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA') AS HASIL  ";
        $query .= " FROM ( SELECT KDBAES1, KDSATKER+KDDEKON AS KDSATKER, ";
        $query .= " JNSDOK1, NODOK1, TGLDOK1, KDPERK, SUM(-RPHREAL) AS RPHREAL ";
        $query .= " FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= " LEFT(NODOK1, 20) AS NODOK1, TGLDOK1, LEFT(KDPERK, 6) AS KDPERK, ";
        $query .= " KDSDCP, KDPROGRAM, KDGIAT, KDSGIAT, RPHREAL FROM ";
        $query .= " (SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1, ";
        $query .= " NODOK1 NODOK1, TGLDOK1, ";
        $query .= " PERKSAU KDPERK,  KDSDCP, ";
        $query .= " KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(TRIM(RPHREAL)) RPHREAL ";
        $query .= " FROM rekon_tglsau where tglpost >= '$tgl_awal' ";
        $query .= " AND tglpost <= '$tgl_akhir' AND";
        $query .= " LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND kdtrn='3' and kdkem='0' ";
        $query .= " AND  PERKSAU IS NOT NULL ";
        $query .= " AND substr(jnsdok1,2,2) in('02','05','99','04') ";
        $query .= " and left(perksau, 1) in ('4') and left(perksau,2) not in ('41')   ";
        $query .= " GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= " KDOUTPUT, KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= " ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= " KDOUTPUT, KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1) D ";
        $query .= " ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= " KDSGIAT, KDBAES1, KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1) E ";
        $query .= " GROUP BY KDBAES1, KDSATKER, KDDEKON, ";
        $query .= " JNSDOK1, NODOK1, TGLDOK1, KDPERK ";
        $query .= " ORDER BY KDBAES1, KDSATKER, ";
        $query .= " KDDEKON, JNSDOK1, NODOK1, TGLDOK1, KDPERK) A ";
        $query .= " LEFT OUTER JOIN ( SELECT KDBAES1, KDSATKER+KDDEKON AS KDSATKER, ";
        $query .= " JNSDOK1, NODOK1, TGLDOK1, KDPERK, SUM(-RPHREAL) AS RPHREAL ";
        $query .= " FROM ( SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= " NODOK1, TGLDOK1, PERKSAI AS KDPERK, KDSDCP, ";
        $query .= " KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) RPHREAL ";
        $query .= " FROM rekon_tglsai where tglpost >= '$tgl_awal' AND";
        $query .= " tglpost <= '$tgl_akhir' AND LEFT(kdbaes1,3) = '$kddept' ";
        $query .= " AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND kdtrn='3' and kdkem='0' ";
        $query .= " AND  PERKSAI IS NOT NULL ";
        $query .= " AND substr(jnsdok1,2,2) in('02','05','99','04') ";
        $query .= " and left(perksai, 1) in ('4') and left(perksai, 2) not in ('41')  ";
        $query .= " GROUP BY KDSDCP, KDDEKON, KDPROGRAM, ";
        $query .= " KDGIAT, KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "  ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, ";
        $query .= " KDOUTPUT, KDBAES1, KDSATKER, PERKSAI, JNSDOK1, ";
        $query .= " TGLDOK1, NODOK1 ) C  ";
        $query .= " GROUP BY KDBAES1, KDSATKER, KDDEKON, JNSDOK1, ";
        $query .= " NODOK1, TGLDOK1, KDPERK ORDER BY KDBAES1, ";
        $query .= " KDSATKER, KDDEKON, JNSDOK1, NODOK1, ";
        $query .= " TGLDOK1, KDPERK) B ON A.KDPERK=B.KDPERK AND ";
        $query .= " A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= " AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 AND A.NODOK1=B.NODOK1 ";
        $query .= " ORDER BY A.KDBAES1, A.KDSATKER, A.KDPERK, A.JNSDOK1, A.TGLDOK1, A.NODOK1";

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

    public function rekonPengembalianBelanja($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, ";
        $query = "IF(ISNULL(A.KDBAES1), B.KDBAES1, A.KDBAES1) AS KDBAES1, ";
        $query .= "IF(ISNULL(A.KDSATKER), B.KDSATKER, A.KDSATKER) AS KDSATKER, ";
        $query .= "IF(ISNULL(A.JNSDOK1), B.JNSDOK1, A.JNSDOK1) AS JNSDOK1, ";
        $query .= "IF(ISNULL(A.TGLDOK1), B.TGLDOK1, A.TGLDOK1) AS TGLDOK1, ";
        $query .= "IF(ISNULL(A.NODOK1), B.NODOK1, A.NODOK1) AS NODOK1, ";
        $query .= "IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL) AS RPSAU, ";
        $query .= "IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL) AS RPSAI,";
        $query .= "IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA')  HASIL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, ";
        $query .= "SUM(RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, LEFT(NODOK1, 20) AS NODOK1, ";
        $query .= "TGLDOK1, LEFT(KDPERK, 6) AS KDPERK, KDSDCP, KDPROGRAM, KDGIAT, KDSGIAT, ";
        $query .= "-RPHREAL AS RPHREAL FROM (SELECT KDBAES1, KDSATKER, KDDEKON , ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, PERKSAU KDPERK,  ";
        $query .= "KDSDCP, KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(TRIM(RPHREAL)) RPHREAL ";
        $query .= "FROM rekon_tglsau where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND kdtrn='3' ";
        $query .= " AND substr(jnsdok1,2,2) in('02','04','05','99','07') ";
        $query .= " and kdkem='1' and left(perksau, 1) in ('5','6') ";
        $query .= "GROUP BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, ";
        $query .= "KDBAES1, KDSATKER, PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, KDBAES1, KDSATKER, ";
        $query .= "PERKSAU, JNSDOK1, TGLDOK1, NODOK1 ) D ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDSGIAT, ";
        $query .= "KDBAES1, KDSATKER, KDPERK, JNSDOK1, TGLDOK1, NODOK1)  E ";
        $query .= "GROUP BY KDBAES1, KDSATKER, ";
        $query .= "JNSDOK1, NODOK1, TGLDOK1, KDPERK ";
        $query .= "ORDER BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) A ";
        $query .= "LEFT OUTER JOIN (SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, ";
        $query .= "KDPERK, SUM(RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, NODOK1, TGLDOK1, ";
        $query .= "PERKSAI AS KDPERK, KDSDCP, KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, ";
        $query .= "SUM(-RPHREAL) RPHREAL FROM rekon_tglsai where tglpost >= '$tgl_awal' ";
        $query .= "AND tglpost <= '$tgl_akhir' AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon' AND kdtrn='3' ";
        $query .= " AND substr(jnsdok1,2,2) in('02','04','05','99','07') ";
        $query .= " and kdkem='1' and left(perksai, 1) in ('5','6')   ";
        $query .= " GROUP BY KDSDCP, ";
        $query .= "KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, KDBAES1, ";
        $query .= "KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1 ";
        $query .= "ORDER BY KDSDCP, KDDEKON, KDPROGRAM, KDGIAT, KDOUTPUT, KDBAES1, ";
        $query .= "KDSATKER, PERKSAI, JNSDOK1, TGLDOK1, NODOK1) C  ";
        $query .= "GROUP BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, ";
        $query .= "KDPERK ORDER BY KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK) B ";
        $query .= "ON A.KDPERK=B.KDPERK AND";
        $query .= " A.KDPERK+A.KDBAES1+A.KDSATKER=B.KDPERK+B.KDBAES1+B.KDSATKER ";
        $query .= " AND A.JNSDOK1=B.JNSDOK1 AND A.TGLDOK1=B.TGLDOK1 AND A.NODOK1=B.NODOK1 ";

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

    public function rekonRealBelanja($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT IF(ISNULL(A.KDPERK), B.KDPERK, A.KDPERK) AS KDPERK, IF(ISNULL(A.KDBAES1), ";
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
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon' ";
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
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' ";
        $query .= "AND LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon' ";
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
        $query .= "AND A.NODOK1=B.NODOK1 ORDER BY A.KDBAES1, A.KDSATKER, A.JNSDOK1, A.TGLDOK1, A.NODOK1, A.KDPERK";

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

    public function rekonSaldo($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon) {
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
        $query .= "IF(IF(ISNULL(A.RPHREAL), 000000000000000000, A.RPHREAL)=IF(ISNULL(B.RPHREAL), 000000000000000000, B.RPHREAL),'SAMA','BEDA') HASIL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, JNSDOK1, NODOK1, TGLDOK1, KDPERK, ";
        $query .= "SUM(-RPHREAL) AS RPHREAL ";
        $query .= "FROM (SELECT KDBAES1, KDSATKER, KDDEKON, JNSDOK1, LEFT(NODOK1, 40) AS NODOK1, ";
        $query .= "TGLDOK1, LEFT(KDPERK, 2) AS KDPERK, KDSDCP, ";
        $query .= "KDPROGRAM, KDGIAT, KDSGIAT, SUM(RPHREAL) AS RPHREAL FROM ";
        $query .= "(SELECT KDBAES1, KDSATKER, KDDEKON ,JNSDOK1, NODOK1, TGLDOK1, LEFT(PERKSAU ,4) KDPERK,  ";
        $query .= "KDSDCP, KDPROGRAM, KDGIAT, KDOUTPUT KDSGIAT, SUM(RPHREAL) RPHREAL FROM rekon_tglsau ";
        $query .= "where tglpost >= '$tgl_awal' AND tglpost <= '$tgl_akhir' AND ";
        $query .= "LEFT(kdbaes1,3) = '$kddept' AND substr(kdbaes1,4,2) = '$kdunit' ";
        $query .= " AND kdsatker = '$kdsatker' AND kddekon='$kddekon'  AND kdtrn='2' ";
        $query .= " AND substr(jnsdok1,2,2) in('02','03','99') ";
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
        $query .= " AND kdsatker = '$kdsatker'  AND kddekon='$kddekon' AND kdtrn='2' ";
        $query .= " AND substr(jnsdok1,2,2) in('02','03','99') ";
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
