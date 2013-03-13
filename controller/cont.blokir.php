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
            'status_blokir' => $rows['blokir'],
        );
        $i++;
    }
    echo json_encode($data);
}
if (isset($_REQUEST['aksi'])) {
    switch (@$_REQUEST['aksi']) {
        case 'cari' :
            if (isset($_REQUEST['filter'])) {
                $users = User::getAllUser();
            } else {
                $users = User::cariUser($_REQUEST['kata']);
            }

            $data[] = array();
            $hasil[]=array();
            $i = 0;
            foreach ($users as $rows) {
                $arr[$i] = array(
                    'kddept' => $rows['kddept'],
                    'kdunit' => $rows['kdunit'],
                    'kdsatker' => $rows['kdsatker'],
                );
                $satker[$i] = new Satker($arr[$i]);
                $res[$i] = $satker[$i]->getSatker();

                $hasil[$i] = array(
                    'id_user' => $rows['id_user'],
                    'kddept' => $rows['kddept'],
                    'kdunit' => $rows['kdunit'],
                    'kdsatker' => $rows['kdsatker'],
                    'username' => $rows['username'],
                    'nmakses' => $rows['nmakses'],
                    'nmsatker' => $res[$i]['nmsatker'],
                    'status_blokir' => $rows['blokir'],
                );
                $i++;
            }
            if (isset($_REQUEST['filter'])) {
                $input = $_REQUEST['kata'];
                $k = 0;
                $result=false;
                foreach ($hasil as $item) {
                    //$result = array_filter($item, function ($x) use ($input) {      
                    for ($j = 0; $j < strlen($item['nmsatker']); $j++) {
                        if (stripos(strtolower($input), strtolower(substr($item['nmsatker'], $j, strlen($input)))) !== false) {
                            $result=true;
                        } else {
                        $result=false;
                        }
                    }
                    //  });
                    
                    if ($result) {
                        $data = $hasil[$k];
                    }
                    $k++;
                }
            } else {
                $data = $hasil;
            }
            echo json_encode($data);
            exit;
        case 'ubah' :
            $id_user=$_REQUEST['id_user'];
            $user=User::getUser($id_user);
//            $data=array(
//                'msg' => 'ok',
//                'info' => 'yooooo',
//            );
            echo json_encode($user);
            exit;
    }
}
?>