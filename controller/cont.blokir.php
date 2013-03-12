<?php

function __autoload($class_name) {
    include '../class/class.' . strtolower($class_name) . '.php';
}

if (!isset($_REQUEST['aksi'])) {
    $users = User::getAllUser();
    $data[] = array();
    $i = 0;
    foreach ($users as $rows) {
        $arr[$i] = array(
            'kddept' => $rows['kddept'],
            'kdunit' => $rows['kdunit'],
            'kdsatker' => $rows['kdsatker'],
        );
        $satker[$i] = new Satker($arr[$i]);
        $res[$i] = $satker[$i]->getSatker();

        $data[$i] = array(
            'id_user' => $rows['id_user'],
            'kddept' => $rows['kddept'],
            'kdunit' => $rows['kdunit'],
            'kdsatker' => $rows['kdsatker'],
            'username' => $rows['username'],
            'nmakses' => $rows['nmakses'],
            'nmsatker' => $res[$i]['nmsatker'],
        );
        $i++;
    }
    echo json_encode($data);
}
if (isset($_REQUEST['aksi'])) {
    switch (@$_REQUEST['aksi']) {
        case 'cari' :
            $users = User::cariUser($_REQUEST['kata']);
            $data[] = array();
            $i = 0;
            foreach ($users as $rows) {
                $arr[$i] = array(
                    'kddept' => $rows['kddept'],
                    'kdunit' => $rows['kdunit'],
                    'kdsatker' => $rows['kdsatker'],
                );
                $satker[$i] = new Satker($arr[$i]);
                $res[$i] = $satker[$i]->getSatker();

                $data[$i] = array(
                    'id_user' => $rows['id_user'],
                    'kddept' => $rows['kddept'],
                    'kdunit' => $rows['kdunit'],
                    'kdsatker' => $rows['kdsatker'],
                    'username' => $rows['username'],
                    'nmakses' => $rows['nmakses'],
                    'nmsatker' => $res[$i]['nmsatker'],
                );
                $i++;
            }
            echo json_encode($data);
            exit;
    }
}
?>