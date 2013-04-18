<?php

class Pdf_Print {

    public function createBar() {

        require_once('../tcpdf/config/lang/eng.php');
        require_once('../tcpdf/tcpdf.php');


        $html = '<p align="center">
	<strong><u>Berita Acara Rekonsiliasi</u></strong>
</p>
<p align="center">
	No. BA- /WPB.06/KP.0140/2011
</p>
<p>
	Pada hari ini Senin tanggal satu bulan Maret tahun Dua ribu sebelas telah diselenggarakan rekonsiliasi Laporan Realisasi Anggaran antara satuan kerja /
	satuan kerja perangkat daerah Dinas Kehutanan Provinsi Jambi (029.05.100082.dk), yang selanjutnya disebut Kuasa Pengguna Anggaran (KPA), dengan Kantor
	Pelayanan Perbendaharaan Negara Jambi kode (527890), yang selanjutnya disebut Kuasa Bendahara Umum Negara.
</p>
<p>
	Kuasa Pengguna Anggaran menyampaikan Laporan Realisasi Anggaran sebagai bahan rekonsiliasi, berupa:
</p>
<p>
	1. Laporan Realisasi Anggaran Belanja periode Bulan Februari TA 2011
</p>
<p>
	2. Laporan Realisasi Anggaran Pengembalian Belanja periode Bulan Februari TA 2011
</p>
<p>
	3. Laporan Realisasi Anggaran Pendapatan periode Bulan Februari TA 2011
</p>
<p>
	4. Laporan Realisasi Anggaran Pengembalian Pendapatan periode bulan Februari TA 2011
</p>
<p>
	Pada tanggal 28 Bulan Februari 2011
</p>
<p>
	Selanjutnya Kuasa Bendahara Umum Negara menyediakan data transaksi dan Laporan Realisasi Anggaran berdasarkan SPM/STS yang disampaikan oleh Kuasa Pengguna
	Anggaran yang diproses berdasarkan Sistem Akuntansi Umum.
</p>
<p>
	Rekonsiliasi dilaksanakan oleh secara bersama-sama, yang hasilnya dituangkan kedalam <em>Berita Acara Rekonsiliasi (BAR)</em> ini dengan hasil sebagai
	berikut:
</p>
<p>
	<strong>1. </strong>
	<strong>DIPA</strong>
</p>
<p>
	Tidak terdapat perbedaan antara data SAU dengan data SAI
</p>
<p>
	<strong>2. </strong>
	<strong>LRA</strong>
</p>
<p>
	Tidak terdapat perbedaan antara data SAU dengan data SAI
</p>
<p>
	<strong>3. </strong>
	<strong>NERACA</strong>
</p>
<p>
	Tidak terdapat perbedaan antara data SAU dengan data SAI
</p>
<p>
	yang secara rinci tertuang dalam <em>Laporan Hasil Rekonsiliasi</em> yang merupakan bagian yang tidak terpisahkan dari Berita Acara Rekonsiliasi (BAR) ini.
</p>
<p>
	Kesalahan/ketidakcocokan data yang tertuang dalam Laporan Hasil Rekonsiliasi, akan dijadikan dasar perbaikan terhadap data dan laporan Kuasa Pengguna
	Anggaran dan Kuasa Bendahara Umum Negara.
</p>
<p>
	Demikian berita acara ini dibuat untuk dilaksanakan.
</p>
<table border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td valign="top" width="295">
				<p align="center">
					<a name="OLE_LINK3"></a>
					<a name="OLE_LINK2"></a>
					<a name="OLE_LINK1">A.n. </a>
					Kuasa Bendahara Umum Negara,
				</p>
				<p align="center">
					Kepala Seksi Verifikasi dan Akuntansi
				</p>
				<p align="center">
					Noegroho, S.Sos
				</p>
				<p align="center">
					NIP 197304041994021001
				</p>
			</td>
			<td valign="top" width="295">
				<p align="center">
					a.n Kuasa Pengguna Anggaran
				</p>
				<p align="center">
					Pejabat Pembuat Komitmen
				</p>
				<p align="center">
					NIP
				</p>
			</td>
		</tr>
	</tbody>
</table>
';

        $pdf = new TCPDF('P', 'mm', 'F4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Eko Sigit / 5210105007');
        $pdf->SetTitle('Berita Acara Rekonsiliasi');
        $pdf->SetSubject('Laporan Hasil rekonsiliasi');
        $pdf->SetKeywords('rekonsiliasi,report,bar, php, mysql');


        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
        $pdf->SetMargins('5', '0.1', '5');
        $pdf->SetHeaderMargin('1');
        $pdf->SetFooterMargin('1');

//set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, '2');

//set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

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
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

        $pdf->Output('BAR.pdf', 'I');
    }

}

?>
