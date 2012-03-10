<style type="text/css">
    #grid {
        margin: 3% 5%;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 16px;
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
    }
    
    input[type=text] {
        background-color: #fbec88;
        border-width: 1px;
    }
    
    div.ui-datepicker, .ui-datepicker input{
        font-size:62.5%;
    }

    .error {
        border: 1px solid;
        margin: 1% 5%;
        width: 25%;
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
<form method="post" action="controller/cont.reset.php" id="frm_reset">
<table id="grid" >
    <thead>
    <th colspan="7">Reset Password</th>
    </thead>
    <tbody>
    <tr>
    <th><label>Kode Departemen</label></th><td><input type="text" id="kddept" name="kddept" class="int" maxlength="3" /></td><td colspan="5"><span id="kddept"></span></td>
    </tr>
    <tr>
    <th><label>Kode Unit</label></th><td><input type="text" id="kdunit" name="kdunit" class="int" maxlength="2" /></td><td colspan="5"><span id="kdunit"></span></td>
    </tr>
    <tr>
    <th><label>Kode Satker</label></th><td><input type="text" id="kdsatker" name="kdsatker" class="int" maxlength="6" /></td ><td colspan="5"><span id="kdsatker"></span></td>
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
        <th><label>Username</label></th><td><input type="text" id="username" name="username" maxlength="13"/></td><td colspan="5"><span id="username"></span></td>
   </tr>
   <tr>
     <th><label>No Surat</label></th><td><input type="text" name="no_surat" maxlength="50" id="no_surat"/></td><td colspan="5"><span id="no_surat"></span></td>
    </tr>
    <tr>
     <th><label>Tgl Surat</label></th><td><input type="text" name="tgl_surat" id="tgl_surat"/></td><td colspan="5"><span id="tgl_surat"></span></td>
    </tr>
    <tr>
    <td colspan="7"><input type="submit" id="btn_reset" value="Reset Password" /></td>
    </tr>
</form>
</table>
<span class="error" id="error"></span>
<span id="error"></span>
<div id="data_reset"></div>

<div id="pdf">
    
</div>
<script type="text/javascript" src="js/reset.js"></script>
