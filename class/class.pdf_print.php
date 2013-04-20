<?php

class Pdf_Print {

    public function createBar() {

        require_once('../tcpdf/config/lang/eng.php');
        require_once('../tcpdf/tcpdf.php');


        $html = '<html>
<head>
<title>BAR</title>
<style type="text/css">
body {
	line-height:120%;
	}
ol {
	margin: 0;
	padding: 0;
}
.c18 {
	vertical-align: top;
	width: 221.4pt;
	border-style: solid;
	border-color: #000000;
	border-width: 0pt;
	padding: 0pt 5.4pt 0pt 5.4pt
}
#atas {
	width: 35%;
	margin-left: 32%;
	margin-bottom: -12px;
}
.c7 {
	margin-right: -2.8pt;
	height: 12pt;
	text-align: right;
	direction: ltr
}
.c26 {
	max-width: 486.2pt;
	background-color: #ffffff;
	padding: 27.2pt 53.8pt 31.2pt 72pt
}
.c5 {
	height: 12pt;
	text-align: center;
	direction: ltr
}
.c24 {
	font-size: 13pt;
	font-family: "Bookman Old Style";
	text-decoration: underline
}
.c9 {
	list-style-type: decimal;
	margin: 0;
	padding: 0;
	line-height:120%;
}
.c10 {
	height: 12pt;
	direction: ltr
}
.c2 {
	font-size: 11pt;
	font-family: "Arial Narrow";
	line-height:120%;
}
.c3 {
	text-align: justify;
	margin-left: 56pt;
}
.c0 {
	line-height: 1;
	direction: ltr
}
.c1 {
	text-align: justify;
	padding-bottom: 0;
}
.c21 {
	padding-left: 0pt;
	margin-left: 55.4pt
}
.c8 {
	padding-left: 0.7pt;
	margin-left: 55.4pt
}
.c19 {
	padding-top: 10pt
}
.c27 {
	padding-top: 10pt
}
.c4 {
	text-indent: 36pt
}
.c25 {
	text-align: right
}
.c22 {
	border-collapse: collapse;
}
.c22a {
	border-collapse: collapse;
	margin-left:25%;
	line-height: 120%;
}
.c28 {
	font-size: 8pt
}
.c11 {
	font-weight: bold
}
.c16 {
	direction: ltr
}
.c23 {
	margin-right: 18pt
}
.c17 {
	color: #ff0000
}
.c20 {
	margin-right: -2.8pt
}
.c14 {
	line-height: 1.2;
}
.c12 {
	text-align: center
}
.c13 {
	height: 0pt
}
.c15 {
	font-style: italic
}
.c6 {
	text-align: justify
}
.title {
	padding-top: 10pt;
	line-height: 1;
	text-align: left;
	color: #000000;
	font-size: 36pt;
	font-family: "Times New Roman";
	font-weight: bold;
	padding-bottom: 6pt
}
.subtitle {
	padding-top: 10pt;
	line-height: 1;
	text-align: left;
	color: #666666;
	font-style: italic;
	font-size: 24pt;
	font-family: "Georgia";
	padding-bottom: 4pt
}
li {
	color: #000000;
	font-size: 12pt;
	font-family: "Times New Roman"
}
p {
	color: #000000;
	font-size: 12pt;
	margin: 0;
	font-family: "Times New Roman"
}
h1 {
	padding-top: 24pt;
	line-height: 1;
	text-align: left;
	color: #000000;
	font-size: 24pt;
	font-family: "Times New Roman";
	font-weight: bold;
	padding-bottom: 6pt
}
h2 {
	padding-top: 18pt;
	line-height: 1;
	text-align: left;
	color: #000000;
	font-size: 18pt;
	font-family: "Times New Roman";
	font-weight: bold;
	padding-bottom: 4pt
}
h3 {
	padding-top: 14pt;
	line-height: 1;
	text-align: left;
	color: #000000;
	font-size: 14pt;
	font-family: "Times New Roman";
	font-weight: bold;
	padding-bottom: 4pt
}
h4 {
	padding-top: 12pt;
	line-height: 1;
	text-align: left;
	color: #000000;
	font-size: 12pt;
	font-family: "Times New Roman";
	font-weight: bold;
	padding-bottom: 2pt
}
h5 {
	padding-top: 11pt;
	line-height: 1;
	text-align: left;
	color: #000000;
	font-size: 11pt;
	font-family: "Times New Roman";
	font-weight: bold;
	padding-bottom: 2pt
}
h6 {
	padding-top: 10pt;
	line-height: 1;
	text-align: left;
	color: #000000;
	font-size: 10pt;
	font-family: "Times New Roman";
	font-weight: bold;
	padding-bottom: 2pt
}
</style>
</head>
<body class="c26">
<div id="atas">
<p class="c0 c12 c19"><span class="c11 c24">Berita Acara Rekonsiliasi</span></p>
<p class="c16 c12"><span>No. BA- &nbsp; &nbsp; &nbsp; /WPB.06/KP.0140/2011</span></p>
</div>
<p class="c0 c1 c4 c27"><span class="c2">Pada hari ini Senin tanggal satu bulan Maret tahun Dua ribu sebelas</span><span class="c2 c17">&nbsp;</span><span class="c2">telah diselenggarakan rekonsiliasi Laporan Realisasi Anggaran antara satuan kerja / satuan kerja perangkat daerah Dinas Kehutanan Provinsi Jambi (029.05.100082.dk), yang selanjutnya disebut Kuasa Pengguna Anggaran (KPA), dengan Kantor Pelayanan Perbendaharaan Negara Jambi &nbsp;kode (527890), yang selanjutnya disebut Kuasa Bendahara Umum Negara.</span></p>
<p class="c0 c4 c6"><span class="c2">Kuasa Pengguna Anggaran menyampaikan Laporan Realisasi Anggaran sebagai bahan rekonsiliasi, berupa:</span></p>
<ol class="c9" start="1">
  <li class="c0 c8 c6"><span class="c2">Laporan Realisasi Anggaran Belanja periode &nbsp;Bulan Februari &nbsp;TA 2011</span></li>
  <li class="c0 c8 c6"><span class="c2">Laporan Realisasi Anggaran Pengembalian Belanja periode &nbsp;Bulan &nbsp;Februari </span><span class="c2 c17">&nbsp;</span><span class="c2">TA 2011</span></li>
  <li class="c0 c8 c6"><span class="c2">Laporan Realisasi Anggaran Pendapatan periode Bulan Februari </span><span class="c2 c17">&nbsp;</span><span class="c2">TA 2011</span></li>
  <li class="c0 c1 c8"><span class="c2">Laporan Realisasi Anggaran Pengembalian Pendapatan periode bulan Februari</span><span class="c2 c17">&nbsp;</span><span class="c2">TA 2011</span></li>
</ol>
<p class="c0 c1"><span class="c2">Pada tanggal 28 Bulan Februari 2011</span></p>
<p class="c0 c1 c4"><span class="c2">Selanjutnya Kuasa Bendahara Umum Negara menyediakan data transaksi dan Laporan Realisasi Anggaran berdasarkan SPM/STS yang disampaikan oleh Kuasa Pengguna Anggaran yang diproses berdasarkan Sistem Akuntansi Umum.</span></p>
<p class="c0 c1 c4"><span class="c2">Rekonsiliasi dilaksanakan oleh secara bersama-sama, yang hasilnya dituangkan kedalam </span><span class="c2 c15">Berita Acara Rekonsiliasi (BAR)</span><span class="c2">&nbsp;ini dengan hasil sebagai berikut:</span></p>
<ol class="c9" start="1">
  <li class="c0 c6 c8"><span class="c2 c11">DIPA</span></li>
</ol>
<p class="c0 c3"><span class="c2">Tidak terdapat perbedaan antara data SAU dengan data SAI </span></p>
<ol class="c9" start="2">
  <li class="c0 c6 c21"><span class="c2 c11">LRA</span></li>
</ol>
<p class="c3 c0"><span class="c2">Tidak terdapat perbedaan antara data SAU dengan data SAI </span></p>
<ol class="c9" start="3">
  <li class="c0 c21 c6"><span class="c2 c11">NERACA</span></li>
</ol>
<p class="c3 c0"><span class="c2">Tidak terdapat perbedaan antara data SAU dengan data SAI </span></p>
<p class="c0 c1"><span class="c2">yang secara rinci tertuang dalam </span><span class="c2 c15">Laporan Hasil Rekonsiliasi</span><span class="c2">&nbsp;yang merupakan bagian &nbsp;yang tidak terpisahkan dari Berita Acara Rekonsiliasi (BAR) ini.</span></p>
<p class="c0 c4 c6"><span class="c2">Kesalahan/ketidakcocokan data yang tertuang dalam Laporan Hasil Rekonsiliasi, akan dijadikan dasar perbaikan terhadap data dan laporan Kuasa Pengguna Anggaran dan Kuasa Bendahara Umum Negara.</span></p>
<p class="c0 c4 c6"><span class="c2">Demikian berita acara ini dibuat untuk dilaksanakan.</span></p>
<table cellpadding="0" cellspacing="0" class="c22a">
  <tbody>
    <tr class="c13">
      <td class="c18"><p class="c0 c12"><span class="c2">A.n. Kuasa Bendahara Umum Negara,
          </span></p>
        <p class="c0 c12"><span class="c2">Kepala Seksi Verifikasi dan Akuntansi
          </span></p>
        <p class="c10 c14"><span class="c2"><br>
          </span></p>
        <p class="c0 c12"><span class="c2">Noegroho, S.Sos</span></p>
        <p class="c0 c12"><span class="c2">NIP &nbsp;197304041994021001</span></p></td>
      <td class="c18"><p class="c0 c12"><span class="c2">&nbsp;a.n Kuasa Pengguna Anggaran
          </span></p>
        <p class="c0 c12"><span class="c2">Pejabat Pembuat Komitmen
          </span></p>
        <p class="c10 c14"><span class="c2"><br>
          </span></p>
        <p class="c0 c12"><span class="c2">Nama KPA</span></p>
        <p class="c0 c12"><span class="c2">NIP </span></p></td>
    </tr>
  </tbody>
</table>
</body>
</html>';

