<?php

class LogRekon {

    protected $id_log;
    public $kddept;
    public $kdunit;
    public $kdsatker;
    public $kddekon;
    public $tgl_rekon;
    public $periode;
    public $id_status_rekon;
    public $date_created;
    public $date_updated;

    function __construct($data = array()) {
        $this->date_created = date('Y-m-d H:i:s');
        if (!is_array($data)) {
            return false;
        }

        if (count($data) > 0) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }

    public function insertLog(LogRekon $log) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "INSERT INTO log_rekon(kddept,kdunit,kdsatker,kddekon,
            tgl_rekon,periode,id_status_rekon,date_created) VALUES(?,?,?,?,?,?,?,?)";

        $data = array($log->kddept, $log->kdunit, $log->kdsatker, $log->kddekon, $log->tgl_rekon,
            $log->periode, $log->id_status_rekon, $log->date_created);

        $result = $conn->prepare($query);
        $result->execute($data);

        if ($result->rowCount() == 1) {
            return true;
        }
        return false;
    }

    public function cekLog($kddept, $kdunit, $kdsatker, $kddekon, $periode) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM log_rekon WHERE kddept='$kddept' AND kdunit='$kdunit' AND kdsatker='$kdsatker' 
                  AND kddekon='$kddekon' AND periode='$periode'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function updateLog($kddept, $kdunit, $kdsatker, $kddekon, $periode, $id_status_rekon) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $date_updated = date('Y-m-d H:i:s');
        $query = "UPDATE log_rekon SET id_status_rekon='$id_status_rekon',date_updated='$date_updated'  ";
        $query .=" WHERE kddept='$kddept' AND kdunit='$kdunit' AND kdsatker='$kdsatker' ";
        $query .= " AND kddekon='$kddekon' AND periode='$periode'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function insertLogServer($kdbaes1, $kdsatker, $kddekon, $periode, $jmlrec, $jendata) {
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $kdkppn = $set['kdkppn'];
        $tglterima = date('Y-m-d H:i:s');
        $db = Database::getInstance();
        $conn = $db->getConnection(2);

        $query = "insert into t_terima (thnang,kdbaes1,kdsatker,kddekon,
            periode,tglterima,jmlrec,kdkppn,jendata) 
            values ('$thnang','$kdbaes1','$kdsatker','$kddekon','$periode','$tglterima','$jmlrec','$kdkppn','$jendata')";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() == 1) {
            return true;
        }
        return false;
    }

}

?>