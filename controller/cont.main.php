<?php
session_start();
if(isset($_SESSION['isLogged'])) {
    $data_log=$_SESSION['satker'];
    $akses=$_SESSION['akses'];
} else {
    header('Location: index.php');
}

function logout() {
    session_unset();
    session_destroy();
}
?>