        $pdf = new TCPDF('P', 'mm', 'F4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Eko Sigit / 5210105007');
        $pdf->SetTitle('Berita Acara Rekonsiliasi');
        $pdf->SetSubject('Laporan Hasil rekonsiliasi');
        $pdf->SetKeywords('rekonsiliasi,report,bar, php, mysql');


        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
        $pdf->SetMargins('4', '1', '2');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
        $pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set default font subsetting mode
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);

// Add a page 
// This method has several options, check the source code documentation for more information.
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->AddPage();

//*************
        ob_end_clean();
//************* 
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, 
                $align = 'left', $autopadding = false);

        $pdf->Output('../pdf/BAR.pdf', 'F');
        echo json_encode('pdf/BAR.pdf');
    }
    
    public function createLamp($jns_lamp,$kddept, $kdunit, $kdsatker, $kddekon, $periode){
        
        require_once('../tcpdf/config/lang/eng.php');
        require_once('../tcpdf/tcpdf.php');
       
        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $tgl_awal = $thnang . '-' . $periode . '-01';
        $tgl_akhir = $thnang . '-' . $periode . '-31';
        
        $per=new Periode();
        
        $pernya=$per->getPeriodeByPer($periode);
        
        $rek=new Rekon();
        
        $data=$rek->rekonRealBelanja($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
        
        
        $html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
	table {
		width: 900;
	}
	
	#header {
		border-collapse:collapse;
	}
	#header td {
		width:900px;
		text-align:center;
		text-wrap:normal;
		font-size:14px;
	}

	td#headc{
		text-align:left;
		font-size:14px;
	}
	#param {
		font-size:10px;
	}
	
	#param td {
		width:80px;	
	}
	
	#isi td {
		border: 1px solid black;
		width:70px;
		text-align:center;	
	}
	
	#data td {
		width:70px;
		text-align:center;	
	}
	#footer td {
		width:70px;
		text-align:right;
		color: blue;
		font-weight: bold;	
	}
	td#panjang,td#rp {
		width: 160px;
	}
	td#rp {
		text-align:right;
	}
	
