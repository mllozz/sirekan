<?php

class JenisRekon {
    
    public $id_jns_rekon;
    public $nm_rekon;

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }

    public function getJnsRekon() {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "select  * from jns_rekon";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() == 0) {
            return false;
        }
        $data = $result->fetchAll();

        return $data;
    }

}

?>
