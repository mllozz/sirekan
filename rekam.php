<script type="text/javascript" src="js/rekam.js"></script>
<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 85%;
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
    }
    
    input[type=text], option {
        background-color: #fbec88;
        border-width: 1px;
    }
    
    div.ui-datepicker, .ui-datepicker input{
        font-size:62.5%;
    }

</style>
<div id="div_rekam">
    <form method="post" action="controller/cont.rekam.php" id="frm_rekam">
<table id="grid">
    <thead>
    <th colspan="7">Rekam User</th>
    </thead>
    <tbody>

    <tr>
        <th><label>Kode Departemen</label></th><td><input type="text" class="int" name="kddept" maxlength="3" id="kddept"/></td><td colspan="5"><span id="kddept"></span></td>
    </tr>
    <tr>
     <th><label>Kode Eselon 1</label></th><td><input type="text" name="kdunit"  class="int" maxlength="2" id="kdunit"/></td><td colspan="5"><span id="kdunit"></span></td>
    </tr>
    <tr>
     <th><label>Kode Satker</label></th><td><input type="text" name="kdsatker"  class="int" maxlength="6" id="kdsatker"/></td><td colspan="5"><span id="kdsatker"></span></td>
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
     <th><label>Hak Akses</label></th><td><select id="kdakses" name="kdakses">
        <option class="satker" value="2">Satker</option>
        <option class="opr" value="1">Operator Vera</option>
        <option class="spv" value="3">Supervisor</option>
    </select></td>
    <td colspan="2"><span id="isi_user" style="display: none;">Isi Username Admin/Operator</span></td><td colspan="2"><input type="text" id="username" style="display: none;"/></td>
    </tr>
    <tr>
     <th><label>No Surat</label></th><td ><input type="text" name="no_surat" maxlength="50" id="no_surat"/></td><td colspan="5"><span id="no_surat"></span></td>
    </tr>
    <tr>
     <th><label>Tgl Surat</label></th><td><input type="text" name="tgl_surat" id="tgl_surat"/></td><td colspan="5"><span id="tgl_surat"></span></td>
    </tr>
    <tr>
    <td colspan="7"><input type="submit" name="btn_rekam" value="Buat User" /></td>
    </tr>
</form>
    </tbody>
    </table>
    
</div>
<span id="error"></span>
<div id="loader"></div>
<div style="display:none; border:1px solid red;" id="user_baru"> 
</div>
<div id="pdf">
    
</div>
<script type="text/javascript">
    $('#tgl_surat').datepicker({dateFormat: 'yy-mm-dd'});
</script>