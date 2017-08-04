<?
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>















<?="<span style='color:green'>".$code."</span><br>";
if(isset($code) && isset($questions)):
    $form = ActiveForm::begin(['id' => 'question']); ?>
  
  
  
  <div class="global_container_">
    <div class="top">
        <div class="l-constrained">
            <img class="dshpsh" src="/test_img/dshpsh.png" alt="" width="286" height="31">
            <img class="man" src="/test_img/man.png" alt="" width="680" height="291">
            <div class="ellips-2-holder">
                180сек
            </div>
            <div class="col">
                <p class="text">Вопрос №1</p>
                <p class="text" style="font-size: 55px;margin-top: 45px">Кому можно было носить бороды
                    во времена царствования Петра І?</p>
                <div class="group-1 test_group" style="margin-top: 70px">
                    <div class="col-md-6"><a>Дворянам</a></div>
                    <div class="col-md-6"><a>Лицам духовного звания</a></div>
                    <div class="col-md-6"><a>Чиновникам</a></div>
                    <div class="col-md-6"><a>Крестьянам</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
  
  
  
  
  
  
  

<!--
  <div class="panel">
            <div class="form-group">
                <p><?=$questions['question']?></p>
            </div>
            <div class="form-group">
                <input type="radio" name="answer" value="1" id="q1">
                <label for="q1"><?=$questions['a1']?></label>
            </div>
            <div class="form-group">
                <input type="radio" name="answer" value="2" id="q2">
                <label for="q2"><?=$questions['a2']?></label>
            </div>
            <div class="form-group">
                <input type="radio" name="answer" value="3" id="q3">
                <label for="q3"><?=$questions['a3']?></label>
            </div>
            <div class="form-group">
                <input type="radio" name="answer" value="4" id="q4">
                <label for="q4"><?=$questions['a4']?></label>
            </div>
            <input type="hidden" name="qid" value="<?=$questions['id']?>">
            <button type="submit" class="btn btn-default send_answer">Отправить</button>
			
			-->
			
        </div>
    <?ActiveForm::end();?>
    <p>Вопрос номер: <b><?=$question_num?></b></p>
    <p style='color:green'>Правильных ответов: (<span><?=($answers_count)?$answers_count:'0'?></span>)</p>
    <p style='color:red'>Время: <span id="timer"><?=($timer)?$timer:'180';?></span> сек</p>
	
	
	
<?endif?>


<?if(isset($code) && isset($index)):
    $form = ActiveForm::begin(['id' => 'index_questions']);?>
        <div class="panel">
            <button type="submit" class="btn btn-default"><?=($continue)?'Продолжить':'Начать';?></button>
        </div>
    <?ActiveForm::end()?>
<?endif?>

<?if(!$code) Yii::$app->response->redirect('/');?>

<?
//if(isset($answer)) echo "<pre>".print_r($answer, 1)."</pre>";
//if(isset($questions)) echo "<pre>".print_r($questions, 1)."</pre>";
?>