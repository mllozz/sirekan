<style type="text/css">
    #grid {
        margin: 3% 9%;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 16px;
        width: 81%;
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

    #mask {
        display: none;
        background: #000; 
        position: fixed; left: 0; top: 0; 
        z-index: 10;
        width: 100%; height: 100%;
        opacity: 0.8;
        z-index: 999;
    }

    #confirmBox {
        display:none;
        width: 20%;
        height: 15%;
        background: #333;
        padding: 10px; 	
        border: 2px solid #ddd;
        float: left;
        font-size: 1.2em;
        color: white;
        position: fixed;
        top: 50%; left: 50%;
        z-index: 99999;
        text-align: center;
        box-shadow: 0px 0px 20px #999; /* CSS3 */
        -moz-box-shadow: 0px 0px 20px #999; /* Firefox */
        -webkit-box-shadow: 0px 0px 20px #999; /* Safari, Chrome */
        border-radius:3px 3px 3px 3px;
        -moz-border-radius: 3px; /* Firefox */
        -webkit-border-radius: 3px; /* Safari, Chrome */
    }

    span.yes,span.no {
        display: inline-block;
        outline: none;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font: 14px/100% Arial, Helvetica, sans-serif;
        padding: .5em 2em .55em;
        text-shadow: 0 1px 1px rgba(0,0,0,.3);
        -webkit-border-radius: .5em; 
        -moz-border-radius: .5em;
        border-radius: .5em;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
        box-shadow: 0 1px 2px rgba(0,0,0,.2);
        background: -moz-linear-gradient(center top , #FFFFFF, #EDEDED) repeat scroll 0 0 transparent;
        border: 1px solid #B7B7B7;
        color: #606060;
    }
    span.yes:hover,span.no:hover {
        background: #247c20;
	background: -webkit-gradient(linear, left top, left bottom, from(#f88e11), to(#f06015));
	background: -moz-linear-gradient(top,  #f88e11,  #f06015);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
    }

</style>
<table id="grid" >
    <thead>
    <th colspan="7">Rekonsiliasi Saldo Awal</th>
</thead>
<tbody>
<form id="frm_saldo" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id_rekon" id="id_rekon" value="1"/>
    <tr>
        <th>File ADK</th>
        <td colspan="6"><input type="file" name="file_adk" id="file_adk"/></td>
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
        <td colspan="7"><input type="submit" id="rekon_btn" value="Rekon" name="btn_rekon" onclick="return ajaxFileUpload();"/></td>
    </tr>
    </tbody>
</form>
</table>
<div id="loader"></div>
<div id="loader2" style="display:none;">
    <br />
    <img src="img/loader.gif" alt="loader" />
    <div class="message"></div>   
</div>
<div id="output"></div>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>
<script type="text/javascript" src="js/saldo.js"></script>

<div id="confirmBox" style="display:none;">
    <div class="message"></div>
    <br />
    <span class="yes">Ya</span>
    <span class="no">Tidak</span>
</div>