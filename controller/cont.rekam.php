<?php
if(isset($_GET['cek']) && isset($_GET['kddept'])) {
    $kddept=$_GET['kddept'];
    $data = array(
        'msg' => 'no',
        'nmdept' => 'asasasdasd'
    );

    echo json_encode($data);
}

?>
