$(document).ready(function() {

    // Отправка кода
    $(document).on("click", ".send_code", function(e) {
        if($('#code').val()!=''){
            e.preventDefault();
            var data = $("#code_form").serialize();
            $.ajax({
                type : "POST",
                url : "/codesend",
                data : data,
                success: function(data) {
                    if(data=='suspect_code'){
                        console.log('suspect_code');
                        $('#suspect').modal('show');
                    }else{
                        console.log('data!="suspect_code"');
                        $("body").html(data);
                    }
                }
            });
        }else{
            return false;
        }
    })


    // Резюме
    $(document).on("submit", "#resume_form", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type : "POST",
            url : "/resumesend",
            data: data,
            success: function(res){
                /*if(res == 'error_email') alert('error_email');
                if(res == 'error_required') alert('error_required');*/
            }
        });
    })

    // Тест
    $(document).on("submit", "#question", function(e) {
        e.preventDefault();
        var answer = $("input[name=answer]:checked").val();
        if(answer){
            $.ajax({
                type : "POST",
                url : "/questions",
                data: {
                    "test": true,
                    "answer": answer,
                    "qid": $("input[name=qid]").val()
                },
                success: function(res){
                    console.log('ajax questions');
                    $("body").html(res);                    
                }
            });
        }else{
            //alert('Необходимо указать ответ');
            console.log('Необходимо указать ответ');
        }

    })

    // Начало теста
    $(document).on("click", "#index_questions", function(e) {
        e.preventDefault();
        $.ajax({
            type : "POST",
            url : "/questions",
            data: {
                "test": true,
            },
            success: function(res){
                console.log('ajax index_questions');
                $("body").html(res);
                timer();
            }
        });
    })

    // Выбор подарка
    $(document).on("click", ".gift_cell", function(e) {
        e.preventDefault();

        var cell = $(this);
        var this_id = $(this).data('id');
        var gifts_id = new Array();
        var gifts_img = ['../images/smile.png', '../images/office.png', '../images/game.png', '../images/comp.png'];


        $.ajax({
            type : "POST",
            url : "/findgift",
            success: function(res){
                var res = JSON.parse(res);
                //console.log(res.success);
                //console.log(gifts_img[res.success]);
                var gift_src = gifts_img[res.success];
                if(res.success > 0){
                    //console.log('done');
                    cell.find('img').attr('src', gift_src);
                    if(res.gift_count > 1){
                        gifts_img.splice(res.success, 1); // Удаляем из массива подарок который выиграл пользователь
                        gifts_img.splice(0, 1); // Удаляем из массива смайлик
                        res.gift_count = res.gift_count - 1;
                        var gifts_id = compose_random(this_id, res.gift_count);
                        for(var key in gifts_id){
                            var id = gifts_id[key];
                            var i = parseInt(key);
                            gift_src = gifts_img[i];
                            $('.gift_cell[data-id="'+id+'"]').find('img').attr('src', gift_src);
                        }
                        console.log(gifts_img);
                    }
                    //$('#certificate').show();
                }
                if(res.success == 0){
                    //console.log('miss');
                    cell.find('img').attr('src', gift_src);
                    var gifts_id = compose_random(this_id, res.gift_count);
                    for(var key in gifts_id){
                        var id = gifts_id[key];
                        var i = parseInt(key) + 1;
                        gift_src = gifts_img[i];
                        $('.gift_cell[data-id="'+id+'"]').find('img').attr('src', gift_src).parent().parent().addClass('success');
                        setTimeout(function(){$('#sorry').modal('show');}, 1000);
                    }
                }
            }

        });
    })


    // Переход к сертификату
    $(document).on("click", "#certificate", function(e) {
        e.preventDefault();
        $.ajax({
            type : "POST",
            url : "/certificate",
            success: function(res){
                $("body").html(res);
                console.log('promo_code_exist');
            }
        });
    })

    // PDF сертификата
    $(document).on("click", ".pdf_cert", function(e) {
        e.preventDefault();
        var promo_code = $(this).closest('.cert').attr('data-code');
        var type = $(this).closest('.cert').attr('data-type');
        var email = $(this).attr('data-email');
        var download = $(this).attr('data-download');
        window.location.href = '/pdf?type='+type+'&promo_code='+promo_code+'&email='+email+'&download='+download;
    })


     $('.download_csv').on('click', function(e){
        e.preventDefault();
        window.location="/createcsv";
        /*$.ajax({
            type: 'POST',
            url: '/createcsv',
            success: function(data){
                 console.log(data);
            }
        })*/
    })


    // Рандом подарков
    function random(id){
        var id = parseInt(id);
        var rand =  Math.ceil(Math.random() * 15);
        //console.log('random(%s) = %s', id, rand);
        if(rand != id) return rand;
        if(rand == id && id <= 15 && id > 1){
            //console.log('--');
            return parseInt(rand) - 1;
        }
        if(rand == id && id >= 1 && id < 15){
            //console.log('++');
            return parseInt(rand) + 1;
        }
    }

    function compose_random(id, count){
        var mas_id = new Array();
        var rand_value = i = 0;
        while (i < count) {
            var rand_value = random(id);
            if(mas_id.indexOf(rand_value) < 0){
                console.log(mas_id.indexOf(rand_value));
                mas_id.push(rand_value);
                i++;
            }else{
                console.log(mas_id.indexOf(rand_value));
            }
        }
        return mas_id;
    }



    // Таймер
    function timer(){
        console.log('timer');
        var obj = $(document).find('#timer').text();
        obj--;
        $(document).find('#timer').text(obj);
        if(obj==0 || obj<0){
	    console.log('last_questions');
            $.ajax({
                type: "POST",
                url : "/questions",
                data: {
                    "last_question": true,
                },
                success: function(res){
                    window.location.href = '/gift';
                    console.log('redirect gift - this dont show in cli');
                }
            });
        }
        setTimeout(timer,1000);
    }

    // Переход к сертификату
    $(document).on("click", "#clear_btn", function(e) {
        e.preventDefault();
        var code = $('#clear_code').val();
        $.ajax({
            type : "POST",
            url : "/clear",
            data: {
                'code': code
            },
            success: function(res){
                alert('Данные пароля сброшены');
            }
        });
    })

})