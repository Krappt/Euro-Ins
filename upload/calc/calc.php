<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/calc/"; ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="calc.css">
<?php
	if (isset($_GET['PartnerID']) and file_exists('styles/calc'.$_GET['PartnerID'].'.css')) { 
		echo '<link rel="stylesheet" type="text/css" href="styles/calc'.$_GET['PartnerID'].'.css">'.PHP_EOL;
	}
?>
    <title>Заказ полиса</title>
    <script language='javascript'>
        var globaldate = 0;
        realtime =<?php echo time();?>;
        setInterval("realtime++", 1000);
        globaldate = new Date(realtime * 1000);
    </script>
    <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="js/postmessage.js"></script>
    <script src="js/data.js"></script>
    <script src="js/date.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        var parent_url = decodeURIComponent( document.location.hash.replace( /^#/, '' ) );
        var rateUSD = 32.6240,
                rateEUR = 40.3885,
                allRate = rateUSD;
        $(document).ready(function () {
            $.ajax({
                type:"GET",
                async:false,
                url:"cb.xml",
                dataType:"xml",
                success:XmlKurs
            });
            function XmlKurs(xml) {
                var d = 0,
                        e = 0;
                $(xml).find("Valute").each(function () {
                    if ($(this).attr('ID') == 'R01235') {
                        d = $(this).find("Value").text();
                    }
                    else if ($(this).attr('ID') == 'R01239') {
                        e = $(this).find("Value").text();
                    }
                });
                rateUSD = parseFloat(d.replace(/\,/, "."));
                rateEUR = parseFloat(e.replace(/\,/, "."));
                allRate = rateUSD;
            }
            var nowDate = globaldate,
                    nowDay = nowDate.getDate().toString(),
                    nowMonth = (nowDate.getMonth() + 1).toString();
            if (nowDay.length < 2) nowDay = ('0' + nowDay);
            if (nowMonth.length < 2) nowMonth = ('0' + nowMonth);
            nowDate = (nowDay + '.' + nowMonth + '.' + nowDate.getFullYear().toString());
            clickSelectDate = function(thiselem){
            };

            function setSizes() {
            if(isChangeSize){
               var cont = $("#calc_wrap");
               XD.postMessage(cont.outerHeight( true )+","+cont.outerWidth( true ), parent_url, parent );
            }
            };

            $(document).click(function () {
               setSizes();
               return false;
             });
             setSizes();
        });
    </script>
</head>
<body>
<div id="calc_wrap" class="calc">

<div class="calc_page1" style="display:block">
<?php
	if (isset($_GET['PartnerID'])) { echo '<form id="registration" action="policy.php?PartnerID='.$_GET['PartnerID'].'" method="post">'; } 
		else { echo '<form id="registration" action="policy.php" method="post">'; }
	echo PHP_EOL;
