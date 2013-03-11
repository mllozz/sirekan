Reset Password
<form method="post" action="controller/cont.reset.php" id="frm_reset">
    <label>Kode Departemen :</label><input type="text" id="kddept" name="kddept" maxlength="3" /><span id="kddept"></span><br />
    <label>Kode Unit :</label><input type="text" id="kdunit" name="kdunit" maxlength="2" /><span id="kdunit"></span><br />
    <label>Kode Satker :</label><input type="text" id="kdsatker" name="kdsatker" maxlength="6" /><span id="kdsatker"></span><br />
    <label>Username :</label><input type="text" id="username" name="username" /><span id="username"></span><br />
    <span id="error"></span><br />
    <input type="submit" id="btn_reset" value="Reset Password" />
    
</form>
<span id="error"></span><br />

<div id="data_reset"></div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/reset.js"></script>