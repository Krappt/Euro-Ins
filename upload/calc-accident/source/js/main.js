$(document).ready(function () {
    var chooseScenarioNumber;
    var chooseInsuranceSums = {};

    "use strict";

    //триггеры для кнопок

    //клик на кнопку "для детей" для выбора сценария №1
    $(".forChildren").click(function () {
        createPage2("1")
    });

    //клик на кнопку "для себя" для выбора сценария №2
    $(".forHimself").click(function () {
        createPage2("2")
    });

    //клик на кнопку выбора программы страхования №1 и №2
    $(".insurance1, .insurance2").click(function () {
        createPage3(this);
    });

    //клик на кнопку далее для перехода к форме данных для страхователя
    $(".goToPage4").click(function () {
        createPage4(this);
    });

    //клик на кнопку далее для отправки данных
    $(".send").click(function () {
        send();
    });

    //триггеры для открытия и закрытия поп-апа
    $(".openPopUp").click(function(){
        if($(this).hasClass("popUpAgreement")) $("#popUpAgreement").show();
    });

    $(".closePopUp").click(function(){
        if($(this).hasClass("popUpAgreement")) $("#popUpAgreement").hide();
    });

    //клик на чекбокс
    $("input[type=checkbox]").click(function () {
        checkBoxRun(this);
    });

    function checkBoxRun(thiselem) {
        if ($(thiselem).prop("checked")) {
            $(thiselem).siblings("label").addClass("selected");
            if($(thiselem).parent().hasClass("isInsurerCheckBoxGroup")) toggleDisabledFieldsOnPage4(true);
        }
        else if(!$(thiselem).prop("checked")) {
            $(thiselem).siblings("label").removeClass("selected");
            if($(thiselem).parent().hasClass("isInsurerCheckBoxGroup")) toggleDisabledFieldsOnPage4(false);
        }
    }

    $("input[type=text]").bind('focus blur',function (event) {
        if(event.type == "focus") {
            if(!$(this).hasClass("fieldFocus")) $(this).val("");
            $(this).addClass("fieldFocus");
        }
        else {
            errorsHandler(this);
            if($(this).val() == "") {
                $(this).val($(this).attr("title"));
                $(this).removeClass("fieldFocus");
            }
        }
    })  //заполнение input'ов
    .each(function(){
            $(this).val($(this).attr("title"));
    });


        $.fn.fancyRadio = function(){
            return $(this).each(function(){
                var p = $(this);
                p.find('input:checked').parent()
                    .find('label.radio').addClass('selected');

                p.find('input[type="radio"]').on('click',function(){
                    p.find('label.selected').removeClass('selected');
                    $(this).parent().find('label.radio').addClass('selected');
                });
            });
        };
        $('.radioGroup').fancyRadio();

    //отрисовка страницы

    //создание элементов для страницы 2
    function createPage2(scenario) {
        var scenarioObject;
        var riskList = $("#riskList");
        if(scenario == "1") scenarioObject = scenarioForChildren.page2;
        else scenarioObject = scenarioForHimself.page2;

        chooseScenarioNumber = scenario;

        $("#page1").hide();
        $("#page2").show();

        //создание списка рисков
        riskList.empty();

        for (var item in scenarioObject.stringsList ) {
            if(scenarioObject.stringsList.hasOwnProperty(item)){
                riskList.append("<li>"+scenarioObject.stringsList[item]+"</li>");
            }
        }

        //добавление стоимостей
        $("#page2InsuranceSum1").html(scenarioObject.insuranceSum1);
        $("#page2cost1").html(scenarioObject.cost1);
        $("#page2InsuranceSum2").html(scenarioObject.insuranceSum2);
        $("#page2cost2").html(scenarioObject.cost2);

        //добавление хинта
        $("#page2MainHint").html(scenarioObject.stringTip);

        setSizes();
    }

    //создание элементов для страницы 3
    function createPage3(thisElem){
        var scenarioObject;

        if(chooseScenarioNumber == "1") {
            $(".dateSplitInsuredBirthday").siblings("input[type=hidden]").addClass("scenario1InsuredBirthday");
            scenarioObject = scenarioForChildren.page3;
        }
        else {
            $(".dateSplitInsuredBirthday").siblings("input[type=hidden]").addClass("scenario2InsuredBirthday");
            $(".radioGroup").hide();
            $("#birthCertificate").attr("disabled","disabled");
            scenarioObject = scenarioForHimself.page3;
        }

        chooseInsuranceSums.insuranceSum = $("span:nth-child(2)",thisElem).html();
        chooseInsuranceSums.cost = $("span:nth-child(5)",thisElem).html();
        $("#page2").hide();
        $("#page3").show();

        $("#insuranceSum").html(chooseInsuranceSums.insuranceSum);
        $("#riskStroke").html(scenarioObject.riskStroke);
        $("#insuranceCost").html(chooseInsuranceSums.cost);
        $("#ageRange").html(scenarioObject.ageRange);

        //парсинг строк с суммами и их перевод в формат int

        var regExp = new RegExp( /\s/g,''); //очистка строки от пробелов

        $("input[name=insuranceSum]").val(parseInt(chooseInsuranceSums.insuranceSum.replace(regExp)));
        $("input[name=insuranceCost]").val(parseInt(chooseInsuranceSums.cost.replace(regExp)));

        setSizes();
    }

    //создание элементов для страницы 4
    function createPage4(thisElem){
        var isError = checkErrors("#page3Middle");
        var insuredAge;
        var yearType;
        var page4 = $("#page4");

        if(!isError) {
            $(thisElem).siblings(".error").html();

            createEndPolicyDate();

            if(chooseScenarioNumber == "1") {
                $(".isInsurerCheckBoxGroup").remove();
            }

            page4.find("input[type=checkbox]").each(function(){
                checkBoxRun(this);
            });

            $("#insuranceSumText").html(chooseInsuranceSums.insuranceSum);
            $("#policyCost").html(chooseInsuranceSums.cost);
            $("#startPolicy").html(dates.startPolicy.getDate()+" "+months2[dates.startPolicy.getMonth()]+" "+dates.startPolicy.getFullYear());
            $("#endPolicy").html(dates.endPolicy.getDate()+" "+months2[dates.endPolicy.getMonth()]+" "+dates.endPolicy.getFullYear());

            insuredAge = Math.floor(CalcDate(globalDate,dates.insured.birthday)/366);
            if(insuredAge%10 == 1) yearType = "год";
            else if (insuredAge%10 > 1 && insuredAge%10 < 5) yearType = "года";
            else yearType = "лет";

            $("#insuredAge").html(insuredAge+" "+yearType);
            $("#insuredFullName").html($("input[name=insuredLastName]").val()+" "+$("input[name=insuredFirstName]").val()+" "+$("input[name=insuredPatronymic]").val());

            $("#page3").hide();
            page4.show();
        }
        else $(thisElem).siblings(".error").html(errors.page3GlobalError);

        setSizes();
    }

    //отправка данных
    function send() {
        var isError = checkErrors("#page4Middle");

        if(!isError && $("#agreement").prop("checked")) {
            $("input[disabled=disabled]").each(function(){
                $(this).removeAttr("disabled");
            });
            document.getElementById('sendRequest').submit();
        }
        else $(".globalError").html(errors.lastError);

        setSizes();
    }

    /**
     * @return {Boolean}
     */
    function checkErrors(scope) { //проверка на наличие ошибок и пустых полей
        var isError = false;

        $(scope).find("input[type=hidden]").each(function(){
            errorsHandler(this);
        });

        $(scope).find(".error").each(function(){
            if($(this).html() != "" && !$(this).hasClass("globalError")) isError = true;
        });

        $(scope).find("input[type=text]").each(function(){
            if($(this).val() == $(this).attr("title")) isError = true;
        });

        return isError;
    }

    //расчет даты окончания полиса
    function createEndPolicyDate(){
        var endPolicyDate = new Date();
        var year = dates.startPolicy.getFullYear();
        var day;
        var month;

        endPolicyDate.setTime(dates.startPolicy.getTime() + ((IsLeapYear(year))?365:364) * 86400000);
        day = endPolicyDate.getDate();
        month = endPolicyDate.getMonth()+1;
        year = endPolicyDate.getFullYear();

        $("input.endPolicy").val(((day < 10)?('0' + day):day)+ '.' + ((month < 10)?('0' + month):month) + '.' + year);

        dates.endPolicy = endPolicyDate;
    }

    function toggleDisabledFieldsOnPage4(isDisabled) {
        var page4 = $("#page4Middle .inputGroupLeft, #page4Middle .inputGroupRight");
        var page3 = $("#page3Middle");

        page4.find(".error").html("");
        page4.find("input[type=text],select,input[type=hidden]").each(function(){
            if(isDisabled) {
                var sourceElement;
                if($(this).prop("tagName") == "INPUT") {
                    sourceElement = page3.find("input[title='"+ $(this).attr("title")+"']").val();
                    $(this).addClass("fieldFocus");
                }
                else if($(this).prop("tagName") == "SELECT") {
                    sourceElement = page3.find("select[title='"+ $(this).attr("title")+"']").val();
                    if($(this).prop("tagName")== "SELECT") $(this).parent().addClass("disabled");
                }
                $(this).val(sourceElement);
                $(this).attr("disabled","disabled").addClass("disabled");
            }
            else {
                $(this).removeAttr("disabled").removeClass("disabled");
                if($(this).prop("tagName") == "SELECT") $(this).parent().removeClass("disabled");
            }
        });
    }

    //динамическое изменение размера с использование postmessage

    var parent_url = decodeURIComponent( document.location.hash.replace( /^#/, '' ) );

    function setSizes() {
            var cont = $("#calc");
            XD.postMessage(cont.outerHeight( true )+","+cont.outerWidth( true ), parent_url, parent );
    }

    setSizes();
});

//обработчик ошибок
function errorsHandler(thiselem) {
    var elem = $(thiselem);
    var value = $(thiselem).val();
    var isError = false;
    var error = "";

    var code;
    var i;
    var age;

    if(value.replace(/\s+/g, '').length){
        if(elem.hasClass("fieldNames")) {
            for (i = 0; i < value.length; i++) {
                code = value.charCodeAt(i);
                if((code < 1040 || code > 1103) && code != 32) {
                    error = errors.cyrillic;
                    isError = true;
                    break;
                }
            }
        }
        else if(elem.hasClass("scenario1InsuredBirthday")) {
            age = Math.floor(CalcDate(globalDate,value)/366);
            if(age < 1 || age > 17) error = errors.scenario1InsuranceBirthday;
        }
        else if(elem.hasClass("scenario2InsuredBirthday") || elem.hasClass("insurerBirthday")) {
            age = Math.floor(CalcDate(globalDate,value)/366);

            if(age < 18 || age > 64) error = errors.scenario2InsuranceBirthday;
        }
        else if(elem.hasClass("insuredIssueDocument") || elem.hasClass("insurerIssueDocument")){
            if(CalcDate(globalDate,value) < 0) error = errors.insuredIssueDocument;
        }
        else if(elem.hasClass("insuredIssueDocument") || elem.hasClass("insurerIssueDocument")){
            if(CalcDate(globalDate,value) < 0) error = errors.insuredIssueDocument;
        }
        else if(elem.hasClass("fieldEmail")){
            if(value.indexOf('@') == -1 || value.indexOf('.') == -1 ) error = errors.email;
        }
        else if(elem.hasClass("fieldPhone")){
            for (i = 0; i < value.length; i++) {
                code = value.charCodeAt(i);
                if ((code < 48 || code > 57) && code != 43 && code != 45 && code != 32) {
                    error = errors.phone;
                    break;
                }
            }
        }
    }
    else if(value.length > 0) error = errors.empty;

    elem.siblings(".error").html(error);
}

//утилиты

/**
 * @return {Number}
 */
function CalcDate(date, date2) { // разница в днях
    var d2;
    if(typeof date2 == "string") d2 = StrToDate(date2);
    else d2 = date2;
    var dat = date.getTime() - d2.getTime();

    dat = Math.floor(dat / 1000 / 3600 / 24);

    return dat;
}

/**
 * @return {Date}
 */
function StrToDate(Dat) { // Перевод строки Дд.Мм.ВвГг в формат даты
    var year = Number(Dat.substr(6, 4));
    var month = Number(Dat.substr(3, 2));
    var day = Number(Dat.substr(0, 2));

    return new Date(year, month - 1, day)
}

/**
 * @return {Boolean}
 */
function IsLeapYear(aYear) { // Определить высокосный ли год
    return(((aYear%4==0) && (aYear%100!=0)) || (aYear%400==0));
}