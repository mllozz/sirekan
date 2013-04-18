<?php
include_once('controller/cont.main.php');
?>
<html>
    <head>
        <title>Sistem Informasi Rekonsiliasi Keuangan Negara</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
        <link rel="stylesheet" href="css/themes/start/jquery-ui.css" />
	<link rel="stylesheet" href="css/dt/demo_page.css" />
	<link rel="stylesheet" href="css/dt/demo_table.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/pdfobject.js"></script>
        <script type="text/javascript" src="js/menu.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="head">
                <div id="stat">
                    <div id="tgl"></div>
                    <div id="isi_stat"><a href="#" ><img src="img/profil.png"/> 
                            <?php echo $data_satker['nmsatker'] . " ( " . $data_satker['kddept'] . "." . $data_satker['kdunit'] . "." . $data_satker['kdsatker'] . ")"; ?>
                        </a> | <?php echo $akses['nmakses']; ?> |<a id='logout' href="logout" ><img src="img/logout.png"/> Logout</a></div>
                </div>
                <div id="header">
                    <div id="logo"><a href="#" ><img src="img/logo-small.png"/></a></div>
                    <div id="menu">
                        <ul id="menu_parent">
                            <li class="pressed topfirst topmenu"><a href="monitoring" ><img src="img/home.png"/> Home</a></li>
                            <li class="topmenu"><a  id="link_menu" href="" ><span><img src="img/rekon.png"/> Rekon SAI</span></a>
                                <ul>
                                    <li class="topfirst topmenu"><a href="sakpa" ><img src="img/doc.png"/> Rekon SAKPA</a></li>
                                    <li class="toplast topmenu"><a href="saldo" ><img src="img/doc.png"/> Rekon Saldo Awal</a></li>
                                    <li class="topfirst topmenu"><a>    -------------------------------</a></li>
                                    <li class="topfirst topmenu"><a href="ceksakpa" ><img src="img/doc.png"/> Cek Hasil Rekon</a></li>
<!--                                    <li class="topfirst topmenu"><a href="ceksaldo" ><img src="img/doc.png"/> Cek Rekon Saldo</a></li>-->
                                </ul>
                            </li>
                            <li class="topmenu"><a href="" ><span><img src="img/laporan.png"/> Laporan</span></a>
                                <ul>
                                    <li class="topfirst topmenu"><a href="bar" ><img src="img/doc.png"/> BAR</a></li>
                                    <li class="toplast topmenu"><a href="lampiran" ><img src="img/doc.png"/> Lampiran BAR</a></li>
                                </ul>
                            </li>
                            <li class="topmenu"><a href="" ><span><img src="img/tools.png"/> Pengaturan</span></a>
                                <ul>
                                    <li class="topfirst toplast topmenu"><a href="rekam" ><img src="img/doc.png"/> Rekam User</a></li>
                                    <li class="topfirst toplast topmenu"><a href="reset" ><img src="img/doc.png"/> Reset Password</a></li>
                                    <li class="topfirst toplast topmenu"><a href="ubah" ><img src="img/doc.png"/> Ubah Password</a></li>
                                    <li class="toplast toplast topmenu"><a href="blokir" ><img src="img/doc.png"/> Blokir User</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="content">
                <div id="clear"></div>   
                <div id="isinya">
                           
                </div>
            </div>
            <div id="footer">
                <div id="copyright">Copyright 2013 by Eko Sigit Purnomo</div>
            </div>
        </div>
    </body>
</html>