?>
        <div class="calc_page1_head calc_subpage">
            <h4>Купить Полис для выезжающих за рубеж</h4>
            <span>Предлагаем Вам рассчитать стоимость Полиса для выезжающих за рубеж и приобрести его онлайн всего за 5 минут, не выходя из дома</span>
        </div>
        <div class="calc_page1_top calc_subpage">
            <div class="calc left">
                <div class="calc line program">

                    <div class="calc list program_list" onclick="listsclick(this);">
                        <input class="calc field select_text active program" type="text" name="program"
                               title="программа страхования" value="Стандарт (однократный въезд)" readonly="readonly"
                               onclick="inputclick(this);" onblur="inputblur(this);"/>
                        <ul>
                            <li onmousedown="clickli(this);"><span>Стандарт</span> (однократный въезд)</li>
                            <li onmousedown="clickli(this);">Мульти <span>30</span> дней</li>
                            <li onmousedown="clickli(this);">Мульти <span>60</span> дней</li>
                            <li onmousedown="clickli(this);">Мульти <span>90</span> дней</li>
                            <li onmousedown="clickli(this);" class="lastchild">Мульти <span>180</span> дней</li>
                        </ul>
                    </div>
                    <span class="calc subtext">выберите программу страхования</span>
                    <a class="calc link" id="bird_to_page2">что включает данная программа?</a>
                </div>
                <div class="calc line country">
                    <div id="country_wrap">
                        <div id="country_0">
                            <div class="calc list country_list" onclick="listsclick(this);">
                                <div class="calc error"></div>
                                <input class="calc field select_text country input_text unactive" type="text"
                                       name="country_0" title="страна пребывания" value="страна пребывания"
                                       onkeyup="comparisontext(this);" onfocus="inputfocus(this);"
                                       onblur="inputblur(this);" onclick="inputclick(this);"/>
                                <input type="hidden" name="countryEng_0"/>
                                <ul>
                                    <div class="cyrillic">кириллицей</div>
                                    <li class="lastchild"></li>
                                </ul>

                            </div>

                            <span class="calc subtext">например:  Австрия, Мексика, Япония</span>
                        </div>
                    </div>
                    <a class="calc link" id="new_country">добавить ещё одну страну</a>
                </div>
            </div>
            <div class="calc right">
                <div class="calc line dates">
                    <div class="calc error date0"></div>
                    <input type="hidden" name="date_in" id="date_in_id" title="начало действия полиса"/>
                    <div class="calc dateSplit dateSplitInDay dateSplitTravelDay">
                        <div class="dateSplitDay">
                            <select class="dateSplitDays" onchange="onDateChange(this)"></select>
                        </div>
                        <div class="dateSplitMonth">
                            <select class="dateSplitMonths" onchange="onDateChange(this)"></select>
                        </div>
                        <div class="dateSplitYear">
                            <select class="dateSplitYears" onchange="onDateChange(this)"></select>
                        </div>
                        <span class="calc subtextDate">начало действия полиса</span>
                    </div>


                    <div class="calc error date"></div>
                    <input type="hidden" name="date_out" id="date_out_id" title="окончание действия полиса"/>
                    <div class="calc dateSplit dateSplitOutDay dateSplitTravelDay">
                        <div class="dateSplitDay">
                            <select class="dateSplitDays" onchange="onDateChange(this)"></select>
                        </div>
                        <div class="dateSplitMonth">
                            <select class="dateSplitMonths" onchange="onDateChange(this)"></select>
                        </div>
                        <div class="dateSplitYear">
                            <select class="dateSplitYears" onchange="onDateChange(this)"></select>
                        </div>
                        <span class="calc subtextDate">окончание действия полиса</span>
                        <span class="calc standart_program subtext calcdays">срок действия: <span id="calc_days">0</span> дней</span>
                    </div>




                    <div id="multi_program">
                        <div>«Мульти <span class="multi_val"></span>» - годовая программа страхования, покрывающая
                            неограниченное количество выездов, при которых общая продолжительность поездок не должна
                            превышать <span class="multi_val"></span> дней
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="calc_page1_human calc_subpage">
            <div id="human_wrap">
                <div id="human_0" class="calc_subpage totalhuman">
                    <div class="calc left">
                        <div class="calc list lastname_list" onclick="listsclick(this);">
                            <div class="calc error"></div>
                            <input class="calc field input_text unactive names lastname" type="text"
                                   title="фамилия (лат.)" name="last_name_0" value="фамилия (лат.)" onfocus="inputfocus(this);"
                                   onblur="inputblur(this);" onclick="inputclick(this);"/>

                        </div>

                        <div class="calc list firstname_list" onclick="listsclick(this);">
                            <div class="calc error"></div>
                            <input class="calc field input_text second unactive names firstname" type="text"
                                   title="имя (лат.)" name="first_name_0" value="имя (лат.)" onfocus="inputfocus(this);"
                                   onblur="inputblur(this);" onclick="inputclick(this);"/>

                        </div>
                        <div class="calc list birthday_list">
                            <div class="calc error"></div>
                            <input type="hidden" name="birthday_0"/>
                            <div class="calc dateSplit dateSplitBirthday" id="birthday_0">
                                <div class="dateSplitDay">
                                    <select class="dateSplitDays" onchange="onDateChange(this)">

                                    </select>
                                </div>
                                <div class="dateSplitMonth">
                                    <select class="dateSplitMonths" onchange="onDateChange(this)">

                                    </select>
                                </div>
                                <div class="dateSplitYear">
                                    <select class="dateSplitYears" onchange="onDateChange(this)">

                                    </select>
                                </div>
                            </div>
                            <span class="calc subtextDate">дата рождения</span>
                        </div>

                    </div>
                    <div class="calc right">
                        <div class="calc list risk_list" onclick="listsclick(this);">
                            <input class="calc field select_text active risk" type="text" name="risk_0"
                                                           title="риски" value="Без дополнительных рисков" readonly="readonly"
                                                           onclick="inputclick(this);" onblur="inputblur(this);"/>
                            <ul>
                                <li onmousedown="clickli(this);">Без дополнительных рисков</li>
                                <li class="lastchild" onmousedown="clickli(this);">Спорт / Активный отдых</li>
                            </ul>
                        </div>
                        <div class="calc list passport" onclick="listsclick(this);">
                             <div class="calc error"></div>
                             <input class="calc field input_text second unactive passport_number" type="text"
                                    title="номер загранпаспорта" name="passport_number_0" value="номер загранпаспорта" onfocus="inputfocus(this);"
                                    onblur="inputblur(this);" onclick="inputclick(this);"/>
                        </div>
                        <div class="calc list sum_list" onclick="listsclick(this);">
                            <div class="calc error"></div>
                            <input class="calc field summa select_text second unactive" type="text" name="summa_0"
                                   title="страховая сумма" value="страховая сумма" readonly="readonly"
                                   onclick="inputclick(this);" onblur="inputblur(this);"/>
                            <ul class="listSum"></ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="calc addhumanline"><a class="calc link human" id="new_human">добавить путешественника</a></div>
        </div>
        <div class="calc_page1_bottom calc_subpage">
            <div class="calc error all all1"></div>
            <input class="calc button" type="button" id="calculate" value="Рассчитать"/>
        </div>
