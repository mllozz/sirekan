<style type="text/css">
    #pie {
        width: 48.5%;
        margin-left: 1%;
        margin-top: 1%;
    }
    
    #pie2 {
        margin-left: 48%;
        margin-right: 1%;
        margin-top: -35.2%;
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
        height:	47%;
        overflow:hidden;
        border: 1px solid black;
    }
    
    #div1_pie2 {
        width:auto;
        background:#FFFFFF;
        border-left:0px;
        border-bottom:	0px;
        height: 47%;
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
</style>

<div id="pie">
    <div id="div0"><p id="title"></p></div>
    <div id="div1"></div>
</div>
<div id="pie2">
    <div id="div0_pie2"><p id="title2"></p></div>
    <div id="div1_pie2" style="height:47%;"></div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/monitoring.js"></script>