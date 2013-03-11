Ubah Password 

Username : <?php session_start(); print_r($_SESSION['username']); ?>

<form method="post" action="controller/cont.ubah.php" id="frm_ubah" >
    <label>Password Lama :</label><input type="password" name='password' id='password' /> <span id='password'></span><br /> <br />
    <label>Password Baru :</label><input type='password' name='password_baru' id='password_baru' /> <span id='password_baru'></span><br /> <br />
    <label>Ulangi Password Baru :</label><input type='password' name='password_ulangi' id='password_ulangi' /> <span id='password_ulangi'></span><br /> <br />
    <span id='error'></span><br />
    <input type='submit' id="btn_ubah" value='Ubah Password' />   
</form>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ubah.js"></script>
