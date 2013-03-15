<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 65%;
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
        width: 280px;
    }

</style>
<div id="div_rekam">
    <form method="post" action="controller/cont.rekam.php" id="frm_rekam">
<table id="grid">
    <thead>
    <th colspan="3">Rekam User</th>
    </thead>
    <tbody>

    <tr>
        <th><label>Kode Departemen</label></th><td><input type="text" name="kddept" maxlength="3" id="kddept"/></td><td><span id="kddept"></span></td>
    </tr>
    <tr>
     <th><label>Kode Eselon 1</label></th><td><input type="text" name="kdunit" maxlength="2" id="kdunit"/></td><td><span id="kdunit"></span></td>
    </tr>
    <tr>
     <th><label>Kode Satker</label></th><td><input type="text" name="kdsatker" maxlength="6" id="kdsatker"/></td><td><span id="kdsatker"></span></td>
    </tr>
    <tr>
     <th><label>Hak Akses</label></th><td colspan="2"><select id="kdakses" name="kdakses">
        <option value="1">Admin</option>
        <option value="2">Satker</option>
    </select></td>
    </tr>
    <tr>
    <td colspan="3"><input type="submit" name="btn_rekam" value="Buat User" /></td>
    </tr>
</form>
    </tbody>
    </table>
    
</div>
<span id="error"></span>
<div id="loader"></div>
<div style="display:none; border:1px solid red;" id="user_baru"> 
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/rekam.js"></script>
