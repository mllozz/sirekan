<?php

$UploadDirectory    = 'adk/'; 

if (!@file_exists($UploadDirectory)) {
    die("Make sure Upload directory exist!");
}
if($_POST)
{
    if(!isset($_POST['jnssat']) || empty($_POST['jnsast']))
    {
        die("Jenis Saatker Kosong");
    }

    if(!isset($_FILES['file_adk']))
    {
        die("File is empty!");
    }
    if($_FILES['file_adk']['error'])
    {
        die(upload_errors($_FILES['file_adk']['error']));
    }

    $FileName           = strtolower($_FILES['file_adk']['name']); //uploaded file name
    $FileTitle          = mysql_real_escape_string($_POST['mName']); // file title
    $ImageExt           = substr($FileName, strrpos($FileName, '.')); //file extension
    $FileType           = $_FILES['mFile']['type']; //file type
    $FileSize           = $_FILES['mFile']["size"]; //file size
    $RandNumber         = rand(0, 9999999999); //Random number to make each filename unique.
    $uploaded_date      = date("Y-m-d H:i:s");

    if(strtolower($FileType)!='text/plain' || strtolower($ImageExt1)!='012')
    {
        die('Unsupported File!');
    }

   if(move_uploaded_file($_FILES['file_adk']["tmp_name"], $UploadDirectory . $FileName ))
   {
        die('Success! File Uploaded.');

   }else{
        die('error uploading File!');
   }
}

//http://www.php.net/manual/en/features.file-upload.errors.php#90522
function upload_errors($err_code) {
    switch ($err_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}
?>
