<?php
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<?//if(isset($data_code)) echo "<pre>".print_r($data_code, 1)."</pre>";
if(isset($data_code['answers_count'])){
    if($data_code['answers_count'] >= 3 && $data_code['answers_count'] <= 5) $text = 'Ты хорошо потрудился и у тебя есть возможность выиграть набор канцелярских товаров!<br> Угадай, за какой из иконок он скрывается! У тебя одна попытка!';
    if($data_code['answers_count'] >= 6 && $data_code['answers_count'] <= 8) $text = 'Ты отлично справился с викториной! Теперь ты можешь выиграть увлекательную настольную игру!<br> Угадай, за какой из иконок скрывается твоя игра! У тебя есть одна попытка!';
    if($data_code['answers_count'] >= 9) $text = 'Ты доказал, что твой мощный интеллект превосходит способности среднестатистического человека и получаешь шанс выиграть ноутбук!<br> Угадай, за какой из иконок он скрывается! У тебя одна попытка!';
}
?>

<div class="first_block test_page test_ready">
    <div class="container">
        <div class="row">
            <a href="https://www.ulmart.ru/" class="logo">
                <img src="images/logo.png" alt="">
            </a>
            <div class="main_img">
                <a href="http://umnim.ulmart.ru">
                    <img src="images/img_first.png" alt="">
                </a>
                <div class="buuble">
                    Умным —<br>
                    бесплатно!
                </div>
            </div>
            <div class="test_block">
                <h1><?=(isset($data_code))?$data_code['answers_count']: '0'?> правильных ответов!</h1>
                <p class="result_test"><?=(isset($text))?$text:'';?></p>
                <ul class="gift">
                    <li class="box">
                        <a class="gift_cell"  data-id="1"><img alt="c1" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="2"><img alt="c2" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="3"><img alt="c3" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="4"><img alt="c4" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="5"><img alt="c5" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="6"><img alt="c6" src="images/gift.png" alt=""></a>
                    </li>
                    <!--<li>
                        <a><img src="images/smile.png" alt=""></a>
                    </li>-->
                    <li class="box">
                        <a class="gift_cell"  data-id="7"><img alt="c7" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="8"><img alt="c8" src="images/gift.png" alt=""></a>
                    </li>
                    <!--<li class="success">
                        <a><img src="images/laptop.png" alt=""></a>
                    </li>-->
                    <li class="box">
                        <a class="gift_cell"  data-id="9"><img alt="c9" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="10"><img alt="c10" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="11"><img alt="c1" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="12"><img alt="c12" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="13"><img alt="c13" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="14"><img alt="c14" src="images/gift.png" alt=""></a>
                    </li>
                    <li class="box">
                        <a class="gift_cell"  data-id="15"><img alt="c15" src="images/gift.png" alt=""></a>
                    </li>
                </ul>
                <a id="certificate" style="display: none">Получить сертификат</a>
                <input type="hidden" id="gift_selected" value="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade sorry" id="sorry" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style='margin-top:17%;'>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            </div>
            <div class="modal-body">
                <div class="test_block">
                    <p class="result_test">Порой фортуна  изменяет даже самым умным из нас. <br>
                        Не отчаивайся! В следующий раз все обязательно получится!
                    </p>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>





<?php
$script = <<< JS
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
                if($(this).attr('id')=='email_conf'){
                    if($(this).val()!=$('#email').val()){
                        $(this).parent().addClass('has-error');
                        count++;
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
    setTimeout(function() {
      block.each(function () {
    
        if($(this).height()>height){
            height = $(this).height();
        }
    });
    block.height(height).css('line-height', height+'px');
    }, 100);
    
}

$(function () {
    $('.write_pass').click(function () {
        var top = $('.three_block').offset().top;
        console.log(parseInt(top));
        $('html,body').animate({ scrollTop: parseInt(top)+'px' }, "slow");
    });
    $('.answer_btn').click(function () {
        var top = $('.second_block').offset().top;
        console.log(parseInt(top));
        $('html,body').animate({ scrollTop: parseInt(top)+'px' }, "slow");
    });
});

$('.close').on('click', function(e){
    e.preventDefault();
    window.location.href = '/';
})

JS;
$this->registerJs($script);
?>

