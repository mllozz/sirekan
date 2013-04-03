<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 92%;
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
    div.ui-datepicker, .ui-datepicker input{
        font-size:62.5%;
    }

    input[type=text], option {
        background-color: #fbec88;
        border-width: 1px;
    }

    #mask {
        display: none;
        background: #000; 
        position: fixed; left: 0; top: 0; 
        z-index: 10;
        width: 100%; height: 100%;
        opacity: 0.8;
        z-index: 999;
    }

    #loader {
        display:none;
        width: 20%;
        height: 13%;
        background: #111;
        padding: 10px; 	
        border: 2px solid #ddd;
        float: left;
        font-size: 1.2em;
        color: white;
        position: fixed;
        top: 50%; left: 50%;
        z-index: 99999;
        text-align: center;
        box-shadow: 0px 0px 20px #999; /* CSS3 */
        -moz-box-shadow: 0px 0px 20px #999; /* Firefox */
        -webkit-box-shadow: 0px 0px 20px #999; /* Safari, Chrome */
        border-radius:3px 3px 3px 3px;
        -moz-border-radius: 3px; /* Firefox */
        -webkit-border-radius: 3px; /* Safari, Chrome */
    }
    
    #rekon_saldo {
        display: none;
    }
    
    #hasil_rekon {
        border: 1px solid #111;
        font-size: 12px;
    }
</style>
<form id="ceksaldo" method="post" action="">
    <table id="grid">
        <thead>
        <th colspan="7">Cek Hasil Rekonsiliasi SAKPA</th>
        </thead>
        <tr>
            <th>Kode Satker</th>
            <td colspan="6" id="kdsatker"></td>
        </tr>
        <tr>
            <th>Nama Satker</th>
            <td colspan="6" id="nmsatker"></td>
        </tr>
        <tr>
            <th>Tgl Awal</th>
            <td ><input type="text" name="tgl_awal" id="tgl_awal" /></td>
            <th>Tgl Akhir</th>
            <td><input type="text" name="tgl_akhir" id="tgl_akhir" /></td>
            <td colspan="3"></td>
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
            <td colspan="7"><input type="submit" id="cek_rekon" value="Cek"/></td>
        </tr>
    </table>
</form>

<script type="text/javascript" src="js/cek_saldo.js"></script>
<div id="loader" style="display:none;">
    <br />
    <img src="img/loader.gif" alt="loader" />
    <div class="message"></div>
</div>
<div id="rekon_saldo">
    <pre>Hasil Rekonsiliasi Saldo</pre>
    <table id="hasil_rekon">
        <thead>
            <th>Kd Perk</th>
            <th>Kd Baes1</th>
            <th>Kd Satker</th>
            <th>Jns Dok</th>
            <th>Tgl Dok</th>
            <th>No Dok</th>
            <th>Rp SAU</th>
            <th>Rp SAI</th>
            <th>Keterangan</th>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>