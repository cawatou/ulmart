/**
 * Created by Адина on 03.09.2016.
 */
$(function () {
    heightMainGift($('.gift_block .img_block'));
    heightMainGift($('.main_question .img_block'));
    heightMainGift($('.test_item .img_block'));
    heightMainGift($('.gift li'));

    $(function($){
        $("#phone").inputmask("+7 (999) 999-99-99");
    });

    $('#resume_form button').click(function () {
        var count = 0;
        var input = $('#resume_form input:not("#accept")');
        input.removeClass('has-error').removeClass('has-success');
        input.each(function () {
            if($(this).val()==""){
                $(this).parent().addClass('has-error');
                $(this).parent().removeClass('has-success');
                count++;
            }else{
                if($(this).attr('id')=='email_conf' || $(this).attr('id')=='check_number'){
                    if($(this).attr('id')=='email_conf'){
                        if($(this).val()!=$('#email').val()){
                            $(this).parent().addClass('has-error');
                            count++;
                        }
                    }
                    if($(this).attr('id')=='check_number') {
                        if($(this).val().length<8){
                            $(this).parent().addClass('has-error');
                            count++;
                        }
                    }
                }else{
                    $(this).parent().addClass('has-success');
                    $(this).parent().removeClass('has-error');
                }

            }
        });
        if(count!=0){
            return false;
        }
    });
    $('#resume_form input:not("#accept")').keydown(function () {
        $('#resume_form input:not("#accept")').parent().removeClass('has-error');
    });
});
$(window).resize(function () {
    heightMainGift($('.gift_block .img_block'));
    heightMainGift($('.main_question .img_block'));
    heightMainGift($('.test_item .img_block'));
    heightMainGift($('.gift li'));
});
function heightMainGift(block){
    var height = 0;
    block.each(function () {
        if($(this).height()>height){
            height = $(this).height();
        }
    });
    block.height(height).css('line-height', height+'px');
}
