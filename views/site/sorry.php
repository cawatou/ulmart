<?if(isset($none) || isset($_REQUEST['none'])):?>
    <div class="first_block test_page test_ready">
        <div class="container">
            <div class="row">
                <a href="https://www.ulmart.ru/" class="logo">
                    <img src="images/logo.png" alt="">
                </a>
                <div class="main_img">
                    <a href='http://umnim.ulmart.ru'><img src="images/img_first.png" alt=""></a>
                    <div class="buuble">
                        Умным —<br>
                        бесплатно!
                    </div>
                </div>
                <div class="test_block">
                    <p class="result_test">Порой фортуна  изменяет даже самым умным из нас. <br>
                        Не отчаивайся! В следующий раз все обязательно получится!
                    </p>
                </div>
            </div>
        </div>
    </div>
<?endif?>

<?if(isset($dumb) || isset($_REQUEST['dumb']) ):?>
    <div class="first_block test_page test_ready">
        <div class="container">
            <div class="row">
                <a href="" class="logo">
                    <img src="images/logo.png" alt="">
                </a>
                <div class="main_img">
                    <a href='http://umnim.ulmart.ru'><img src="images/img_first.png" alt=""></a>
                    <div class="buuble">
                        Умным —<br>
                        бесплатно!
                    </div>
                </div>
                <div class="test_block">
                    <p class="result_test">К сожалению, твой багаж знаний недостаточно полон! <br> Учи уроки, готовься, и все <br>
                        обязательно получится!</p>
                </div>
            </div>
        </div>
    </div>
<?endif?>

<?if(isset($data_code)){
    echo "<pre>".print_r($data_code, 1)."</pre>";
}?>