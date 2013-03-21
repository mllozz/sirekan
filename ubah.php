<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 35%;
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
    
    input[type=password] {
        background-color: #fbec88;
        border-width: 1px;
    }

</style>

<form method="post" action="controller/cont.ubah.php" id="frm_ubah" >
<table id="grid" >
    <thead>
    <th colspan="3">Ubah Password </th>
    </thead>
    <tbody>
    <tr>
    <th>Username</th><td colspan="2"><?php session_start(); print_r($_SESSION['username']); ?></td>
    </tr>
    <tr>
    <th><label>Password Lama</label></th><td><input type="password" name='password' id='password' /> </td><td><span id='password'></span> </td>
    </tr>
    <tr>
    <th><label>Password Baru</label></th><td><input type='password' name='password_baru' id='password_baru' /> </td><td><span id='password_baru'></span> </td>
    </tr>
    <tr>
    <th><label>Ulangi Password Baru</label></th><td><input type='password' name='password_ulangi' id='password_ulangi' /> </td><td><span id='password_ulangi'></span></td>
    </tr>
    <tr><td colspan="3"><input type='submit' id="btn_ubah" value='Ubah Password' /></td>   </tr>
</form>
</table>
<span id='error'></span><br />
<script type="text/javascript" src="js/ubah.js"></script>
