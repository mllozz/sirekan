<?php

class Satker {

    public $kdsatker;
    public $kddept;
    public $kdunit;
    public $nmsatker;
    public $kdjnssat;
    
    public function __construct($data=array()) {
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
    
    /**
     * Fungsi autoload class
     */
    function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }
    
    /**
     * Get satker berdasarkan satker
     * @return boolean jika salah
     * @return array
     */
    public function getSatker(Satker $satker) {
        $db=  Database::getInstance();
        $conn=$db->getConnection(2);

        $query="SELECT kdsatker,kddept,kdunit,nmsatker,kdjnssat ";
        $query .="FROM t_satker WHERE kdsatker='".$satker->kdsatker."' AND ";
        $query .="kddept='".$satker->kddept."' AND kdunit='".$satker->kdunit."'";
        
        $result=$conn->prepare($query);
        $result->execute();
        
        if($result->rowCount()!=1) {
            return false;
        }
        $class = get_called_class();
        $result->setFetchMode(PDO::FETCH_CLASS, $class);
        $data=$result->fetch();
        
        $data=get_object_vars($data);
        return $data;
    }
    

}