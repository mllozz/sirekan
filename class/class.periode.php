<?php

class Periode {

    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }

    public function getPeriode() {
        $db = Database::getInstance();
        $conn = $db->getConnection(2);

        $query = "select  periode kdperiode,bulan1 nmbulan from t_periode";

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
