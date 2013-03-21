<?php

class Loguser {
    
    protected $id_surat;
    public $id_user;
    public $no_surat;
    public $tgl_surat;
    public $id_jns_trs;
    
    
    function __construct($data = array()) {
        if (!is_array($data)) {
            trigger_error('Class baru tidak dapat diinisialisai ' . get_class($name));
        }

        if (count($data) > 0) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
        }
    }
    
    /**
     * Fungsi autoload class
     */
    function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }
    
    /**
     * Save log ke table user_log
     * @return boolean
     */
    public function saveLog(){
        $db=Database::getInstance();
        $conn=$db->getConnection(1);
        
        $query="INSERT INTO user_log(id_user,no_surat,tgl_surat,id_jns_trs) VALUES(?,?,?,?)";
        
        $arr=array($this->id_user,$this->no_surat,$this->tgl_surat,$this->id_jns_trs);
        
        $result=$conn->prepare($query);
        $result->execute($arr);
        
        if($result->rowCount()==1) {
            return true;
        }
        return false;
    }
}
?>
