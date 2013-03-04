<?php
	include_once('controller/cont.index.php');
?>
<html>
<head>
    <title>SI-REKAN</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/js_login.js"></script>
</head>
<body>
<div id="wrap">
    <div id="main">
        <div id="header">
            <div id="logo">
                <img src="img/depkeu_Logo.png" class="img-rounded" />
            </div>
            <div id="text_logo">
                <h3>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</h3> 
                <h2>DIREKTORAT JENDERAL PERBENDAHARAAN NEGARA</h2>
                <h1>KANTOR PELAYANAN PERBENDAHARAAN NEGARA <?php echo $kppn->nmkppn;?></h1>
                
            </div>
        </div><!-- end header -->
        <div id="container2">
            <div id="container1">
                <div id="col1">
                    <div class="pad">
                        <img src="img/login.png" class="img-rounded" />
                    </div>
                </div> <!-- end col1 -->
                <div id="col2">
                    <div style="border:1px solid #D3D3D3"> 
                        <div id="form_login">
                            <div id="pre_sirekan"><h2>Sistem Informasi Rekonsiliasi Keuangan Negara</h2></div>
                            &nbsp;
                            <div id="col3">
                                <form method="post" id="frm_login" action="">
                                    <table border="0" align="center">
                                        <tr>
                                            <td><label for="user">Username</label></td>
                                            <td><input type="text" id="user" name="user" title="Masukan username" /></td>
                                        </tr>
                                        <tr>    
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><label for="pass">Password</label></td>
                                            <td><input type="password" id="pass" name="pass" title="Masukan password" /></td>
                                        </tr>
                                    </table>
        							<center style="color:#ff0000"><div id="error"></div></center>
                                    <br/>
                                    <table border="0" align="center">
                                        <tr>
                                            <td align="center"><input class="btn" type="submit" value="Login" id="btn_login" name="btn_login" /></td>
                                            <td align="center"><input class="btn" type="reset" value="Reset" id="btn_reset"/></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col2 -->
            </div> <!-- end container1 -->
        </div> <!-- end container2 -->
    </div> <!-- end main -->
    <div id="footer">
        Copyright 2013 by Eko Sigit Purnomo
    </div>
</div> <!-- end wrapper -->
</body>
</html>