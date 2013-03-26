<?php

class Setup {
    
    public function getSetup(){
        $db=  Database::getInstance();
        $conn=$db->getConnection(2);

        $query="select  kdkppn,thnang from t_setup ";
        
        $result=$conn->prepare($query);
        $result->execute();

        if($result->rowCount()!=1) {
            return false;
        }
        $data=$result->fetch();

        return $data;
    }
}
?>
