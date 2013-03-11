<pre> Rekam User </pre>
<div id="div_rekam">
<form method="post" action="controller/cont.rekam.php" id="frm_rekam">
    <label>Kode Departemen</label><input type="text" name="kddept" maxlength="3" id="kddept"/><span id="kddept"></span><br />
    <label>Kode Eselon 1</label><input type="text" name="kdunit" maxlength="2" id="kdunit"/><span id="kdunit"></span><br />
    <label>Kode Satker</label><input type="text" name="kdsatker" maxlength="6" id="kdsatker"/><span id="kdsatker"></span><br />
    <label>Hak Akses</label><select id="kdakses" name="kdakses">
        <option value="1">Admin</option>
        <option value="2">Satker</option>
    </select>
    <br />
    <span id="error"></span>
    <br />
    <div id="loader"></div>
    <input type="submit" name="btn_rekam" value="Buat User" />
</form>
</div>
<div style="display:none; border:1px solid red;" id="user_baru">
    
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/rekam.js"></script>
