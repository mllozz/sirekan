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
            return $this->readSA($filename);
        }elseif($id_rekon=='2') {
            //read sai
        }else {
            return 'Gagal Mendapatkan file';
        }
    }
    
    public function readSA($filename){
        $file='adk/'.$filename;
        $pointer=fopen($file, 'rb');
        $data=  fread($pointer, filesize($file));
        return $data;
    }
}
?>
