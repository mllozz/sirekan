$(document).ready(function(){
    //$('#isinya').load('monitoring.php');
    
    $("ul#menu_parent li a, ul#menu_parent li > ul li a").click(function(){
        var hal= $(this).attr('href');
        if(hal===''){
            return false;
        }
        $('#isinya').load(hal+'.php');
        return false;
    });
});