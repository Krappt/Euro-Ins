var selectedBirthdays = [];
var selectedInDay;
var selectedOutDay;

$(document).ready(function () {
    var months=["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];
    var birthYearMin = 1930;
    var numDateMax = 2;
    var currDate = globaldate,
        currDay = currDate.getDate(),
        currMonth = (currDate.getMonth() + 1),
        currYear = currDate.getFullYear();

    $(function() {
        var days = getDaysInMonth(currYear, 1);

        $(".dateSplit").each(function(){
            var elemMonth = $(this).find("select.dateSplitMonths"),
                elemYear = $(this).find("select.dateSplitYears"),
                elemDay = $(this).find("select.dateSplitDays"),
                j;

            if($(this).hasClass("dateSplitTravelDay")){
                for (j = currYear; j <= currYear+numDateMax; j++) elemYear.append("<option value='"+j+"'>"+j+"</option>");
                fillMonths(elemMonth,currMonth);
                fillDays(elemDay,days, 1, currDay);
            }
            else {
                for (j = currYear; j >= birthYearMin; j--) elemYear.append("<option value='"+j+"'>"+j+"</option>");
                fillMonths(elemMonth,1);
                fillDays(elemDay,days, 1, 1);
            }

            var convertDate = (((elemDay.val() < 10)?('0' + elemDay.val()): elemDay.val())+ '.' + ((elemMonth.val() < 10)?('0' + elemMonth.val()):elemMonth.val()) + '.' + elemYear.val());

            if ($(this).hasClass("dateSplitInDay")) selectedInDay = convertDate;
            else if ($(this).hasClass("dateSplitOutDay")) selectedOutDay = convertDate;
            else if ($(this).hasClass("dateSplitBirthday"))  {
                var id = $(this).attr("id");
                var num = parseInt(id.replace(/\D+/g,""));
                selectedBirthdays[num] = convertDate;
            }
        });
    });

    newHumanInit = function(thiselem,index) {
        var elem = $(thiselem);
        var elemMonth = elem.find("select.dateSplitMonths"),
            elemYear = elem.find("select.dateSplitYears"),
            elemDay = elem.find("select.dateSplitDays");

        var convertDate = (((elemDay.val() < 10)?('0' + elemDay.val()): elemDay.val())+ '.' + ((elemMonth.val() < 10)?('0' + elemMonth.val()):elemMonth.val()) + '.' + elemYear.val());
        selectedBirthdays[index] = convertDate;
    }

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

    function fillMonths(thiselem, minMonth) {
        var elem = $(thiselem);
        elem.empty();
        for (var i = minMonth-1; i <months.length; i++) elem.append("<option value='"+(parseInt(i)+1)+"'>"+months[i]+"</option>");
        return elem.val();
    }

    onDateChange = function(thiselem){
        var elem = $(thiselem),
            mainClass = elem.attr("class"),
            day,
            month,
            year;

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
                if(elem.parent().parent().hasClass("dateSplitTravelDay")) {
                    month = fillMonths(elem.parent().siblings("div.dateSplitMonth").find("select"),(year == currYear)?currMonth:1);
                }
                else month = elem.parent().siblings("div.dateSplitMonth").find("select").val();
            }

            if(elem.parent().parent().hasClass("dateSplitTravelDay")){
                if(month == currMonth && year == currYear) minDay = currDay;
            }
            days = getDaysInMonth(parseInt(year), parseInt(month));
            day = fillDays(selectDay, days, selectDay.val(),minDay);
        }
        else {
            day = elem.val();
            month = elem.parent().siblings("div.dateSplitMonth").find("select").val();
            year = elem.parent().siblings("div.dateSplitYear").find("select").val();
        }
        if (elem.parent().parent().hasClass("dateSplitInDay")) {
            selectedInDay = convertDate(day,month,year);
            selectDate(elem.parent().parent());
        }
        else if (elem.parent().parent().hasClass("dateSplitOutDay")) {
            selectedOutDay = convertDate(day,month,year);
            selectDate(elem.parent().parent());
        }
        else if (elem.parent().parent().hasClass("dateSplitBirthday"))  {
            var id = elem.parent().parent().attr("id");
            var num = parseInt(id.replace(/\D+/g,""));
            selectedBirthdays[num] = convertDate(day,month,year);
            onChangeBirthday(elem.parent().parent(),selectedBirthdays[num]);
        }
    };

    getDaysInMonth = function (year,month) {
        return (new Date(year, month, 0)).getDate();
    }

    function convertDate(day,month,year) {
        return currDate = (((day < 10)?('0' + day): day)+ '.' + ((month < 10)?('0' + month):month) + '.' + year);
    }
});