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
<form method="post" action="controller/cont.reset.php" id="frm_reset">
<table id="grid" >
    <thead>
    <th colspan="3">Reset Password</th>
    </thead>
    <tbody>
    <tr>
    <th><label>Kode Departemen</label></th><td><input type="text" id="kddept" name="kddept" maxlength="3" /></td><td><span id="kddept"></span></td>
    </tr>
    <tr>
    <th><label>Kode Unit</label></th><td><input type="text" id="kdunit" name="kdunit" maxlength="2" /></td><td><span id="kdunit"></span></td>
    </tr>
    <tr>
    <th><label>Kode Satker</label></th><td><input type="text" id="kdsatker" name="kdsatker" maxlength="6" /></td><td><span id="kdsatker"></span></td>
    </tr>
    <tr>
    <th><label>Username</label></th><td><input type="text" id="username" name="username" /></td><td><span id="username"></span></td>
   </tr>
    <tr>
    <td colspan="3"><input type="submit" id="btn_reset" value="Reset Password" /></td>
    </tr>
</form>
</table>
<span id="error"></span>
<span id="error"></span>
<div id="data_reset"></div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/reset.js"></script>