<?php
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<?if(isset($code)):   
    $form = ActiveForm::begin(['id' => 'resume_form']); ?>
    <div class="panel">
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" class="form-control" id="name" name=name>
        </div>
        <div class="form-group">
            <label for="phone">Номер телефона</label>
            <input type="text" class="form-control" id="phone" name=phone>
        </div>
        <div class="form-group">
            <label for="email">Почта</label>
            <input type="email" class="form-control" id="email" name=email>
        </div>
        <div class="form-group">
            <label for="email_conf">Повторите почту</label>
            <input type="email" class="form-control" id="email_conf" name=email_conf>
        </div>
        <div class="form-group">
            <input type="checkbox" name=accept id="accept">
            <label for="accept"> Я согласен с условиями акции</label>
        </div>
        <button type="submit" class="btn btn-default">Отправить</button>
    </div>
    <?php ActiveForm::end(); ?>
<?else:
    Yii::$app->response->redirect('/');
endif?>

<?php
if (!yii::$app->request->isPjax) {
    $this->registerJs('
        $(document).on("submit", "#resume_form", function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            console.log(data);
            $.ajax({
                type : "POST",
                url : "/resumesend",
                data : data,
                success: function(data) {
                    
                   alert(data);
                    
                   console.log(data);
                }
            }); 
        })
        ', $this::POS_END);
}
?>
