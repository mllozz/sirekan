<?php

class Pejabat {

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }

    public function getPejabat() {
        $db = Database::getInstance();
        $conn = $db->getConnection(2);

        $query = "select  nip,nama,nip2 from t_pejabt where ketjabatan='4'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() != 1) {
            return false;
        }
        $data = $result->fetch();

        return $data;
    }
    
    public function getKpa($kddept, $kdunit, $kdsatker, $kddekon,$thang){
        $db = Database::getInstance();
        $conn = $db->getConnection(2);

        $query = "select  kpa from d_kpa where kddep='$kddept' AND kdunit='$kdunit' AND kdsatker='$kdsatker'
                 AND kddekon='$kddekon' AND thang='$thang'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() != 1) {
            return false;
        }
        $data = $result->fetch();

        return $data;
    }
}
?>
