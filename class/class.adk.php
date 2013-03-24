<?php
class Adk {
    
    /**
     * Mendapatkan file dari direktori adk
     * @param string $file
     * @param int
     *  $id_rekon
     * @return boolean
     */
    public function getFile($filename,$id_rekon) {
        if($id_rekon=='1') {
            //read saldo awal
            return $this->read($filename);
        }elseif($id_rekon=='2') {
            //read sai
            return $this->read($filename);
        }else {
            return 'Gagal Mendapatkan file';
        }
    }
    
    public function read($filename){
        $file='adk/'.$filename;
        $reader=new Prodigy_DBF($file);
        $i=0;
        $data[]=array();
        while(($hasil=$reader->GetNextRecord(true)) && !empty($hasil)) {
            $data[$i]=$hasil;
            $i++;
        }
        return $data;
        
    }
    
    /**
     * Cek apakah pernah rekon saldo awal sebelumnya
     * @param type $kdbaes
     * @param type $kdsatker
     * @return boolean
     */
    public function cekRekonSA($kdbaes,$kdsatker) {
        $thnang=2011;
        $db=  Database::getInstance();
        $conn=$db->getConnection(1);
        
        $query="SELECT * FROM glsa WHERE KDBAES1='$kdbaes' AND KDSATKER='$kdsatker' AND THNANG='$thnang'";
        $result=$conn->prepare($query);
        $result->execute();
        
        if($result->rowCount()>=1) {
            return true;
        }
        return false;
    }
}
?>
