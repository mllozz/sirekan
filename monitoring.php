<style type="text/css">
    #pie {
        width: 48.5%;
        margin-left: 1%;
        margin-top: 1%;
    }
    
    #pie2 {
        margin-left: 48%;
        margin-right: 1%;
        margin-top: -29.8%;
        width: 48.5%;
        float: right;
    }
    #div0,#div0_pie2 {
        text-wrap: none;
        border: 1px solid black;
        background-color: #4297d7;
    }
    
    #div0 p,#div0_pie2 p {
        text-align: center;
        font-weight: bold;
        padding: 0;
        color: #EDEDED;
    }
    #div1 {
        width:auto;
        background:#FFFFFF;
        border-left:0px;
        border-bottom:	0px;
        height:	38%;
        overflow:hidden;
        border: 1px solid black;
    }
    
    #div1_pie2 {
        width:auto;
        background:#FFFFFF;
        border-left:0px;
        border-bottom:	0px;
        height: 30%;
        overflow:hidden;
        border: 1px solid black;
    }
    .div2{
        position: absolute;
        margin-left: 0px;
        margin-top: 12%;
        margin-bottom: 10px;
        background:#006600;
        background:-moz-linear-gradient(center top, #006600, #004400);
        background:-webkit-gradient(linear, center top, center top, from(#006600), to(#004400));
        filter:	progid:DXImageTransform.Microsoft.gradient(startColorstr='#006600', endColorstr='#004400');
    }
    
    #grid_stat {
        border: 1px solid black; 
        border-collapse: collapse; 
        display: block;
        width: 100%;
    }
    
    thead tr {
        border-bottom: 1px solid black;
        background: #A7C9B8;
        text-align: center;
        font-weight: bold;
    }
    
    thead tr td {
        text-align: center;
    }

    thead tr:hover {
        background: #A7C9B8;
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
    #grid_stat td:first-child-child {
        text-align: left;
        width: 25%;
    }
    #grid_stat td:last-child {
        text-align: left;
        width: 85%;
    }
</style>

<div id="pie">
    <div id="div0"><p id="title"></p></div>
    <div id="div1"></div>
</div>
<div id="pie2">
    <div id="div0_pie2"><p id="title2"></p></div>
    <div id="div1_pie2" style="height:38%;"></div>
</div>
<br/>
<div id="status_rekon">
    <div id="loader"></div>
    <table id="hasil_rekon" style="display:none;">
        <thead>
            <tr>
                <th colspan="16">Rekonsiliasi Semua Satker</th>
            </tr>
            <tr>
            <th>KDDEPT</th>
            <th>KDUNIT</th>
            <th>KDSATKER</th>
            <th>KDDEKON</th>
            <th>JAN</th>
            <th>FEB</th>
            <th>MAR</th>
            <th>APR</th>
            <th>MEI</th>
            <th>JUN</th>
            <th>JUL</th>
            <th>AGS</th>
            <th>SEP</th>
            <th>OKT</th>
            <th>NOV</th>
            <th>DES</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div id="status_rekon_user">
    <table id="grid_stat">
        <thead>
            <tr>
                <td colspan="2">Ringkasan Hasil Rekonsiliasi Bulan Ini</td>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    <div id="hasil_rek" style="margin-left:5%;"></div>
</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/monitoring.js"></script>