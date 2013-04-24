<?php

class Pdf_Print {

    public function createBar($kddept, $kdunit, $kdsatker, $kddekon, $periode) {

        require_once('../tcpdf/config/lang/eng.php');
        require_once('../tcpdf/tcpdf.php');

        $arr = array(
            'kddept' => $kddept,
            'kdunit' => $kdunit,
            'kdsatker' => $kdsatker,
        );

        $satker = new Satker($arr);

        $data_satker = $satker->getSatker();


        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];

        $per = new Periode();
        $pejabat = new Pejabat();

        $pernya = $per->getPeriodeByPer($periode);
        $bulan_ini = $per->getPeriodeByPer(date('m'));

        $kasi = $pejabat->getPejabat();
        
        $kantor = new Kppn();

        $kppn = $kantor->getKppn();

        $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
	p {
		margin-top:30px;
                margin-bottom:20px;
	}
</style>
</head>

<body>
<table width="540" border="0">
  <tr>
    <td style="text-align:center;"><img src="../img/garuda2.png" /></td>
  </tr>
  <tr>
    <td style="text-align:center; line-height:1;">MENTERI KEUANGAN</td>
  </tr>
  <tr>
    <td style="text-align:center; line-height:1;">REPUBLIK INDONESIA</td>
  </tr>
  <tr>
    <td style="text-align:center; margin-top:10px; line-height:1.7em; font-size: 40px; text-decoration: underline; font-weight:bold;">Berita Acara  Rekonsiliasi</td>
  </tr>
  <tr>
    <td style="text-align:center; text-indent: 20px;">No.  BA-       /WPB.06/KP.0140/' . $thnang . '</td>
  </tr>
</table>
<br />
<table width="540" border="0">
  <tr>
    <td><p style="text-indent:25px; text-align:justify; padding-top:-0.3em; line-height:1.5em;">Pada hari  ini '.$this->hari(date('l')).' tanggal ' . $this->Terbilang(date('d')) . ' bulan ' . $bulan_ini['nmbulan'] . ' tahun ' . $this->Terbilang(date('Y')) . ' telah diselenggarakan rekonsiliasi Laporan Realisasi  Anggaran antara satuan kerja / satuan kerja perangkat daerah ' . $data_satker['nmsatker'] . '  (' . $kddept . '.' . $kdunit . '.' . $kdsatker . '.' . $kddekon . '), yang  selanjutnya disebut Kuasa Pengguna Anggaran (KPA), dengan Kantor Pelayanan  Perbendaharaan Negara ' . $kppn->nmkppn . '  kode (' . $kppn->kdkppn . '), yang selanjutnya disebut Kuasa  Bendahara Umum Negara.</p></td>
  </tr>
</table>
<table width="540" border="0">
  <tr>
    <td><p style="text-indent:25px; text-align:justify; line-height:1.5em;">Kuasa Pengguna Anggaran menyampaikan Laporan Realisasi  Anggaran sebagai bahan rekonsiliasi, berupa:</p></td>
  </tr>
  <tr>
    <td style="text-indent:25px; ">1.&nbsp;&nbsp;Laporan Realisasi Anggaran Belanja periode  Bulan ' . $pernya['nmbulan'] . '  TA ' . $thnang . '</td>
  </tr>
  <tr>
    <td style="text-indent:25px;">2.&nbsp;&nbsp;Laporan Realisasi Anggaran Pengembalian Belanja periode  Bulan  ' . $pernya['nmbulan'] . '  TA ' . $thnang . '</td>
  </tr>
  <tr>
    <td style="text-indent:25px;">3.&nbsp;&nbsp;Laporan Realisasi Anggaran Pendapatan periode Bulan ' . $pernya['nmbulan'] . '  TA ' . $thnang . '</td>
  </tr>
  <tr>
    <td style="text-indent:25px;">4.&nbsp;&nbsp;Laporan Realisasi Anggaran Pengembalian Pendapatan periode bulan ' . $pernya['nmbulan'] . ' TA ' . $thnang . '</td>
  </tr>
</table>
<br />
<table width="540" border="0">
  <tr>
    <td><p style="text-indent:25px; text-align:justify; line-height:1.5em;">Pada tanggal ' . date('d') . ' Bulan ' . $bulan_ini['nmbulan'] . ' ' . date('Y') . '</p></td>
  </tr>
  <tr>
    <td><p style="text-indent:25px; text-align:justify; line-height:1.5em;">Selanjutnya  Kuasa Bendahara Umum Negara menyediakan data transaksi dan Laporan Realisasi  Anggaran berdasarkan SPM/STS yang disampaikan oleh Kuasa Pengguna Anggaran yang  diproses berdasarkan Sistem Akuntansi Umum. </p></td>
  </tr>
  <tr>
    <td><p style="text-indent:25px; text-align:justify; line-height:1.5em;">Rekonsiliasi  dilaksanakan oleh secara bersama-sama, yang hasilnya dituangkan kedalam <em>Berita  Acara Rekonsiliasi (BAR)</em> ini dengan hasil sebagai berikut:</p></td>
  </tr>
</table>
<br />
<table width="540" border="0">
  <tr>
    <td style="text-indent:25px; line-height:1.5em;"><strong>1.&nbsp;&nbsp;DIPA</strong></td>
  </tr>
  <tr>
    <td style="text-indent:25px; line-height:1.5em;">Tidak terdapat perbedaan antara data SAU dengan data  SAI</td>
  </tr>
  <tr>
    <td style="text-indent:25px; line-height:1.5em;"><strong>2.&nbsp;&nbsp;LRA</strong></td>
  </tr>
  <tr>
    <td style="text-indent:25px; line-height:1.5em;">Tidak terdapat perbedaan antara data SAU dengan data  SAI </td>
  </tr>
  <tr>
    <td style="text-indent:25px; line-height:1.5em;"><strong>3.&nbsp;&nbsp;NERACA</strong></td>
  </tr>
  <tr>
    <td style="text-indent:25px; line-height:1.5em;">Tidak terdapat perbedaan antara data SAU dengan data  SAI </td>
  </tr>

</table>
<br />
<table width="540" border="0">
  <tr>
    <td><p style="text-align:justify; line-height:1.5em;">yang secara rinci tertuang dalam <em>Laporan Hasil  Rekonsiliasi</em> yang merupakan bagian   yang tidak terpisahkan dari Berita Acara Rekonsiliasi (BAR) ini.</p></td>
  </tr>
  <tr>
    <td><p style="text-indent:25px; text-align:justify; line-height:1.5em;">Kesalahan/ketidakcocokan data yang tertuang dalam Laporan  Hasil Rekonsiliasi, akan dijadikan dasar perbaikan terhadap data dan laporan  Kuasa Pengguna Anggaran dan Kuasa Bendahara Umum Negara.</p></td>
  </tr>
  <tr>
    <td><p style="text-indent:25px; text-align:justify; line-height:1.5em;">Demikian berita acara ini dibuat untuk dilaksanakan.</p></td>
  </tr>
</table>
<br />
<table width="600" border="0">
  <tr>
    <td style="text-align:center; line-height:1em; text-indent: 2px;">A.n. Kuasa Bendahara Umum Negara</td>
    <td style="text-align:center; line-height:1em;">a.n. Kuasa Pengguna Anggaran</td>
  </tr>
  <tr>
    <td style="text-align:center; line-height:1em; text-indent: 25px;"><p>Kepala Seksi Verifikasi dan Akuntansi</p></td>
    <td style="text-align:center; line-height:1em;">Pejabat Pembuat Komitmen</td>
  </tr>
  <tr>
    <td style="line-height:3.2em;">&nbsp;</td>
    <td style="line-height:3.2em;">&nbsp;</td>
  </tr>
  <tr>
    <td style="line-height:1em; text-indent: 65px;">' . $kasi['nama'] . '</td>
    <td style="line-height:1em; text-indent: 85px;">.......</td>
  </tr>
  <tr>
    <td style="line-height:1em; text-indent: 65px;">' . $kasi['nip2'] . '</td>
    <td style="line-height:1em; text-indent: 85px;">NIP.</td>
  </tr>
</table>
<p>&nbsp;</p>

</body>
</html>
';

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
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

//*************
        ob_end_clean();
//************* 
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'left', $autopadding = false);

        $pdf->Output('../pdf/' . $kddept . '' . $kdunit . '' . $kdsatker . 'BAR.pdf', 'F');
        echo json_encode('pdf/' . $kddept . '' . $kdunit . '' . $kdsatker . 'BAR.pdf');
    }

    public function createLamp($jns_lamp, $kddept, $kdunit, $kdsatker, $kddekon, $periode) {

        require_once('../tcpdf/config/lang/eng.php');
        require_once('../tcpdf/tcpdf.php');

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
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

//*************
        ob_end_clean();
//************* 


        $setup = new Setup();
        $set = $setup->getSetup();

        $thnang = $set['thnang'];
        $tgl_awal = $thnang . '-' . $periode . '-01';
        $tgl_akhir = $thnang . '-' . $periode . '-31';

        $per = new Periode();

        $pernya = $per->getPeriodeByPer($periode);

        $kantor = new Kppn();

        $kppn = $kantor->getKppn();

        $data = '';
        $judul = '';
        $rek = new Rekon();

        switch ($jns_lamp) {
            case '1':
                $data = $rek->rekonRealBelanja($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'ANGGARAN BELANJA';
                break;
            case '2':
                $data = $rek->rekonPengembalianBelanja($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'PENGEMBALIAN BELANJA';
                break;
            case '3':
                $data = $rek->rekonPendapatanBPjk($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'PENDAPATAN BUKAN PAJAK';
                break;
            case '4':
                $data = $rek->rekonPendapatanPajak($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'PENDAPATAN PAJAK';
                break;
            case '5':
                $data = $rek->rekonPenerimaanPembiayaan($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'PENERIMAAN PEMBIAYAAN';
                break;
            case '6':
                $data = $rek->rekonPengeluaranPembiayaan($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'PENGELUARAN PEMBIAYAAN';
                break;
            case '7':
                $data = $rek->rekonUP($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'MUTASI UANG PERSEDIAAN';
                break;
            case '8':
                $data = $rek->rekonSaldo($kddept, $kdunit, $kdsatker, $tgl_awal, $tgl_akhir, $kddekon);
                $judul = 'PAGU BELANJA';
                break;
            default:
                break;
        }

        $length = 28;
        $num_pages = ceil(count($data) / $length);
        $offset = 0;
        $i = 0;
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lampiran</title>
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
<body>';
        while ($i < $num_pages) {
            if ($data != false) {
                $output = array_slice($data, $offset, $length);
            } else {
                $output = false;
            }
            $html.='<table id="header">
  <tr>
    <td id="headc" style="font-size:24px;">KEMENTERIAN KEUANGAN RI</td>
  </tr>
  <tr>
    <td id="headc" style="font-size:24px;">DIREKTORAT JENDERAL PERBENDAHARAAN</td>
  </tr>
  <tr>
   <td style="text-align: center;">REKONSILIASI ' . $judul . ' ANTARA DATA SAU DAN SAI TINGKAT KPPN</td>
  </tr>
  <tr>
    <td  style="text-align: center;">MENURUT BA, ESELON I, SATKER, AKUN - DETAIL SEMUA DATA</td>
  </tr>
  <tr>
    <td  style="text-align: center;">PERIODE ' . strtoupper($pernya['nmbulan']) . ' ' . $thnang . '</td>
  </tr>
  </table>
<table id="param">
  <tr>
    <td>KPPN : </td>
    <td>' . $kppn->kdkppn . ' </td>
    <td>' . $kppn->nmkppn . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tanggal : </td>
    <td>' . date('d-M-y') . '</td>
  </tr>
  <tr>
    <td>Parameter :</td>
    <td>Kode BA ' . $kddept . '</td>
    <td>Kode Es1 ' . $kdunit . '</td>
    <td>Kode Satker </td>
    <td>' . $kdsatker . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Halaman :</td>
    <td>' . ($i + 1) . '</td>
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

            $jmlsai = 0;
            $jmlsau = 0;
            if ($output == false) {
                $html.='<tr>
            <td style="width: 900px;  text-align:center;">--</td>
            </tr>';
            } else {
                foreach ($output as $rows) {
                    $html.='<tr>
                <td style="width: 70px;  text-align:center;">' . $rows['KDBAES1'] . '</td>
                <td style="width: 70px; text-align:center;">' . $rows['KDSATKER'] . '</td>
                <td style="width: 70px; text-align:center;">' . $rows['KDPERK'] . '</td>
                <td style="width: 70px; text-align:center;">' . $rows['JNSDOK1'] . '</td>
                <td style="width: 70px; text-align:center;">' . $rows['TGLDOK1'] . '</td>
                <td id="panjang" style="width: 160px; text-align:center;">' . $rows['NODOK1'] . '</td>
                <td id="rp" style="width: 160px; text-align:right;">' . $this->formatMoney($rows['RPSAU'], true) . '</td>
                <td id="rp" style="width: 160px;  text-align:right;">' . $this->formatMoney($rows['RPSAI'], true) . '</td>
                <td style="width: 70px; text-align:center;">' . $rows['HASIL'] . '</td>
                </tr>';
                    $jmlsai+=(int) $rows['RPSAI'];
                    $jmlsau+=(int) $rows['RPSAI'];
                }
            }


            $offset = $offset + $length;
            $i++;
            if ($i < $num_pages) {
                $html.=$html;
            }
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
    <td id="panjang" style="width: 160px;  text-align:right; color: blue; font-weight:bold;">' . $this->formatMoney($jmlsau, true) . '</td>
    <td id="panjang" style="width: 160px;  text-align:right; color: blue; font-weight:bold;">' . $this->formatMoney($jmlsai, true) . '</td>
    <td style="width: 70px;  text-align:center;">&nbsp;</td>
  </tr>
</table>
</body>
</html>
';
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'left', $autopadding = false);
        $pdf->Output('../pdf/' . $kddept . '' . $kdunit . '' . $kdsatker . 'lampiran.pdf', 'F');
        echo json_encode('pdf/' . $kddept . '' . $kdunit . '' . $kdsatker . 'lampiran.pdf');
    }

    function formatMoney($number, $fractional = false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

    function Terbilang($x) {
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh",
            "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12)
            return " " . $abil[$x];
        elseif ($x < 20)
            return $this->Terbilang($x - 10) . " belas ";
        elseif ($x < 100)
            return $this->Terbilang($x / 10) . " puluh " . $this->Terbilang($x % 10);
        elseif ($x < 200)
            return " seratus" . Terbilang($x - 100);
        elseif ($x < 1000)
            return $this->Terbilang($x / 100) . " ratus " . $this->Terbilang($x % 100);
        elseif ($x < 2000)
            return " seribu" . Terbilang($x - 1000);
        elseif ($x < 1000000)
            return $this->Terbilang($x / 1000) . " ribu " . $this->Terbilang($x % 1000);
        elseif ($x < 1000000000)
            return $this->Terbilang($x / 1000000) . " juta " . $this->Terbilang($x % 1000000);
    }

    function hari($namahari) {
        if ($namahari == "Sunday")
            $namahari = "Minggu";
        else if ($namahari == "Monday")
            $namahari = "Senin";
        else if ($namahari == "Tuesday")
            $namahari = "Selasa";
        else if ($namahari == "Wednesday")
            $namahari = "Rabu";
        else if ($namahari == "Thursday")
            $namahari = "Kamis";
        else if ($namahari == "Friday")
            $namahari = "Jumat";
        else if ($namahari == "Saturday")
            $namahari = "Sabtu";

        return $namahari;
    }

}

?>
