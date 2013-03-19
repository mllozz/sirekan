$(document).ready(function(){
    $('#frm_saldo').on('submit',function(e){
        e.preventDefault();
        $('#rekon_btn').attr('disabled',true);
        $.ajax({
        target: '#output',
        success:  afterSuccess //call function after success
        });
        return false;
    });
});

function afterSuccess() {
    $('#rekon_btn').removeAttr('disabled');
}
