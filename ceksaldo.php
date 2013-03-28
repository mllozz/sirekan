<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 80%;
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
<div id="loader"></div>