</div>
<div class="calc_page2" style="display:none">
    <div class="calc_page2_head calc_subpage">
        <h4>Заказать Полис для выезжающих за рубеж</h4>
        <span>Предлагаем Вам рассчитать стоимость Полиса для выезжающих за рубеж и приобрести его онлайн всего за 5 минут, не выходя из дома</span>
    </div>
    <div class="calc_page2_center calc_subpage">
        <div class="calc center">
            <p>Страховые случаи по Программам Стандарт и Мульти:</p>

            <p>1.МЕДИЦИНСКИЕ УСЛУГИ И ОПЛАТА МЕДИЦИНСКИХ РАСХОДОВ (АМБУЛАТОРНОЕ И СТАЦИОНАРНОЕ ЛЕЧЕНИЕ) <br/>
                2. ЭКСТРЕННАЯ СТОМАТОЛОГИЧЕСКАЯ ПОМОЩЬ (ОТ 100 ДО 200 У.Е.) <br/>
                3. ОРГАНИЗАЦИЯ И ОПЛАТА МЕДИЦИНСКОЙ ТРАНСПОРТИРОВКИ, РЕПАТРИАЦИЯ</p>
            <hr/>
            <p>Multi» - годовая программа страхования, покрывающая неограниченное количество выездов, при которой общая
                продолжительность поездок не должна превышать указанное количество дней - 30/45/60/90/180.</p>

            <p>Например, Клиент приобрёл полис по программе "Multi" 90, съездил на отдых на 10 дней, затем в
                командировку, продолжительность которой 95 дней. Страховая защита не распространится на последние 15
                дней, т.к. указанное в программе количество дней - 90, а Застрахованный провел в поездках -105 дней.</p>

            <div class="bird">
                <a id="bird_to_page1"></a>
            </div>
        </div>
    </div>
