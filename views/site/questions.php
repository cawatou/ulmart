<?
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
//use yii\widgets\Pjax;
?>


<?if(isset($code) && isset($questions)):?>
   <? $form = ActiveForm::begin(['id' => 'question']); ?>
    <div class="first_block test_page test_ready">
        <div class="container">
            <div class="row">
                <a href="https://www.ulmart.ru/" class="logo">
                    <img src="images/logo.png" alt="">
                </a>
                <div class="main_img">
                   <a href='http://umnim.ulmart.ru'> <img src="images/img_first.png" alt=""></a>
                    <div class="buuble">
                        Умным —<br>
                        бесплатно!
                    </div>
                </div>
                <div class="test_block">
                    <div class="time" id="timer"><?=($timer)?$timer:'180';?></div>
                    <h1>Вопрос <?=$question_num?></h1>
                    <h2><?=$questions['question']?></h2>
                    <ul class="radio">
                        <li>
                            <label for="q1">
                                <input type="radio" name="answer" value="1" id="q1">
                                <?=$questions['a1']?>
                            </label>
                        </li>
                        <li>
                            <label for="q2">
                                <input type="radio" name="answer" value="2" id="q2">
                                <?=$questions['a2']?>
                            </label>
                        </li>
                        <li>
                            <label for="q3">
                                <input type="radio" name="answer" value="3" id="q3">
                                <?=$questions['a3']?>
                            </label>
                        </li>
                        <li>
                            <label for="q4">
                                <input type="radio" name="answer" value="4" id="q4">
                                <?=$questions['a4']?>
                            </label>
                        </li>
                    </ul>
                    <input type="hidden" name="qid" value="<?=$questions['id']?>">
                </div>
            </div>
            <div class="row">
                <p class="write_questions">Правильных ответов: (<span><?=($answers_count)?$answers_count:'0'?></span>)</p>
            </div>
        </div>
    </div>
    <?ActiveForm::end();?>

    <!--<p>Вопрос номер: <b><?/*=$question_num*/?></b></p>-->

    <!--<p class="timer" style='color:red; display: none'><span id="timer1"><?/*=($timer)?$timer:'180';*/?></span> сек</p>-->
    <?php
    
    $script = <<< JS
        setTimeout(function() {
            $('#question label').click(function() {
                $('#question').submit(); 
                $(this).unbind();
          });
          }, 300);
JS;
    $this->registerJs($script);
    
    ?>
<?endif?>


<?if(isset($code) && isset($index)): ?>
    <div class="first_block test_page">
        <div class="container">
            <div class="row">
                <a href="" class="logo">
                    <img src="images/logo.png" alt="">
                </a>
                <div class="main_img">
                   <a href='http://umnim.ulmart.ru'> <img src="images/img_first.png" alt=""></a>
                    <div class="buuble">
                        Умным —<br>
                        бесплатно!
                    </div>
                </div>
                <div class="test_block">
                    <div class="time">180 сек</div>
                    <h1>Отвечай на вопросы <br> и становись участником<br> викторины с  призами</h1>
                    <ul>
                        <li>
                            <div class="test_item">
                                <div class="img_block">
                                    <img src="images/test/test1.png" alt="">
                                </div>
                                <p>6-8 ответов</p>
                            </div>
                        </li>
                        <li>
                            <div class="test_item">
                                <div class="img_block">
                                    <img src="images/test/test2.png" alt="">
                                </div>
                                <p>9-10 ответов</p>
                            </div>
                        </li>
                        <li>
                            <div class="test_item">
                                <div class="img_block">
                                    <img src="images/test/test3.png" alt="">
                                </div>
                                <p>3-5 ответов</p>
                            </div>
                        </li>
                    </ul>
                    <div class="test_text">
                        <p>Мы зададим тебе 10 вопросов из школьной программы. У тебя есть 180 секунд на ответы. В зависимости от количества правильных ответов ты можешь выиграть разные призы. Нужно только угадать за какой из иконок они скрываются! Готов? </p>
                    </div>
                    <div class="btn_block">
                        <a class="btn btn_orange" id="index_questions"><?=($continue)?'Продолжить':'Поехали!';?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?endif?>

<?if(!$code) Yii::$app->response->redirect('/');?>

<?
//if(isset($answer)) echo "<pre>".print_r($answer, 1)."</pre>";
//if(isset($questions)) echo "<pre>".print_r($questions, 1)."</pre>";
?>
<?php

$script = <<< JS
        $(function () {
    heightMainGift($('.gift_block .img_block'));
    heightMainGift($('.main_question .img_block'));
    heightMainGift($('.test_item .img_block'));
    heightMainGift($('.gift li'));
    
    $('.test_page .test_block .radio li label').click(function() {
        $('.test_page .test_block .radio li label').removeClass('active');
        $(this).addClass('active');
    });

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
JS;
$this->registerJs($script);
?>
