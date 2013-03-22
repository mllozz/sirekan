<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 90%;
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

</style>
<table id="grid" >
    <thead>
    <th colspan="7">Rekonsiliasi Saldo Awal</th>
    </thead>
    <tbody>
    <form id="frm_saldo" method="post" action="" enctype="multipart/form-data">
    <tr>
        <th>File ADK</th>
        <td colspan="6"><input type="file" name="file_adk" id="file_adk" multiple="none" /></td>
    </tr>
    <tr>
    <th>Jenis Satker</th>
    <td><input type="radio" name="jnssat" id="jnssat" value="dk"/>Dekonsentrasi</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="4"/>Kantor Daerah</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="1"/>Kantor Pusat</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="tp"/>Tugas Pembantuan</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="ub"/>Urusan Bersama</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="ds"/>Desentralisasi</td>
    </tr>
    <tr>
    <td colspan="7"><input type="submit" id="rekon_btn" value="Rekon" /></td>
</tr>
</tbody>
</form>
</table>
<div id="output"></div>
<script type="text/javascript" src="js/saldo.js"></script>