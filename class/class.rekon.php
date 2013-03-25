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
    public function cekRekonSA($kdbaes, $kdsatker) {
        $thnang = 2011;
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM glsa WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND THNANG='$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }

    public function insertGLSA($data = array()) {
        if (!is_array($data)) {
            return false;
        }
        $db=  Database::getInstance();
        $conn=$db->getConnection(1);
        $values=$this->valuesOfArray($data);
        $query="INSERT INTO glsa VALUES " . implode (', ', $values);
        //print_r($query);
        $result=$conn->prepare($query);
        
        $result->execute();
        
        if($result->rowCount()>1) {
            return true;
        }
        return false;
    }
    
    public function deleteRekonSA($kdbaes, $kdsatker) {
        $thnang = 2011;
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "DELETE FROM glsa WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND THNANG='$thnang'";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() >= 1) {
            return true;
        }
        return false;
    }
}
?>
