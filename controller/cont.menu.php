<?php

if(isset($_REQUEST['admin'])){
    session_start();

    $kdakses = $_SESSION['akses'];
    echo json_encode($kdakses);
}
?>
