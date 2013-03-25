<?php

class Adk {

     /**
     * Mendapatkan file dari direktori adk
     * @param string $file
     * @param int
     *  $id_rekon
     * @return boolean
     */
    public function getAdkFile($filename) {
            return $this->read($filename);
    }

    public function read($filename) {
        $file = '../adk/' . $filename;
        $reader = new Prodigy_DBF($file);
        $i = 0;
        $data[] = array();
        while (($hasil = $reader->GetNextRecord(true)) && !empty($hasil)) {
            $data[$i] = $hasil;
            $i++;
        }
        return $data;
    }

}

?>
