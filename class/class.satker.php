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
    public function getSatker() {
        $db=  Database::getInstance();
        $conn=$db->getConnection(2);

        $query="SELECT kdsatker,kddept,kdunit,nmsatker,kdjnssat,kdkppn ";
        $query .="FROM t_satker WHERE kdsatker='".$this->kdsatker."' AND ";
        $query .="kddept='".$this->kddept."' AND kdunit='".$this->kdunit."'";
        
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
    
    public function getKewenangan(){
        $db=  Database::getInstance();
        $conn=$db->getConnection(2);

        $query="select DISTINCT kddekon from d_pagu ";
        $query .=" WHERE kdsatker='".$this->kdsatker."' AND ";
        $query .=" kddept='".$this->kddept."' AND kdunit='".$this->kdunit."' group by kddept,kdunit,kdsatker,kddekon";
        
        $result=$conn->prepare($query);
        $result->execute();

        if($result->rowCount()!=1) {
            return false;
        }
        $data=$result->fetch();

        return $data;
    }
    
    
    public function getJmlSatker(){
        $set=new Setup();
        
        $kppn=$set->getSetup();
        $kdkppn=$kppn['kdkppn'];
        
        $db=  Database::getInstance();
        $conn=$db->getConnection(2);

        $query="select count(*) jml from  (select count(DISTINCT kdsatker) jml from d_pagu ";
        $query .=" WHERE kdkppn='$kdkppn' group by kddept,kdunit,kdsatker,kddekon) a";
        
        $result=$conn->prepare($query);
        $result->execute();

        if($result->rowCount()!=1) {
            return false;
        }
        $data=$result->fetch();

        return $data;
    } 
    
    public function getAllSatker(){
        $set=new Setup();
        
        $kppn=$set->getSetup();
        $kdkppn=$kppn['kdkppn'];
        
        $db=  Database::getInstance();
        $conn=$db->getConnection(2);

        $query="select distinct kddept,kdunit,kdsatker,kddekon from d_pagu ";
        $query .=" WHERE kdkppn='$kdkppn' group by kddept,kdunit,kdsatker,kddekon order by kddept,kdunit,kdsatker";
        
        $result=$conn->prepare($query);
        $result->execute();

        if($result->rowCount()==0) {
            return false;
        }
        $data=$result->fetchAll();

        return $data;
    }

}