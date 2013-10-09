// JavaScript Document
window.onload = function() {
    for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) {
        if(document.getElementsByTagName('input').item(i).type == 'text') {
            document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off');
        }
    }
};

var isChangeSize = true;
$(document).ready(function () {
    var errorsArr = ['Неизвестная страна', 'Латинскими буквами (как в загранпаспорте)', 'Допустимый возраст от 1 до 80 лет', 'Необходимо заполнить все поля', 'Ошибка воода даты', 'Дата начала наступает менее, чем через 24 часа', 'Дата окончания раньше даты начала поездки', 'Действие полиса не должно быть дольше года', 'Введите корректный e-mail', 'Введите корректный телефон (0-9 , ( ) - +)', 'Для продолжения необходимо согласиться с условими соглашения', 'Дата окончания наступает менее, чем через 24 часа', 'Стоимость полиса нулевая. Обновите страницу.', 'Страна уже добавлена', 'Введите корректный номер (0-9, пробел)'],
        monthname = [
            "января", "февраля", "марта",
            "апреля", "мая", "июня",
            "июля", "августа", "сентября",
            "октября", "ноября", "декабря"
        ],
        finaldatearr = [],
        finalcountry = [],
        finalratio = 1,
        finalcurrency,
        finalage,
        finalshengen,
        finaldatein = '',
        finaldateout = '',
        totaldays = 0,
        windowfocus = false;
    for (var i = 1; i < $('input.date.polis').size(); i++) $('input.date.polis:nth-child(' + i + ')').val($('input.date:nth-child(' + i + ')').attr('title'));
    $('input.country').val($('input.country').attr('title'));
    $('input.summa').val($('input.summa').attr('title'));
    $('input.program').val($('input.program').siblings('ul').children('li:nth-child(1)').text());
    $('input.divarea').val($('input.divarea').siblings('ul').children('li:nth-child(1)').text());

    var tempclass;
    var clickflag = 0;
    var valueli;
    var focusflag = 0;
//hover list elements
    $(".calc.list ul li").hover(function () {
        $(this).css('color', '#000000')
    }, function () {
        $(this).css('color', '#666666')
    });
//select list elements
    var multiindex = 0;
    clickli = function (thiselem) {
        valueli = $(thiselem).text();

        $(thiselem).parent('ul').siblings('input[type=text]').val(valueli);
        if($(thiselem).parent('ul').siblings('input').hasClass('summa')){
            $($("input.summa")).each(function () {
                finalcurrency = $(thiselem).children("span").html();
                if($(this).attr("name")!="summa_0") {
                    $(this).val($("input.summa[name=summa_0]").val());
                    if($(this).hasClass("unactive")==true) $(this).removeClass("unactive").addClass("active");

                }
            });
        }
        if ($(thiselem).parent('ul').siblings('input').hasClass('risk') == true) {
            $(thiselem).parent('ul').siblings('input').val(valueli);

        }
        $(".calc.list ul").hide();
        $("input.use").addClass('active').removeClass('unactive').removeClass('use');
        if ($(thiselem).parent('ul').siblings('input').attr('name') == 'program') {
            if ($(thiselem).children('span').html() != 'Стандарт') {
                $('.dateSplitOutDay').hide();
                $('#multi_program').show();
                $('span.multi_val').html($(thiselem).children('span').html());
                $('input#date_out_id').val($('input#date_out_id').attr('title'));
                multiindex = parseInt($(thiselem).children('span').html());
                $('#calc_days').html('0');
            }
            else {
                $('.dateSplitOutDay').show();
                $('#multi_program').hide();
                multiindex = 0;
            }
        }
        if ($(thiselem).parent().siblings('input').hasClass('input_text') == true) $(thiselem).parent().siblings('input').css('text-align', 'left');
        if ($(thiselem).parent('ul').siblings('input').hasClass('country') == true) {
            $(thiselem).parent('ul').siblings('input[type=hidden]').val(countriesEng[parseInt($(thiselem).attr("id"))]);
            checkCountry(null);
            errors($(thiselem).parent().siblings('input'));
        }
        focusflag=0;
    };

    checkCountry = function (thiselem) {
        var selectCountries = [],
            tempcurrency = [],
            isDifferent = false,
            selectedCurrency;
        $('input.country').each(function(){
            selectCountries.push($(this).val().toLowerCase());
        });
        for (var i in countries) {
            for (var j in selectCountries) {
                if (countries[i].toLowerCase() == selectCountries[j]) {
                    $(thiselem).siblings('input[type=hidden]').val(countriesEng[i]);
                    tempcurrency.push(currency[i]);
                    for (var k in tempcurrency) {
                        for (var l in tempcurrency) {
                            if (tempcurrency[k] != tempcurrency[l]) {
                                updateListSum(true, null);
                                isDifferent = true;
                                return;
                            }
                            else selectedCurrency = tempcurrency[l];
                        }
                    }
                    if (isDifferent == false) updateListSum(false, selectedCurrency);
                }

            }
        }
    }

    function updateListSum (isAll, currency) {
        var sumArray = ["30 000 ", "50 000 ", "30 000 ", "50 000 "],
            currencyArray = ["EUR", "EUR", "USD", "USD"],
            elem = $(".listSum:first");

        $("input.summa").val($("input.summa").attr('title')).removeClass('active').addClass('unactive');
        $(".listSum li").remove();
        for (var i = 0; i < ((isAll)?4:2); i++){
            elem.append('<li onmousedown="clickli(this);" class="'+((isAll)?currencyArray[i]:currency)+'">'+sumArray[i]+'<span class="calc usdeur">'+((isAll)?currencyArray[i]:currency)+'</span></li>');
        }
        $(".listSum:first li").last().addClass("lastchild");
    }

//focus inputs
    inputfocus = function (thiselem) {
        if ($(thiselem).css('text-align') == 'center') {
                $(thiselem).val('');
                $(thiselem).css('text-align', 'left');
        }
        if ($(thiselem).hasClass('select_text') == true) {

            $(".calc.list ul").hide();
            $("input.use").addClass('active').removeClass('use');
            $(thiselem).removeClass('active').addClass('use');
            $(thiselem).siblings('ul').show();
            clickflag = 1;

        }
        if (clickflag == 0) {
            $(".calc.list ul").hide();
            $("input.use").addClass('active').removeClass('use');
        }
        if ($(thiselem).hasClass('country') == true) {
            $(thiselem).siblings('ul').children('li.templi').remove();
            $(thiselem).siblings('ul').children('li.lastchild').remove();
            $(thiselem).siblings('ul').append('<li class="lastchild"></li>')
        }
        clickflag = 0;
        if(windowfocus==true) windowfocus = false;
    }

    $(window).blur(function () {
        $(".calc.list ul").hide();
        $('.date').each(function(){
            var elem = $(this);
            if(elem.val() == elem.attr("title") && elem.hasClass("use")) elem.removeClass('use').addClass("unactive");
        });
        $("input.use").addClass('active').removeClass('use');
        clickflag = 0;
    });

    $(window).focus(function () {
        windowfocus = true;
    });

    var countrysize = 0;

    inputblur = function (thiselem) {
        var elem = $(thiselem);
        if (elem.val() == '' || elem.val() == elem.attr('title') && !elem.hasClass('summa')) {
            if(elem.hasClass("input_text")) elem.addClass('unactive');
            if(elem.hasClass('active') == true) elem.removeClass('active').addClass('unactive');
            else if (elem.hasClass('use') == true) elem.removeClass('use').addClass('unactive');
            elem.val(elem.attr('title'));
            elem.css('text-align', 'center');
        }
        else {
            if(elem.hasClass('summa')&&elem.val()!=elem.attr('title')) elem.removeClass('unactive').addClass('active');
            else if (!elem.hasClass('summa')) {
                if(elem.hasClass('use')) {

                }
                elem.removeClass('unactive').addClass('active');
            }
       }
        if ($(thiselem).hasClass('country') == true) {
            if ($('input.country').size() == 1) {
                for (var i in countries) {

                    if ($(thiselem).val().toLowerCase() != countries[i].toLowerCase()) {
                        $("input.summa").val($("input.summa").attr('title'));
                        $("input.summa").removeClass('active').addClass('unactive');
                    }
                }
            }
            if ($('input.country').size() == 1 && $('input.country').val() == $('input.country').attr('title')) {
                $("input.summa").val($("input.summa").attr('title'));
                $("input.summa").removeClass('active').addClass('unactive');
            }
            else if ($('input.country').size() > 1) {
                for (var i = 0; i < $('input.country').size(); i++) {
                    if ($('input[name="country_' + i + '"]').val() == $('input.country').attr('title')) countrysize++;
                    if (countrysize == $('input.country').size()) {
                        $("input.summa").val($("input.summa").attr('title'));
                        $("input.summa").removeClass('active').addClass('unactive');
                    }
                }
            }
            var countryValue = $(thiselem).val().toLowerCase();
            for (var i in countries) {
                if(countryValue == countries[i].toLowerCase()){
                    $(thiselem).val(countries[i]);
                    break;
                }
            }
            checkCountry(thiselem);
        }
        if(!$(thiselem).hasClass("date")) errors(thiselem);
        textenter = true;
        flagcharct = true;
        dotflag = false;
        countrysize = 0;

        focusflag = 0;
    };

//date enter text
    var dotflag = false;
    var textenter = true;
    var flagcharct = true;

    selectDate = function (thiselem) {
        var elem = $(thiselem),
            calcDays = $('#calc_days');
        if (elem.hasClass("dateSplitInDay")) $('input#date_in_id').val(selectedInDay);
        else if (elem.hasClass("dateSplitOutDay")) $('input#date_out_id').val(selectedOutDay);
        errors(elem);
                totaldays = CalcDate(selectedOutDay, selectedInDay)+1;
                totaldays = totaldays.toString();
                if (totaldays.substr(0, 1) != '-') {
                    if($('div.error.date0').html()=='' && $('div.error.date').html()=='') calcDays.html(parseInt(totaldays));
                    else calcDays.html('0');
                }
                else {
                    if($('div.error.date0').html()=='' && $('div.error.date').html()=='') calcDays.html(0);
                    else calcDays.html('0');
                    totaldays = 0;
                }
    }

    function CalcDate(date, date2) {
        var d1 = StrToDate(date);
        var d2 = StrToDate(date2);

        var dat = d1.getTime() - d2.getTime();
        // разница в днях
        dat = Math.floor(dat / 1000 / 3600 / 24);
        return dat;
    }

// Перевод строки Дд.Мм.ВвГг в формат даты
    function StrToDate(Dat) {
        var year = Number(Dat.substr(6, 4));
        var month = Number(Dat.substr(3, 2));
        var day = Number(Dat.substr(0, 2));
        var dat = new Date(year, month-1, day);
        return dat
    }

//drop menu
    $("body").click(function () {
        if (clickflag == 0) {
            $(".calc.list ul").hide();
            $(".use").addClass('active').removeClass('use');
        }
        clickflag = 0;

    });
    listsclick = function () {
        clickflag = 1;
    };
    inputclick = function (thiselem) {
        $(".calc.list ul").hide();
        $("input.use").addClass('active').removeClass('use');

        if($(thiselem).hasClass('select_text')) $(thiselem).removeClass('active').addClass('use');
        else $(thiselem).removeClass('active');

        $(thiselem).siblings('ul').show();
        if ($(thiselem).hasClass('summa')) {
            if ($('input.country').size() == 1 && $('input.country').val() == $('input.country').attr('title')) {

                $(".calc.list ul").hide();
                $("input.use").removeClass('use').addClass("unactive");
            }
            else if ($('input.country').size() > 1) {
                for (var i = 0; i < $('input.country').size(); i++) {
                    if ($('input[name="country_' + i + '"]').val() == $('input.country').attr('title')) countrysize++;
                    if (countrysize == $('input.country').size()) {
                        $(".calc.list ul").hide();
                        $("input.use").addClass('active').removeClass('use');
                    }
                }
            }
/*            else if ($('input.country').size() == 1) {

                for (var i in countries) {
                    if ($('input.country').val().toLowerCase() != countries[i].toLowerCase()) {
                        $(thiselem).siblings('ul').hide();
 $("input.use, textarea.use").addClass('active').removeClass('use');
                    }
                    else {
                        $(thiselem).siblings('ul').show();
                        $(thiselem).removeClass('active').addClass('use');
                        break;
                    }
                }
            }*/
        }
        if($(thiselem).hasClass('unactive')&&!$(thiselem).hasClass('summa')) $(thiselem).removeClass('unactive');
        countrysize = 0;
        if(focusflag==1) {
            if($(thiselem).val() != $(thiselem).attr('title') || $(thiselem).hasClass('summa')) {
                if(!$(thiselem).hasClass('summa')||($(thiselem).hasClass('summa')&&$(thiselem).val()!=$(thiselem).attr("title"))) $(thiselem).removeClass("use").removeClass("unactive").addClass("active");
                if($(thiselem).hasClass('select_text')) {
                    $(thiselem).siblings('ul').hide();
                }
            }
            thiselem.blur(true);

            focusflag=0;
        }
        else if(focusflag==0) focusflag=1;
    }
//build country list
    var tempvalue;
    var temparray;
    var tagList;
    var finaltext;
    var valuelength;
    comparisontext = function (thiselem) {
        $(thiselem).siblings('ul').children('li.templi').remove();
        $(thiselem).siblings('ul').children('li:last-child').addClass('lastchild');
        tempvalue = $(thiselem).val().toLowerCase();
        valuelength = $(thiselem).val().length;
        for (var i in countries) {
            temparray = countries[i];
            tagList = temparray.split("", valuelength);
            finaltext = tagList[0];
            for (var j = 1; j <= valuelength; j++) {
                if (finaltext != undefined) {
                    if (tempvalue == finaltext.toLowerCase()) {
                        $(thiselem).siblings('ul').children('li.lastchild').removeClass('lastchild');
                        if ($(thiselem).siblings('ul').children('li:last-child').index() <= 7) $(thiselem).siblings('ul').append('<li class="templi" onmousedown="clickli(this);" id="'+i+'">' + countries[i] + '</li>')
                        $(thiselem).siblings('ul').children('li:last-child').addClass('lastchild');
                    }
                }
                finaltext += tagList[j];
            }

        }

    };
//add new country

    var countryindex = 0;
    $('#new_country').click(function () {
        countryindex++;
        if (countryindex<4){
            $('#country_wrap').append('<div id="country_' + countryindex + '"></div>');
            $('#country_' + countryindex).append($('#country_0').html());
            $('#country_' + countryindex).children('div.calc.list').children('div.error').html('');
            $('#country_' + countryindex).children('div.calc.list').children('input[type=text]').addClass('second').attr('name', 'country_' + countryindex);
            $('#country_' + countryindex).children('div.calc.list').children('input[type=text]').css('text-align', 'center').addClass('unactive').removeClass('active');
            $('#country_' + countryindex).children('div.calc.list').children('input[type=hidden]').attr('name', 'countryEng_' + countryindex);
            if (countryindex==3)  $('#new_country').remove();
        }
    })
    var humanindex = 1;
    var temphumanindex = 0;
    $('#new_human').click(function () {
        if (humanindex <= 5) {
            for (var i = 0; i < 5; i++) {
                if ($('#human_wrap div#human_' + i).attr('id') == undefined) {
                    temphumanindex = i;
                    break;
                }
            }
            humanindex = temphumanindex;

            $('#human_wrap').append('<div id="human_' + humanindex + '" class="calc_subpage totalhuman"></div>');
            $('#human_' + humanindex).css('margin-top', '30px');
            $('#human_' + humanindex).append($('#human_0').html());
            $('#human_' + humanindex).prepend('<div class="remove_human"><a class="calc link" onclick="remove_human(this);"><span>Х</span> удалить</a></div> ');

            $('#human_' + humanindex+' input.input_text').each(function(){
               if($(this).hasClass("active")) $(this).removeClass("active").addClass("unactive").css("text-align","center");
            });
            $('#human_' + humanindex).find('div.error').html('');

            $('#human_' + humanindex).children('div.calc.left').children('div.lastname_list').children('input').attr('name', 'last_name_' + humanindex);
            $('#human_' + humanindex).children('div.calc.left').children('div.firstname_list').children('input').attr('name', 'first_name_' + humanindex);
            var birthdaySelects = $('#human_' + humanindex).children('div.calc.left').children('div.birthday_list').children('.dateSplitBirthday');
            birthdaySelects.attr('id', 'birthday_' + humanindex);
            $('#human_' + humanindex).children('div.calc.left').children('div.birthday_list').children('input').attr('name', 'birthday_' + humanindex);
            var textareaRisk =  $('#human_' + humanindex).children('div.calc.right').children('div.risk_list').children('input');
            textareaRisk.attr('name', 'risk_' + humanindex);

            $('#human_' + humanindex).children('div.calc.right').children('div.passport').children('input').attr('name', 'passport_number_' + humanindex);

            var inputSumma = $('#human_' + humanindex).children('div.calc.right').children('div.sum_list').children('input');
            inputSumma.attr('name', 'summa_' + humanindex).attr('disabled', 'true').val($("input[name=summa_0]").val());
            if(inputSumma.val()!=inputSumma.attr('title')) inputSumma.removeClass("unactive").addClass("active");
            newHumanInit(birthdaySelects,humanindex);
            humanindex++;
            if ($('#human_wrap div.calc_subpage').size() == 5) humanindex = 5;
            temphumanindex = humanindex;

        }
        if (humanindex == 5) {
            $(this).hide();
        }
    });

    onChangeBirthday = function(thiselem,date) {
        $(thiselem).siblings("input[type=hidden]").val(date);
        errors(thiselem);
    }

    remove_human = function (thiselem) {
        $(thiselem).parent().parent().remove();
        if (humanindex == 5) $('#new_human').show();
    };
    var errorflag = 0;
    errors = function (thiselem) {
        var nowDate = globaldate,
            nowDay = nowDate.getDate().toString(),
            nowMonth = (nowDate.getMonth() + 1).toString(),
            elem = $(thiselem);
        var dateFlag = elem.hasClass('dateSplitInDay') || elem.hasClass('dateSplitOutDay');

        if (dateFlag) {
            var thismonth,
                thisday,
                thisyear,
                dayCount;
        }

        if (nowDay.length < 2) nowDay = ('0' + nowDay);
        if (nowMonth.length < 2) nowMonth = ('0' + nowMonth);
        nowDate = (nowDay + '.' + nowMonth + '.' + nowDate.getFullYear().toString());

        if (!!$(thiselem).closest('div.calc_page1').find(thiselem).attr('class')) {
            if (elem.hasClass('country') == true && elem.val() != elem.attr('title') && elem.hasClass("unactive") == false) {
                for (var i in countries) {
                    if (elem.val().toLowerCase() != countries[i].toLowerCase()) elem.siblings('div.error').html(errorsArr[0]);
                    else {
                        elem.siblings('div.error').html('');
                        break;
                    }
                }
                if($('input.calc.country').size() > 1) {
                    $($('input.calc.country')).each(function () {
                        if ($(this).val() == elem.val() && $(this).attr("name") != elem.attr("name")) {
                            elem.siblings('div.error').html(errorsArr[13]);
                            return false;
                        }
                    });
                }
            }
            if ($(thiselem).hasClass('names') == true && $(thiselem).val() != $(thiselem).attr('title')) {
                var thisval = $(thiselem).val();
                for (var i = 0; i < $(thiselem).val().length; i++) {
                    thisval = $(thiselem).val().substr(i, 1).charCodeAt();
                    if ((thisval >= 65 && thisval <= 90) || (thisval >= 97 && thisval <= 122) || (thisval == 45) || (thisval == 32)) $(thiselem).siblings('div.error').html('');
                    else {
                        $(thiselem).siblings('div.error').html(errorsArr[1]);
                        break;
                    }
                }
            }

            if ($(thiselem).hasClass('passport_number') == true && $(thiselem).val() != $(thiselem).attr('title')) {
                var thisval = $(thiselem).val();
                for (var i = 0; i < $(thiselem).val().length; i++) {
                    thisval = $(thiselem).val().substr(i, 1).charCodeAt();
                    if ((thisval >= 48 && thisval <= 57) || (thisval == 32)) $(thiselem).siblings('div.error').html('');
                    else {
                        $(thiselem).siblings('div.error').html(errorsArr[14]);
                        break;
                    }
                }
            }

            if (elem.hasClass('dateSplitBirthday')) {
                var id = elem.attr("id");
                var num = parseInt(id.replace(/\D+/g,"")),
                    thisdate = selectedBirthdays[num],
                    tempdate = '',
                    finaldate = 0;

                tempdate = CalcDate(nowDate, thisdate);
                finaldate = Math.floor(tempdate / 365);
                finaldate /= 4;
                finaldate = Math.floor((tempdate + finaldate) / 365);
                if (finaldate >= 1 && finaldate <= 80) $(thiselem).siblings('div.error').html('');
                else $(thiselem).siblings('div.error').html(errorsArr[2]);

                for (var j in selectedBirthdays){
                    thisdate = selectedBirthdays[j];
                    tempdate = CalcDate(nowDate, thisdate);
                    finaldate = Math.floor(tempdate / 365);
                    finaldate /= 4;
                    finaldate = Math.floor((tempdate + finaldate) / 365);
                    finaldatearr[j] = finaldate;
                }
            }
            else if ((elem.hasClass('dateSplitInDay') || dateFlag == true)) {
                thismonth = elem.find(".dateSplitMonths").val();
                thisday = elem.find(".dateSplitDays").val();
                thisyear = elem.find(".dateSplitYears").val();
                dayCount = getDaysInMonth(thisyear,thismonth);

                if (thismonth > 12 || thismonth == 0 || thisday > dayCount || thisday == 0) elem.siblings('div.error.date0').html(errorsArr[4]);
                else if ($("#date_in_id").val().match(/[A-zА-я]/g) == null) {
                    if (CalcDate(selectedInDay, nowDate) <= 0) elem.siblings('div.error.date0').html(errorsArr[5]);
                    else elem.siblings('div.error.date0').html('');
                }
                else elem.siblings('div.error.date0').html('');
                dateFlag = true;
            }
            else if (elem.hasClass('dateSplitInDay')) elem.siblings('div.error.date0').html('');
            if ((elem.hasClass('dateSplitOutDay') || dateFlag == true) && $("#date_out_id").val() != $("#date_out_id").attr('title')) {
                var thisdate = 0,
                    globalThisDate = 0;

                thismonth = elem.find(".dateSplitMonths").val();
                thisday = elem.find(".dateSplitDays").val();
                thisyear = elem.find(".dateSplitYears").val();
                dayCount = getDaysInMonth(thisyear,thismonth);
                globalThisDate = CalcDate(selectedOutDay, nowDate);

                if (thismonth > 12 || thismonth == 0 || thisday > dayCount || thisday == 0) elem.siblings('div.error.date').html(errorsArr[4]);
                else if ($('#date_out_id').val().match(/[A-zА-я]/g) == null) {
                    thisdate = CalcDate(selectedOutDay, selectedInDay).toString();
                    if (parseInt(thisdate) < 0) elem.siblings('div.error.date').html(errorsArr[6]);
                    else if (parseInt(thisdate) > 365) elem.siblings('div.error.date').html(errorsArr[7]);
                    else if(parseInt(globalThisDate) <= 0) elem.siblings('div.error.date').html(errorsArr[11]);
                    else elem.siblings('div.error.date').html('');
                }
                else if (parseInt(globalThisDate) <= 0) elem.siblings('div.error.date').html(errorsArr[11]);
                else elem.siblings('div.error.date').html('');
            }
            else if (elem.hasClass('dateSplitOutDay')) elem.siblings('div.error.date').html('');
        }
        else if (!!$(thiselem).closest('div#calc_page3_subpage1').find(thiselem).attr('class')) {
            if ($(thiselem).hasClass('insured') == true && $(thiselem).val() != $(thiselem).attr('title')) {
                var thisval = $(thiselem).val();
                for (var i = 0; i < $(thiselem).val().length; i++) {
                    thisval = $(thiselem).val().substr(i, 1).charCodeAt();
                    if ((thisval >= 65 && thisval <= 90) || (thisval >= 97 && thisval <= 122) || (thisval == 45) || (thisval == 32)) $(thiselem).siblings('div.error').html('');
                    else {
                        $(thiselem).siblings('div.error').html(errorsArr[1]);
                        break;
                    }
                    ;
                }
            }
            else if ($(thiselem).hasClass('insured') == true && $(thiselem).val() == $(thiselem).attr('title')) $(thiselem).siblings('div.error').html('');
            else if ($(thiselem).hasClass('email') == true && $(thiselem).val() != $(thiselem).attr('title')) {
                var thisval = $(thiselem).val();
                thisflag = 0;
                for (var i = 0; i < $(thiselem).val().length; i++) {
                    thisval = $(thiselem).val().substr(i, 1).charCodeAt();
                    if (thisval == 64 || thisval == 46) {
                        $(thiselem).siblings('div.error.email').html('');
                        thisflag++;
                        if (thisflag == 2) break;
                    }
                    if (thisflag != 2) $(thiselem).siblings('div.error.email').html(errorsArr[8]);
                }
            }
            else if ($(thiselem).hasClass('email') == true && $(thiselem).val() == $(thiselem).attr('title')) $(thiselem).siblings('div.error.email').html('')
            else if ($(thiselem).hasClass('phone') == true && $(thiselem).val() != $(thiselem).attr('title')) {
                var thisval = $(thiselem).val();
                for (var i = 0; i < $(thiselem).val().length; i++) {
                    thisval = $(thiselem).val().substr(i, 1).charCodeAt();
                    if ((thisval >= 48 && thisval <= 57) || (thisval >= 40 && thisval <= 45)) $(thiselem).siblings('div.error.phone').html('');
                    else $(thiselem).siblings('div.error.phone').html(errorsArr[9]);
                }
            }
            else if ($(thiselem).hasClass('phone') == true && $(thiselem).val() == $(thiselem).attr('title')) $(thiselem).siblings('div.error.phone').html('');
        }
    };
//list pages
    $('a#bird_to_page2').click(function () {
        $('div.calc_page1').hide();
        $('div.calc_page2').show();
    });
    $('a#bird_to_page1').click(function () {
        $('div.calc_page1').show();
        $('div.calc_page2').hide();
    });
    var nexttrue = true;
    var emptyflag = 0;
    $('div.calc_page1 input#calculate').click(function () {
        $($("div.dateSplitBirthday, div.dateSplitTravelDay")).each(function () {
            if($(this).siblings("div.error").html() == '') errors($(this));
        });
        $($("div.calc_page1 div.error")).each(function () {
            if ($(this).html() != '') {
                if ($(this).hasClass("all") == true) errorflag = 0;
                else errorflag = 1;
                return false;
            }
            else errorflag = 0;
        });
        if(multiindex == 0){
            $($("input.country, input.names, input.passport_number, input#date_out_id, input.summa")).each(function () {
                if ($(this).val() == $(this).attr('title')) {
                    if ($(this).attr('id') == 'date_out_id' && $('input.program').val() != $('input.program').siblings('ul').children('li:first-child').text()) emptyflag = 0;
                    else emptyflag = 1;
                    return false;
                }
                else emptyflag = 0;
            });
        }
        else if(multiindex != 0){
            $($("input.country, input.names, input.summa")).each(function () {
                if ($(this).val() == $(this).attr('title')) {
                    emptyflag = 1;
                    return false;
                }
                else emptyflag = 0;
            });
        }
        calculatefunc();
        if (errorflag != 1 && emptyflag != 1) {
            $('div.calc_page1').hide();
            $('div.calc_page3').show();
            $(this).siblings('div.error').html('');
        }
        else $(this).siblings('div.error').html(errorsArr[3]);
    });
    var globalpremium = 0,
        globalpremiumSend=0;

    calculatefunc = function () {
        var day_person = [];
        var all_person = [];
        var k_risk = [];
        var thissumma,
            thiscurrency = $('.calc.usdeur').html(),
            riskflag = 0,
            tempfinalratio = [];

        $($('input.risk')).each(function () {
            if ($(this).val() == $(this).siblings('ul').children('li:first-child').text()) k_risk[riskflag] = 1.0;
            else if ($(this).val() != $(this).siblings('ul').children('li:first-child').text()) k_risk[riskflag] = 2.0;
            riskflag++;
        });
        for (var i in finaldatearr) {
            if (finaldatearr[i] >= 1 && finaldatearr[i] <= 3) finaldatearr[i] = 2;
            else if (finaldatearr[i] >= 4 && finaldatearr[i] <= 65) finaldatearr[i] = 1.0;
            else if (finaldatearr[i] >= 66 && finaldatearr[i] <= 70) finaldatearr[i] = 1.5;
            else if (finaldatearr[i] >= 71 && finaldatearr[i] <= 75) finaldatearr[i] = 2.0;
            else if (finaldatearr[i] >= 76 && finaldatearr[i] <= 80) finaldatearr[i] = 2.5;
        }
        if (finalcurrency == 'USD') allRate = rateUSD;
        else if (finalcurrency == 'EUR') allRate = rateEUR;
        if (multiindex == 0) {
            $($('div.totalhuman')).each(function (i) {
                thissumma = $(this).children('div.calc.right').children('div.calc.list').children('input.summa').val();
                thissumma = thissumma.substr(0,6);
                if (totaldays >= 1 && totaldays <= 15) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusday[0][0][0]
                        else if (thissumma == '50 000') day_person[i] = bonusday[0][1][0];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusday[1][0][0];
                        else if (thissumma == '50 000') day_person[i] = bonusday[1][1][0];
                    }
                }
                else if (totaldays >= 16 && totaldays <= 30) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusday[0][0][1];
                        else if (thissumma == '50 000') day_person[i] = bonusday[0][1][1];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusday[1][0][1];
                        else if (thissumma == '50 000') day_person[i] = bonusday[1][1][1];
                    }
                }
                else if (totaldays >= 31 && totaldays <= 59) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusday[0][0][2];
                        else if (thissumma == '50 000') day_person[i] = bonusday[0][1][2];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusday[1][0][2];
                        else if (thissumma == '50 000') day_person[i] = bonusday[1][1][2];
                    }
                }
                else if (totaldays >= 60 && totaldays <= 89) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusday[0][0][3];
                        else if (thissumma == '50 000') day_person[i] = bonusday[0][1][3];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusday[1][0][3];
                        else if (thissumma == '50 000') day_person[i] = bonusday[1][1][3];
                    }
                }
                else if (totaldays >= 90 && totaldays <= 180) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusday[0][0][4];
                        else if (thissumma == '50 000') day_person[i] = bonusday[0][1][4];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusday[1][0][4];
                        else if (thissumma == '50 000') day_person[i] = bonusday[1][1][4];
                    }
                }
                else if (totaldays >= 181 && totaldays <= 366) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusday[0][0][5];
                        else if (thissumma == '50 000') day_person[i] = bonusday[0][1][5];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusday[1][0][5];
                        else if (thissumma == '50 000') day_person[i] = bonusday[1][1][5];
                    }
                }
                i++;
            });

        }
        else if (multiindex != 0) {
            $($('div.totalhuman')).each(function (i) {
                thissumma = $(this).children('div.calc.right').children('div.calc.list').children('input.summa').val();
                thissumma = thissumma.substr(0,6);
                $($('input.country')).each(function (l) {
                    if ($(this).val() != $(this).attr('title')) finalcountry[l] = $(this).val();
                    l++;
                });
                for(var l=0;l<finalcountry.length;l++){
                    for (var j in countries) {
                        if (countries[j] == finalcountry[l]) {
                            tempfinalratio[l] = countriesRatio[j];
                        }
                    }
                }
                if (tempfinalratio.length>1) {
                    for (var l in tempfinalratio) {
                        if(tempfinalratio[l]>1) {
                            finalratio = tempfinalratio[l];
                            break;
                        }
                    }
                }
                else finalratio = tempfinalratio[0];
                if (multiindex == 30) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[0][0][0]
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[0][1][0];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[1][0][0];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[1][1][0];
                    }
                }
                else if (multiindex == 45) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[0][0][1];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[0][1][1];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[1][0][1];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[1][1][1];
                    }
                }
                else if (multiindex == 60) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[0][0][2];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[0][1][2];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[1][0][2];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[1][1][2];
                    }
                }
                else if (multiindex == 90) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[0][0][3];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[0][1][3];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[1][0][3];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[1][1][3];
                    }
                }
                else if (multiindex == 180) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[0][0][4];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[0][1][4];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[1][0][4];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[1][1][4];
                    }
                }
