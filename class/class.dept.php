<?php

class Dept {
    public $kddept;
    public $nmdept;
    
    public function __construct($data=array()){
        if (!is_array($data)) {
            trigger_error('Class baru tidak dapat diinisialisai ' . get_class($name));
        }

        if (count($data) > 0) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
            $this->date_created = time();
        }
    }
    
    protected function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }
    
    final public function getDept($kddept) {
        $db=Database::getInstance();
        $conn=$db->getConnection(2);
        
        $query="SELECT kddept,nmdept FROM t_dept WHERE kddept='".$kddept."'";
        
        $result=$conn->prepare($query);
        $result->execute();
        
        if($result->rowCount()!=1) {
            return false;
        }
        $class = get_called_class();
        $result->setFetchMode(PDO::FETCH_CLASS, $class);
        $data=$result->fetch();
        
        return $data;
    }
}