</style>
</head>
<body>
<table id="header">
  <tr>
    <td id="headc" style="font-size:14px;">KEMENTERIAN KEUANGAN RI</td>
  </tr>
  <tr>
    <td id="headc" style="font-size:14px;">DIREKTORAT JENDERAL PERBENDAHARAAN</td>
  </tr>
  <tr>
   <td style="text-align: center;">REKONSILIASI ANGGARAN BELANJA ANTARA DATA SAU DAN SAI TINGKAT KPPN</td>
  </tr>
  <tr>
    <td  style="text-align: center;">MENURUT BA, ESELON I, SATKER, AKUN - DETAIL SEMUA DATA</td>
  </tr>
  <tr>
    <td  style="text-align: center;">PERIODE '.  strtoupper($pernya['nmbulan']) .' '.$thnang.'</td>
  </tr>
  </table>
<table id="param">
  <tr>
    <td>KPPN : </td>
    <td>156 </td>
    <td>K O L A K A</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tanggal : </td>
    <td>20-04-13</td>
  </tr>
  <tr>
    <td>Parameter :</td>
    <td>Kode BA '.$kddept.'</td>
    <td>Kode Es1 '.$kdunit.'</td>
    <td>Kode Satker </td>
    <td>'.$kdsatker.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Halaman :</td>
    <td>&nbsp;</td>
  </tr>
