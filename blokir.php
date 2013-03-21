<style type="text/css">
    #grid,#tbl_user {
        margin: 1px 1px;
        border: 1px solid black;
        padding: 0;
        border-collapse: collapse;
        font-family: Calibri, sans-serif;
        font-size: 12px;
    }

    thead tr {
        border-bottom: 1px solid black;
        background: #A7C9B8;
    }

    thead tr:hover {
        background: #A7C9B8;
    }

    tr {
        height: 20px;
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
        padding: 0 10px;
        width: auto;
    }

    td:hover {
        cursor: pointer;
    }

    #grid td:last-child {
        text-align: center;
        width: auto;
    }

    #tbl_user tr th {
        text-align: left;
    }

    #tbl_user thead th {
        text-align: center;
    }
    #div_blokir {
        display: none;
    }

    #tbl_user td{
        text-align: left;
    }

    div.ui-datepicker, .ui-datepicker input{
        font-size:62.5%;
    }
    
    #simpan_blokir, #edit_blokir, #buka_blokir {
        display: hidden;
    }
</style>
<div id="div_grid">
    <input type="text" id="cari" placeHolder="Cari Username"/><input type="submit" value="Refresh" id="refresh">
    <table id="grid">
        <thead>
            <tr>
                <th>KDDEPT</th>
                <th>KDUNIT</th>
                <th>KDSATKER</th>
                <th>NAMA SATKER</th>
                <th>HAK AKSES</th>
                <th>USERNAME</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <a id="prev" href="">Prev</a>||<a id="next" href="">Next</a>
</div>
<div id="div_blokir">
    <table id="tbl_user" >
        <thead>
        <th colspan="3">DETAIL PEMBLOKIRAN</th>
        </thead>
        <tr>
            <th>USERNAME</th>
            <td colspan="2" id="username"></td>
        </tr>
        <tr>
            <th>KODE DEPT</th>
            <td id="kddept"></td>
            <td id="nmdept"></td>
        </tr>
        <tr>
            <th>KODE UNIT</th>
            <td id="kdunit"></td>
            <td id="nmunit"></td>
        </tr>
        <tr>
            <th>KODE SATKER</th>
            <td id="kdsatker"></td>
            <td id="nmsatker"></td>
        </tr>
        <form method="post" id="frm_blokir">
            <input type="hidden" name="id_user" id="id_user"/>
            <input type="hidden" name="id_blokir" id="id_blokir"/>
            <tr>
                <th>TGL MULAI BLOKIR</th>
                <td colspan="2"><input type="text" name="tgl_mulai" id="tgl_mulai" placeHolder="Tgl Mulai"/></td>
            </tr>
            <tr>
                <th>TGL BERAKHIR BLOKIR</th>
                <td colspan="2" ><input type="text" name="tgl_akhir" id="tgl_akhir" placeHolder="Tgl Berakhir"/></td>
            </tr>
            <tr>
                <th>KETERANGAN BLOKIR</th>
                <td colspan="2"><textarea rows="3" id="ket_blokir" name="ket_blokir" placeHolder="Keterangan"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td align="right"><input type="submit" value="Simpan"id="simpan_baru_blokir"/><input type="submit" value="Buka"id="buka_blokir"/><input type="submit" value="Ubah" id="edit_blokir"/><input type="submit" value="Simpan"id="simpan_blokir"/><input type="submit" id="batal_blokir" value="Batal"/></td>
            </tr>
            <tr>
                <td colspan="3"><span id="error"></span></td>
            </tr>
        </form>
    </table>
</div>
<script type="text/javascript" src="js/blokir.js"></script>