<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 40%;
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
    <td><input type="radio" name="jnssat" id="jnssat" value="dk"/>DK</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="kd"/>KD</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="kp"/>KP</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="tp"/>TP</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="ub"/>UB</td>
    <td><input type="radio" name="jnssat" id="jnssat" value="ds"/>DS</td>
    </tr>
    <tr>
    <td colspan="7"><input type="submit" id="rekon_btn" value="Rekon" /></td>
</tr>
</tbody>
</form>
</table>
<div id="output"></div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/saldo.js"></script>