</table>
<span><br></span>
<table id="isi" style="border: 1px solid black;">
  <tr >
    <td style="border: 1px solid black; width: 70px;text-align:center;">KODE BAES1</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">KD SATKER</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">KD AKUN</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">JNS DOK</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">TGL DOK</td>
    <td id="panjang" style="border: 1px solid black; width: 160px; text-align:center;">NO DOK</td>
    <td id="panjang" style="border: 1px solid black; width: 160px; text-align:center;">RUPIAH GL SAU</td>
    <td id="panjang"style="border: 1px solid black; width: 160px; text-align:center;">RUPIAH GL SAI</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">STATUS</td>
  </tr>
  <tr>
    <td style="border: 1px solid black; width: 70px; text-align:center;">1</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">2</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">3</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">4</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">5</td>
    <td style="border: 1px solid black; width: 160px; text-align:center;">6</td>
    <td style="border: 1px solid black; width: 160px; text-align:center;">7</td>
    <td style="border: 1px solid black; width: 160px; text-align:center;">8</td>
    <td style="border: 1px solid black; width: 70px; text-align:center;">9</td>
  </tr>
</table>
<table id="data">
';
        $jmlsai=0;
        $jmlsau=0;
        foreach($data as $rows){
            $html.='<tr>
            <td style="width: 70px;  text-align:center;">'.$rows['KDBAES1'].'</td>
            <td style="width: 70px; text-align:center;">'.$rows['KDSATKER'].'</td>
            <td style="width: 70px; text-align:center;">'.$rows['KDPERK'].'</td>
            <td style="width: 70px; text-align:center;">'.$rows['JNSDOK1'].'</td>
            <td style="width: 70px; text-align:center;">'.$rows['TGLDOK1'].'</td>
            <td id="panjang" style="width: 160px; text-align:center;">'.$rows['NODOK1'].'</td>
            <td id="rp" style="width: 160px; text-align:right;">'.$rows['RPSAU'].'</td>
            <td id="rp" style="width: 160px;  text-align:right;">'.$rows['RPSAI'].'</td>
            <td style="width: 70px; text-align:center;">'.$rows['HASIL'].'</td>
            </tr>';
            $jmlsai+=(int) $rows['RPSAI'];
            $jmlsau+=(int) $rows['RPSAI'];
            }
$html.='</table>
<table id="footer">
  <tr>
    <td style="width: 70px;  text-align:center;">&nbsp;</td>
    <td style="width: 70px;  text-align:center;">&nbsp;</td>
    <td style="width: 70px;  text-align:center;">&nbsp;</td>
    <td style="width: 70px;  text-align:center;">&nbsp;</td>
    <td style="width: 70px;  text-align:center;">&nbsp;</td>
    <td id="panjang" style="width: 160px;  text-align:right; color: blue; font-weight:bold;">JUMLAH</td>
    <td id="panjang" style="width: 160px;  text-align:right; color: blue; font-weight:bold;">'.$jmlsau.'</td>
    <td id="panjang" style="width: 160px;  text-align:right; color: blue; font-weight:bold;">'.$jmlsai.'</td>
    <td style="width: 70px;  text-align:center;">&nbsp;</td>
  </tr>
</table>
</body>
</html>
';
        
        $pdf = new TCPDF('L', 'mm', 'F4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Eko Sigit / 5210105007');
        $pdf->SetTitle('Berita Acara Rekonsiliasi');
        $pdf->SetSubject('Laporan Hasil rekonsiliasi');
        $pdf->SetKeywords('rekonsiliasi,report,bar, php, mysql');


        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
        $pdf->SetMargins('4', '1', '2');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
        $pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set default font subsetting mode
        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);

// Add a page 
// This method has several options, check the source code documentation for more information.
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->AddPage();

//*************
        ob_end_clean();
//************* 
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, 
                $align = 'left', $autopadding = false);

        $pdf->Output('../rbel.pdf', 'F');
        echo json_encode('rbel.pdf');
    }

}

?>