/*                else if (multiindex == 366) {
                    if(thiscurrency == 'EUR'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[0][0][5];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[0][1][5];
                    }
                    else if(thiscurrency == 'USD'){
                        if (thissumma == '30 000') day_person[i] = bonusdaymulti[1][0][5];
                        else if (thissumma == '50 000') day_person[i] = bonusdaymulti[1][1][5];
                    }
                }*/
                i++;
            });
        }
        if (errorflag != 1 && emptyflag != 1)
        {
            for (var i in day_person) {

                if (multiindex == 0) {
                    all_person[i] = day_person[i] * totaldays * finaldatearr[i] * k_risk[i] * allRate;
                }
                else if (multiindex != 0) {
                    all_person[i] = day_person[i] * finalratio * finaldatearr[i] * k_risk[i] * allRate;
                }
                if (i == day_person.length - 1) {
                    for (var j in all_person) {
                        globalpremium += all_person[j];
                    }
                }
            }
            fillPage3();
        }
    };

    finalDate = function (type) {
        var finaldatetemp = '',
            thisfinaldate = '';
        if (type == "date_in") thisfinaldate = selectedInDay;
        else if (type == "date_out") thisfinaldate = selectedOutDay;
        if (thisfinaldate.substr(3, 1) != '0') finaldatetemp = thisfinaldate.substr(3, 2);
        else finaldatetemp = thisfinaldate.substr(4, 1);
        finaldatetemp = parseInt(finaldatetemp);
        thisfinaldate = thisfinaldate.substr(0, 2) + ' ' + monthname[finaldatetemp - 1] + ' ' + thisfinaldate.substr(6, 4);

        return thisfinaldate;
    };
    fillPage3 = function () {
        var thisappend,
            thisparent,
            thisdate,
            tempdate,
            totalHumans=0,
            nowDate = globaldate,
            nowDay = nowDate.getDate().toString(),
            nowMonth = (nowDate.getMonth() + 1).toString();
        if (nowDay.length < 2) nowDay = ('0' + nowDay);
        if (nowMonth.length < 2) nowMonth = ('0' + nowMonth);
        nowDate = (nowDay + '.' + nowMonth + '.' + nowDate.getFullYear().toString());


        /* сбор инфы */
        for (var i in finalcountry) finalcountry.splice(i, 1);
        finalshengen = 0;
        //date
        finaldatein = finalDate('date_in');
        $($('input.country')).each(function (i) {
            if (i <= 4 && $(this).val() != $(this).attr('title')) finalcountry[i] = $(this).val();
            else if (i == 5) finalcountry[i] = '...';
            for (var j in countries) {
                if (countries[j] == finalcountry[i]) {
                    if (shengen[j] == 1 && finalshengen == 0) finalshengen = 1;
                }
                ;
            }
            ;
            i++;
        });
        /* сбор инфы */


        $('div.calc_page3 div.calc.value.country').html(finalcountry.join(', '));
        $('div.calc_page3 div.calc.value.start').html(finaldatein);
        if (multiindex == 0) {
            finaldateout = finalDate('date_out');
            $('div.calc_page3 div.calc.value.end').html(finaldateout);
            $('div.calc_page3 span.calc.days').html(totaldays);

        }
        else if (multiindex != 0) {
            $('div.calc_page3 span.calc.days').html(multiindex);
            var tempdate = selectedInDay;
            var year = Number(tempdate.substr(6, 4));
            var month = Number(tempdate.substr(3, 2) - 1);
            var day = Number(tempdate.substr(0, 2));
            var dat = new Date(year, month, day);
            dat.setDate(Number(366) + day);
            day = dat.getDate();
            month = dat.getMonth();
            year = dat.getFullYear();
            if(day<10) day = "0"+String(day);
            finaldateout = day + ' ' + monthname[month] + ' ' + year;
            $('div.calc_page3 div.calc.value.end').html(finaldateout);

            if(month<9) month="0"+String(month+1);
            else month = month+1;
            $("#date_out_id").val(day + '.' + (month) + '.' + year);
        }
        //human
        $('div#calc_human_wrap div.second').remove();
        $($("div.calc_subpage.totalhuman")).each(function (i) {
            var lastname = $(this).find('input.lastname').val(),
                thissumma = $(this).find('input.summa').val(),
                thisrisks = $(this).find('input.risk').val();
            firstname = $(this).find('input.firstname').val();

            thisparent = 'div.calc_page3 div#subpage_human_';
            thisdate = selectedBirthdays[i];
            tempdate = CalcDate(nowDate, thisdate);
            finalage = Math.floor(tempdate / 365);
            finalage /= 4;
            finalage = Math.floor((tempdate + finalage) / 365);

            if (i >= 1) {
                thisappend = $(thisparent + '0').html();
                $('div#calc_human_wrap').append('<div class="calc_subpage_human second" id="subpage_human_' + i + '"></div>');
                $(thisparent + i).append(thisappend);
            }
            $(thisparent + i + ' div.calc.value.name').html(lastname + ' ' + firstname);
            $(thisparent + i + ' span.calc.human_age').html(finalage);
            $(thisparent + i + ' div.calc.summa').html(thissumma);
            if (thisrisks.length >= 63)$(thisparent + i + ' div.calc.risks').html(thisrisks.substr(0, 63) + '...');
            else $(thisparent + i + ' div.calc.risks').html(thisrisks);

            i++;
        });
        $('div.calc_page3 input.insured').val($('input[name="last_name_0"]').val() + ' ' + $('input[name="first_name_0"]').val());
        if (finalshengen == 1) $('div.calc_page3 div.calc_page3_top_subinfo').show();
        else $('div.calc_page3 div.calc_page3_top_subinfo').hide();
        globalpremium = globalpremium.toFixed(2).toString();
        globalpremiumSend = globalpremium;
        globalpremium = globalpremium.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
        $('div.calc_page3 span#totalsumm').html(globalpremium);
        /* send to handler */
        $('#totalInput').val(globalpremiumSend);
        $('#rateInput').val(allRate);
        $($('div.totalhuman')).each(function () {
            totalHumans++;
        });
        $('#totalHumansInput').val(totalHumans);
        var finalDays = $('div.calc_page3 span.calc.days').html();
        $('#totalDaysInput').val(finalDays);
    };

    $('div.calc_page3 input#issue').click(function () {
        var checkTotalSum = parseFloat($('#totalsumm').html());
        $($("div.calc_page3 div.error")).each(function () {
            if ($(this).html() != '') {
                if ($(this).hasClass("all") == true) errorflag = 0;
                else errorflag = 1;
                return false;
            }
            else errorflag = 0;
        });
        $($("input.address, input.insured, input.email, input.phone")).each(function () {
            if ($(this).val() == $(this).attr('title')) {
                emptyflag = 1;
                return false;
            }
            else emptyflag = 0;
        });
        if (errorflag != 1 && emptyflag != 1 && checkTotalSum > 0) {
            $('div#calc_page3_subpage1').hide();
            $('div#calc_page3_subpage2').show();
            $(this).siblings('div.error').html('');
        }
        else if (checkTotalSum <= 0) $(this).siblings('div.error').html(errorsArr[12]);
        else $(this).siblings('div.error').html(errorsArr[3]);
    });
    var checkflag = 0;
    $('div.calc_page3 input#next').click(function () {
        if (checkflag == 1) {
            var cont = $("#calc_wrap");
            isChangeSize = false;
            XD.postMessage(cont.outerHeight( true )+500+","+cont.outerWidth( true ), parent_url, parent );

            $('div#calc_page3_subpage2').hide();
            document.getElementById('registration').submit();
            $(this).siblings('div.error').html();
        }
        else $(this).siblings('div.error').html(errorsArr[10]);
    });
    checkAgr = function (thiselem) {
        if ($(thiselem).siblings('input[type="checkbox"]').attr('checked') == "checked") {
            $(thiselem).css('background-position', '0px -76px');
            checkflag = 0;
        }
        else {
            $(thiselem).css('background-position', '0px 1px');
            checkflag = 1;
        }
    };
    $('input#agreement_check').fadeTo(0, 0);
});