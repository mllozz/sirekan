<?php

class Adk {

     /**
     * Mendapatkan file dari direktori adk
     * @param string $file
     * @param int
     *  $id_rekon
     * @return boolean
     */
    public function getFile($filename, $id_rekon) {
        if ($id_rekon == '1') {
            //read saldo awal
            return $this->read($filename);
        } elseif ($id_rekon == '2') {
            //read sai
            return $this->read($filename);
        } else {
            return 'Gagal Mendapatkan file';
        }
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

    protected function valuesOfArray($array = array()) {
        foreach ($array as $rowValues) {
            foreach ($rowValues as $key => $rowValue) {
                $rowValues[$key] = "'".trim($rowValues[$key],' ')."'";
            }
            $values[] = "(" . implode(', ', $rowValues) . ")";
        }
        return $values;
    }

}

?>