</div>
<div class="calc_page3" style=" display:none">
    <div class="calc_page3_top">
        <div class="calc_page3_block">
            <div class="calc value country"></div>
            <div class="calc title">страна пребывания</div>
        </div>
        <div class="calc_page3_block">
            <div class="calc value start"></div>
            <div class="calc title">начало действия полиса</div>
        </div>
        <div class="calc_page3_block">
            <div class="calc value end"></div>
            <div class="calc title">окончание действия полиса</div>
        </div>
        <div class="calc_page3_block">
            <div class="calc value"><span class="calc days"></span> дней</div>
            <div class="calc title">количество дней</div>
        </div>
        <div class="calc_page3_top_subinfo" style=" display:none">Полис будет действовать на всей территории Европы и
            стран Шенгенского соглашения
        </div>
    </div>
    <div class="calc_page3_center">
        <div id="calc_human_wrap">
            <div class="calc_subpage_human first" id="subpage_human_0">
                <div class="calc_page3_block human_block left">
                    <div class="calc value name"></div>
                    <div class="calc title">застрахованный, <span class="calc human_age"></span> год</div>
                </div>
                <div class="calc_page3_block human_block">
                    <div class="calc value summa"></div>
                    <div class="calc title">страховая сумма</div>
                </div>
                <div class="calc_page3_block human_block">
                    <div class="calc value risks"></div>
                    <div class="calc title">род занятий во время поездки</div>
                </div>
            </div>
        </div>
        <div class="calc_subpage_price">
            <div class="calc_page3_block price_block">
                <input type="hidden" id="totalInput" name="cost"/>
                <input type="hidden" id="totalHumansInput" name="totalHumans"/>
                <input type="hidden" id="totalDaysInput" name="totalDays"/>
                <input type="hidden" id="rateInput" name="rate"/>
                <div class="calc value"><span id="totalsumm"><!--30 000,00--></span> руб.</div>
                <div class="calc title">стоимость полиса</div>
            </div>
            <div class="calc_page3_center_subinfo">Электронный полис будет выписан в формате PDF</div>
        </div>
    </div>
    <div class="calc_page3_bottom" id="calc_page3_subpage1" style=" display:block">
        <div class="calc_page3_bottom_line">
            <div class="calc page3_title address">Адрес застрахованного:</div>
            <input class="calc field input_text unactive address" type="text" title="Адрес фактического проживания"
                   name="address" value="Адрес фактического проживания" onfocus="inputfocus(this);"
                   onblur="inputblur(this);" onclick="inputclick(this);"/>
        </div>
        <div class="calc_page3_bottom_line">
            <div class="calc left_info">
                Данные лица, оплачивающего страховку
            </div>
            <div class="calc right_info">
                <div class="calc list insured_list" onclick="listsclick(this);">
                    <div class="calc error"></div>
                    <input class="calc field input_text active insured" type="text" title="фамилия и имя (лат.)"
                           name="insured_name" value="" onfocus="inputfocus(this);" onblur="inputblur(this);"
                           onclick="inputclick(this);" style=" text-align:left"/>


                </div>
            </div>
        </div>
        <div class="calc_page3_bottom_line">
            <div class="calc left_info">
                Необходимо указать Ваш телефон и e-mail, на который Вы получите полис страхования
            </div>
            <div class="calc right_info">
                <div class="calc error email"></div>
                <input class="calc field input_text unactive email" type="text" title="электронная почта" name="e-mail"
                       value="электронная почта" onfocus="inputfocus(this);" onblur="inputblur(this);"
                       onclick="inputclick(this);"/>

                <div class="calc error phone"></div>
                <input class="calc field input_text unactive phone" type="text" title="ваш телефон" name="phone"
                       value="ваш телефон" onfocus="inputfocus(this);" onblur="inputblur(this);"
                       onclick="inputclick(this);"/>


            </div>
        </div>

        <div class="calc_page3_bottom_line">
            <div class="calc error all"></div>
            <input class="calc button" type="button" id="issue" value="Оформить"/>
            </form>

        </div>
    </div>
    <div class="calc_page3_bottom" id="calc_page3_subpage2" style="display:none">
        <div class="calc_page3_bottom_head">Заказать Полис для выезжающих за рубеж</div>
        <div class="calc agreement left">Ознакомьтесь, пожалуйста, с текстом Пользовательского соглашения <a onclick="$('#agreement_block').show();">здесь</a> и поставьте «галочку» в поле для принятия условий соглашения</div>
        <div class="calc agreement right"><input type="checkbox" id="agreement_check"/><label for="agreement_check"
                                                                                              onclick="checkAgr(this);"></label>
        </div>
        <div class="calc payment_icon"></div>
        <p class="calc payment_info">Нажав кнопку «Далее», Вы будете перенаправлены на страницу платежной системы. После оплаты дождитесь перехода на страницу оформления РСО Евроинс</p>

        <div class="calc_page3_bottom_line">
            <form onsubmit="return false; " method="get">
                <div class="calc error all"></div>
                <input class="calc button" type="submit" id="next" value="Далее"/>


            </form>
        </div>
        <div id="agreement_block">
			<p>Настоящим в порядке ч.2 ст.434 Гражданского кодекса Российской Федерации подтверждаю достижение соглашения сторон о признании договора страхования заключенным в письменной форме посредством электронной связи.</p>
			<p>Действуя от своего имени и в своем интересе как страхователь, подтверждаю, что надлежащим образом ознакомлен и согласен с текстом и условиями «<a target="_blank" href="http://euro-ins.ru/files/pravila_vzr.doc">Правил комплексного страхования граждан, выезжающих с места постоянного проживания</a>» (от 15.05.2013 г., адрес в Интернете: http://euro-ins.ru/files/pravila_vzr.doc), в подтверждение чего заключаю настоящий договор, текст указанных правил страхования получил. Руководствуясь ч.2 ст. 160 Гражданского кодекса Российской Федерации, подтверждаю достижение соглашения сторон о допустимости использования факсимильного воспроизведения подписей и оттисков печатей с помощью средств копирования. В соответствии с Федеральным законом «О персональных данных» от 27.07.2006 N 152-ФЗ предоставляю свое согласие на обработку персональных данных включая все операции с персональными данными предусмотренные п.З ст.З закона на срок действия договора страхования и в течение 5 (пяти) лет с даты его прекращения».</p>
			<p>Также подтверждаю, что  ознакомлен и согласен с текстом и условиями <a target="_blank" href="http://www.euro-ins.ru/files/public_offer.docx">Публичной оферты</a> о порядке заключения ООО «РСО «ЕВРОИНС» договоров комбинированного страхования граждан, выезжающих с места постоянного проживания (адрес в Интернете: http://www.euro-ins.ru/files/public_offer.docx).</p>
            <div class="bird">
                <a id="bird_to_page3" onclick="$('#agreement_block').hide();"></a>
            </div>
        </div>

    </div>
</div>

</div>
<?php
$today = date("d/m/Y");
 $fp = fopen('cb.xml', 'w');
 $ch = curl_init();
curl_setopt($ch, CURLOPT_URL,
      'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.$today);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_exec($ch);
fclose($fp);
curl_close ($ch);
?>
</body>
</html>
