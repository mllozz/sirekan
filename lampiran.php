<style type="text/css">
    #grid {
        margin: 3% 8%;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 16px;
        width: 83%;
        text-align: left;
    }

    thead tr {
        border-bottom: 1px solid black;
        background: #A7C9B8;
        text-align: center;
    }

    thead tr:hover {
        background: #A7C9B8;
    }

    tr {
        height: 20px;
        text-align: left;
    }

    tr:hover {
        background-color: #ccc;
    }

    tr:nth-child(even) {
        background: #B7E9F7;
    }

    tr:nth-child(even):hover {
        background: #ccc;
    }

    td {
        padding: 0 2px;
        text-align: left;
    }

    td:hover {
        cursor: pointer;
    }

    #grid td:last-child {
        text-align: left;
        width: auto;
    }
    
    input[type=text], option {
        background-color: #fbec88;
        border-width: 1px;
    }
    
    .error {
        border: 1px solid;
        margin: 1% 8%;
        width: 45%;
        padding:15px 10px 15px 50px;
        border-radius: 3px;
        background-repeat: no-repeat;
        background-position: 10px center;
        color: #D8000C;
        background-color: #FFBABA;
        background-image: url('img/error.png');
        display: none;
    }
</style>

<table id="grid" >
    <thead>
    <th colspan="7">Cetak Lampiran Rekonsiliasi</th>
</thead>
<tbody>
<form id="frm_lampiran" method="post" action="controller/cont.lampiran.php">
    <tr>
            <th>Kode Satker</th>
            <td colspan="6" id="kdsatker"></td>
        </tr>
        <tr>
            <th>Nama Satker</th>
            <td colspan="6"  id="nmsatker"></td>
        </tr>
        <tr>
        <th>Jenis Satker</th>
        <td><input type="radio" name="dekon" id="dekon" value="KP"/>Kantor Pusat</td>
        <td><input type="radio" name="dekon" id="dekon" value="KD"/>Kantor Daerah</td>
        <td><input type="radio" name="dekon" id="dekon" value="DK"/>Dekonsentrasi</td>
        <td><input type="radio" name="dekon" id="dekon" value="TP"/>Tugas Pembantuan</td>
        <td><input type="radio" name="dekon" id="dekon" value="UB"/>Urusan Bersama</td>
    </tr>
    <tr>
        <th>Periode</th>
        <td colspan="6">
            <select id="periode" name="periode"></select>
        </td>
    </tr>
    
    <tr>
            <th>Jenis Rekonsiliasi</th>
            <td colspan="6" >
                <select id="jenis_rekon">
<!--                    <option value="1">Realisasi Belanja</option>
                    <option value="2">Realisasi Pengembalian Belanja</option>
                    <option value="3">Realisasi Pendapatan Non Pajak</option>
                    <option value="4">Realisasi Pendapatan Pajak</option>
                    <option value="5">Realisasi Penerimaan Pembiayaan</option>
                    <option value="6">Realisasi Pengeluaran Pembiayaan</option>
                    <option value="7">Realisasi Mutasi Uang Persediaan</option>-->
                </select>
            </td>
        </tr>
    <tr>
        <td colspan="7"><input type="submit" id="cetak_lampiran" value="Cetak" name="cetak_lampiran"/></td>
    </tr>
    </tbody>
</form>
</table>
<div id="loader"></div>
<div class="error" id="output"></div>

<script type="text/javascript" src="js/lampiran.js"></script>
<div id="pdf">
    
</div>
