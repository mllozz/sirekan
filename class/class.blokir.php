<?php

class Blokir {

    public $id_blokir;
    public $id_user;
    public $date_started;
    public $date_ended;
    public $ket_blokir;
    protected $date_created;
    protected $date_updated;

    public function __construct($data = array()) {
        if (!is_array($data)) {
            trigger_error('Class baru tidak dapat diinisialisai ' . get_class($name));
        }

        if (count($data) > 0) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
            $this->date_created = date('Y-m-d H:i:s');
        }
    }
    
    public function isBlokir($id_user) {
        $db=  Database::getInstance();
        $conn=$db->getConnection(1);
        $date=date('Y-m-d');
        $query="SELECT * FROM blokir WHERE id_user='".$id_user."' AND";
        $query .= " date_ended > '".$date."'";

        $result=$conn->prepare($query);
        $result->execute();
        if($result->rowCount()==1) {
            return true;
        }
        return false;
    }
    
    public function getBlokir($id_user) {
        $db=  Database::getInstance();
        $conn=$db->getConnection(1);
        $date=date('Y-m-d');
        
        $query="SELECT * FROM blokir WHERE id_user='".$id_user."' ";
        $query .= " AND date_ended > '".$date."'";
        
        $result=$conn->prepare($query);
        $result->execute();
        if($result->rowCount()!=1) {
            return false;
        }
        return $result->fetch();
    }

    public function saveBlokir(){
        $db=Database::getInstance();
        $conn=$db->getConnection(1);
        $query="INSERT INTO blokir(id_user,date_started,date_ended,ket_blokir,date_created) ";
        $query .=" VALUES(?,?,?,?,?)";
        
        $arr=array($this->id_user,$this->date_started,$this->date_ended,$this->ket_blokir,$this->date_created);
        
        $result=$conn->prepare($query);
        
        $result->execute($arr);
        
        if($result->rowCount()==1) {
            return true;
        }
        return false;
    }
    
    public function ubahBlokir(){
        $db=Database::getInstance();
        $conn=$db->getConnection(1);
        $date=date('Y-m-d H:i:s');
        $query="UPDATE blokir SET date_started='".$this->date_started."', date_ended='".$this->date_ended."', ket_blokir='".$this->ket_blokir."',date_updated='".$date."' ";
        $query .=" WHERE id_blokir='".$this->id_blokir."'";
        
        $result=$conn->prepare($query);
        
        $result->execute();
        
        if($result->rowCount()==1) {
            return true;
        }
        return false;
    }
    
}

?>
