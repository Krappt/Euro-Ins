var dates = {
   insured: {
       birthday: "",
       issueDocument: ""
   },
    insurer: {
        birthday: "",
        issueDocument: ""
    },
    startPolicy: "",
    endPolicy: ""
};
var months=["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];
var months2=["января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря"];

$(document).ready(function () {
    var birthYearMin = 1930;
    var numDateMax = 1;
    var numMaxDays = 2;
    var currDate = globalDate,
        currDay = currDate.getDate(),
        currMonth = (currDate.getMonth() + 1),
        currYear = currDate.getFullYear();

    var maxDate = new Date();
        maxDate.setTime(globalDate.getTime() + 366 * 86400000);

    $(function() {
        var days = getDaysInMonth(currYear, 1);

        $(".dateSplit").each(function(){
            var elemMonth = $(this).find("select.dateSplitMonths"),
                elemYear = $(this).find("select.dateSplitYears"),
                elemDay = $(this).find("select.dateSplitDays"),
                j;

            if($(this).hasClass("dateStartPolicy")){

                for (j = currYear; j <= currYear+numDateMax; j++) elemYear.append("<option value='"+j+"'>"+j+"</option>");
                fillMonths(elemMonth,currMonth,months.length);
                fillDays(elemDay,days, 1, currDay+numMaxDays);
            }
            else {
                for (j = currYear; j >= birthYearMin; j--) elemYear.append("<option value='"+j+"'>"+j+"</option>");
                fillMonths(elemMonth,1,months.length);
                fillDays(elemDay,days, 1, 1);
            }

            var convertDate = (((elemDay.val() < 10)?('0' + elemDay.val()): elemDay.val())+ '.' + ((elemMonth.val() < 10)?('0' + elemMonth.val()):elemMonth.val()) + '.' + elemYear.val());
            var date = new Date(elemYear.val()+"-"+elemMonth.val()+"-"+elemDay.val());

            if ($(this).hasClass("dateSplitInsuredIssueDocument")) dates.insured.issueDocument = date;
            else if ($(this).hasClass("dateStartPolicy")) dates.startPolicy = date;
            else if ($(this).hasClass("dateSplitInsuredBirthday")) dates.insured.birthday = date;
            else if ($(this).hasClass("dateSplitInsurerBirthday")) dates.insurer.birthday = date;
            else if ($(this).hasClass("dateSplitInsurerIssueDocument")) dates.insurer.birthday = date;

            $(this).siblings("input[type=hidden]").val(convertDate);
        });
    });


    function fillDays(thiselem, days, selectedDay, minDay) {
        var elem = $(thiselem);
        elem.empty();
        for (var i = minDay; i<= days; i++) {
            elem.append("<option value='"+i+"'>"+i+"</option>");
            if (i == selectedDay) {
                elem.find("option[value='"+i+"']").attr("selected", "selected");
            }
        }
        return elem.val();
    }

    function fillMonths(thiselem, minMonth, maxMonth) {
        var elem = $(thiselem);
        elem.empty();
        for (var i = minMonth-1; i < maxMonth; i++) elem.append("<option value='"+(parseInt(i)+1)+"'>"+months[i]+"</option>");
        return elem.val();
    }

    onDateChange = function(thiselem){
        var elem = $(thiselem),
            mainClass = elem.attr("class"),
            day,
            month,
            year,
            concertDate;

        if (mainClass != "dateSplitDays"){
            var selectDay = elem.parent().siblings("div.dateSplitDay").find("select"),
                days,
                minDay = 1;

            if (mainClass == "dateSplitMonths"){
                month = elem.val();
                year = elem.parent().siblings("div.dateSplitYear").find("select").val();
            }
            else if (mainClass == "dateSplitYears") {
                year = elem.val();
                if(elem.parent().parent().hasClass("dateStartPolicy")) {
                    month = fillMonths(elem.parent().siblings("div.dateSplitMonth").find("select"),(year == currYear)?currMonth:1,(parseInt(year) == maxDate.getFullYear())?maxDate.getMonth()+1:months.length);
                }
                else month = elem.parent().siblings("div.dateSplitMonth").find("select").val();
            }

            days = getDaysInMonth(parseInt(year), parseInt(month));
            if(elem.parent().parent().hasClass("dateStartPolicy")){
                if(month == currMonth && year == currYear) minDay = currDay+numMaxDays;
                if(parseInt(month) == maxDate.getMonth()+1 && parseInt(year) == maxDate.getFullYear()) days = maxDate.getDate();
            }
            day = fillDays(selectDay, days, selectDay.val(),minDay);
        }
        else {
            day = elem.val();
            month = elem.parent().siblings("div.dateSplitMonth").find("select").val();
            year = elem.parent().siblings("div.dateSplitYear").find("select").val();
        }
        concertDate = convertDate(day,month,year);
        var date = new Date(year+"-"+month+"-"+day);

        if (elem.parent().parent().hasClass("dateSplitInsuredIssueDocument")) dates.insured.issueDocument = date;
        else if (elem.parent().parent().hasClass("dateStartPolicy")) dates.startPolicy = date;
        else if (elem.parent().parent().hasClass("dateSplitInsuredBirthday")) dates.insured.birthday = date;
        else if (elem.parent().parent().hasClass("dateSplitInsurerBirthday")) dates.insurer.birthday = date;
        else if (elem.parent().parent().hasClass("dateSplitInsurerIssueDocument")) dates.insurer.birthday = date;

        elem.parent().parent().siblings("input[type=hidden]").val(concertDate);
        errorsHandler(elem.parent().parent().siblings("input[type=hidden]"));
    };

    getDaysInMonth = function (year,month) {
        return (new Date(year, month, 0)).getDate();
    };

    function convertDate(day,month,year) {
        return currDate = (((day < 10)?('0' + day): day)+ '.' + ((month < 10)?('0' + month):month) + '.' + year);
    }
});