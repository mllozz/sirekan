<?php
include_once('controller/cont.main.php');
?>
<html>
    <head>
        <title>Sistem Informasi Rekonsiliasi Keuangan Negara</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/menu.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <div id="head">
                <div id="stat">
                    <div id="tgl"></div>
                    <div id="isi_stat"><a href="#" ><img src="img/profil.png"/> 
                            <?php echo $data_log['nmsatker'] . " ( " . $data_log['kddept'] . "." . $data_log['kdunit'] . "." . $data_log['kdsatker'] . ")"; ?>
                        </a> | <?php echo $akses['nmakses']; ?> |<a href="<?php logout(); ?>" ><img src="img/logout.png"/> Logout</a></div>
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