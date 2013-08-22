<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Страхование от несчастного случая и болезни</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script language='javascript'>
        var globalDate = new Date();
       realtime =<?php echo time();?>;
        setInterval("realtime++", 1000);
        globalDate = new Date(realtime * 1000);
    </script>
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/data.js"></script>
    <script src="js/date.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
<div id="calc">
    <div id="page1">
        <div class="title">Страхование от несчастного случая и болезней</div>
        <div class="title2">Теперь Вы можете защитить себя и своих близких от возможных финансовых потреть, произошедших
            из-за несчастного случая или болезни.
        </div>
        <div class="title2">Пробрести полис онлайн можно всего за 5 минут, не выходя из дома.</div>
        <div class="title3">Выберите программу страхования:</div>
        <div class="buttonBlock">
            <div class="buttonLink forChildren page1buttons">
                <div class="singleLine">для детей</div>
            </div>
            <span class="hint">от 1 года до 17 лет</span>
        </div>
        <div class="buttonBlock">
            <div class="buttonLink forHimself page1buttons">
                <div class="singleLine">для себя</div>
            </div>
            <span class="hint">от 18 до 64 лет</span>
        </div>
        <p>Цель программ страхования от несчастных случаев – это финансовая поддержка в трудных жизненных ситуациях,
            связанных с изменением состояния Вашего здоровья и здоровья Ваших близких.</p>

        <p>Страховые выплаты компенсируют финансовые расходы на лечение и последующую реабилитацию, а также окажут
            поддержку в критических ситуациях.</p>
    </div>
    <div id="page2">
        <div class="title">Страхование от несчастного случая и болезней</div>
        <div class="title2">Теперь Вы можете защитить себя и своих близких от возможных финансовых потреть, произошедших
            из-за несчастного случая или болезни.
        </div>
        <div class="title2">Пробрести полис онлайн можно всего за 5 минут, не выходя из дома.</div>
        <div class="title3">Выберите программу страхования:</div>
        <div class="buttonBlock">
            <div class="buttonLink insurance1 page2buttons">
                <div class="multiLine"><span>Страховая сумма </span><span id="page2InsuranceSum1"></span><br/>
                    <span>Стоимость полиса </span><span id="page2cost1"></span></div>
            </div>
        </div>
        <div class="buttonBlock">
            <div class="buttonLink insurance2 page2buttons">
                <div class="multiLine"><span>Страховая сумма </span><span id="page2InsuranceSum2"></span><br/>
                    <span>Стоимость полиса </span><span id="page2cost2"></span></div>
            </div>
        </div>
        <span id="hint page2MainHint"></span>

        <div class="title3">Программа включает защиту от рисков:</div>
        <div>
            <ul id="riskList">
            </ul>
        </div>
    </div>
    <form method="POST" class="fieldGroup" action="handler.php" id="sendRequest">
        <div id="page3">
            <div id="page3Top">
                <div class="title3">Ваша страховая программа:</div>
                <div><label for="insuranceSum">Страховая сумма - </label><input name="insuranceSum" type="text" id="insuranceSum" class="readOnlyField title2" disabled="disabled"/></div>
                <div><span id="riskStroke"> </span></div>
                <div id="finalCostWrap">
                    <label class="title2" for="insuranceCost">Стоимость страхования: </label><input name="insuranceCost" id="insuranceCost" class="readOnlyField title3 policyCost"  disabled="disabled"/>
                </div>
            </div>
            <div id="page3Middle">
                <div class="title3"><span>Застрахованный </span><span id="ageRange"> </span></div>

                <div class="inputGroupLeft">
                    <div class="fieldLine">
                        <span class="error"></span>
                        <input name="insuredLastName" type="text" class="field fieldNames" title="фамилия"/>
                    </div>
                    <div class="fieldLine">
                        <span class="error"></span>
                    <input name="insuredFirstName" type="text" class="field fieldNames" title="имя"/>
                    </div>
                    <div class="fieldLine">
                        <span class="error"></span>
                        <input name="insuredPatronymic" type="text" class="field fieldNames" title="отчество"/>
                    </div>

                    <div class="dateGroup">
                        <span class="error"></span>
                        <input type="hidden" name="insuredBirthday" title="дата рождения"/>

                        <div class="dateSplit dateSplitInsuredBirthday">
                            <div class="dateSplitDay">
                                <select title="день рождения" class="dateSplitDays" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitMonth">
                                <select title="месяц рождения" class="dateSplitMonths" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitYear">
                                <select title="год рождения" class="dateSplitYears" onchange="onDateChange(this)">

                                </select>
                            </div>
                        </div>
                        <span class="subtext">дата рождения</span>
                    </div>
                </div>
                <div class="inputGroupRight">
                    <div class="radioGroup">
                        <div class="radioGroupLine">
                            <input name="selectDocument" type="radio" id="passport" value="passport" checked/>
                            <label for="passport" class="radio">паспорт</label>
                        </div>
                        <div class="radioGroupLine">
                            <input name="selectDocument" type="radio" id="birthCertificate" value="birthCertificate"/>
                            <label for="birthCertificate" class="radio">свидетельство о рождении</label>
                        </div>
                    </div>
                    <div class="doubleFields">
                        <div class="fieldLine">
                            <span class="error"></span>
                            <input name="insuredDocumentSeries" type="text" class="field fieldFirst" title="серия"/>
                            <input name="insuredDocumentNumber" type="text" class="field fieldSecond" title="номер"/>
                        </div>

                    </div>
                    <div class="fieldLine">
                        <input name="insuredIssuingAuthority" type="text" class="field" title="кем выдан(о)"/>
                        <span class="error"></span>
                    </div>
                    <div class="dateGroup">
                        <input type="hidden" class="insuredIssueDocument" name="insuredIssueDate" title="дата выдачи"/>
                        <span class="error"></span>
                        <div class="dateSplit dateSplitInsuredIssueDocument">
                            <div class="dateSplitDay">
                                <select title="день выдачи" class="dateSplitDays" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitMonth">
                                <select title="месяц выдачи" class="dateSplitMonths" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitYear">
                                <select title="год выдачи" class="dateSplitYears" onchange="onDateChange(this)">

                                </select>
                            </div>
                        </div>
                        <span class="subtext">дата выдачи документа</span>
                    </div>

                </div>
            </div>
            <div id="page3Bottom">
                <div class="title3">Начало действия полиса</div>
                <div class="dateGroup">
                    <input type="hidden" class="startPolicy" name="startPolicy"/>
                    <input type="hidden" class="endPolicy" name="endPolicy"/>
                    <span class="error"></span>
                    <div class="dateSplit dateStartPolicy">
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
                    <span class="subtext">начало действия</span>
                </div>
                <div class="buttonGroup">
                    <span class="error globalError"></span>
                    <input class="button goToPage4" type="button" value="Далее"/>
                </div>

            </div>
        </div>
        <div id="page4">
            <div id="page4Top">
                <table>
                    <tr>
                        <td>
                            <div id="insuredFullName" class="title3"></div>
                            <div><span>застрахованный, </span><span id="insuredAge"></span></div>
                        </td>
                        <td>
                            <div id="startPolicy" class="title3"></div>
                            <div>начало действия полиса</div>
                        </td>
                        <td>
                            <div id="endPolicy" class="title3"></div>
                            <div>окончание действия полиса</div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div id="insuranceSumText" class="title3"></div>
                            <div>страховая сумма</div>
                        </td>
                        <td>
                            <div id="policyCost" class="policyCost"></div>
                            <div>стоимость полиса</div>
                        </td>
                    </tr>
                </table>
                <div>Электронный полис будет выписан в формате PDF</div>
            </div>
            <div id="page4Middle">
                <div class="title3">Страхователь (лицо старше 18 лет, опалчивающее полис)</div>

                <div class="isInsurerCheckBoxGroup">
                    <input type="checkbox" id="isInsurer" checked/>
                    <label for="isInsurer">Зарегистрированный является страхователем (если Вы страхуетесь сами)</label>
                </div>

                <div class="inputGroupLeft">
                    <div class="fieldLine">
                        <span class="error"></span>
                        <input name="insurerLastName" type="text" class="field fieldNames" title="фамилия"/>
                    </div>
                    <div class="fieldLine">
                        <span class="error"></span>
                        <input name="insurerFirstName" type="text" class="field fieldNames" title="имя"/>
                    </div>
                    <div class="fieldLine">
                        <span class="error"></span>
                        <input name="insurerPatronymic" type="text" class="field fieldNames" title="отчество"/>
                    </div>

                    <div class="dateGroup">
                        <span class="error"></span>
                        <input type="hidden" name="insurerBirthday" class="insurerBirthday" title="дата рождения"/>

                        <div class="dateSplit dateSplitInsurerBirthday">
                            <div class="dateSplitDay">
                                <select title="день рождения" class="dateSplitDays" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitMonth">
                                <select title="месяц рождения" class="dateSplitMonths" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitYear">
                                <select title="год рождения" class="dateSplitYears" onchange="onDateChange(this)">

                                </select>
                            </div>
                        </div>
                        <span class="subtext">дата рождения</span>
                    </div>
                </div>
                <div class="inputGroupRight">
                    <div class="doubleFields">
                        <div class="fieldLine">
                            <span class="error"></span>
                            <input name="insurerPassportSeries" type="text" class="field fieldFirst" title="серия"/>
                            <input name="insurerPassportNumber" type="text" class="field fieldSecond" title="номер"/>
                        </div>

                    </div>
                    <div class="fieldLine">
                        <input name="insurerPassportIssuingAuthority" type="text" class="field" title="кем выдан(о)"/>
                        <span class="error"></span>
                    </div>
                    <div class="dateGroup">
                        <input type="hidden" class="insurerIssueDocument" name="insurerIssueDate" title="дата выдачи"/>
                        <span class="error"></span>
                        <div class="dateSplit dateSplitInsurerIssueDocument">
                            <div class="dateSplitDay">
                                <select title="день выдачи" class="dateSplitDays" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitMonth">
                                <select title="месяц выдачи" class="dateSplitMonths" onchange="onDateChange(this)">

                                </select>
                            </div>
                            <div class="dateSplitYear">
                                <select title="год выдачи" class="dateSplitYears" onchange="onDateChange(this)">

                                </select>
                            </div>
                        </div>
                        <span class="subtext">дата выдачи паспорта</span>
                    </div>
                </div>
                <div class="inputGroupBottom">
                    <div class="inputGroupBottomLeft">
                        Необходимо указать Ваш телефон и e-mail на который Вы получите полис страхования
                    </div>
                    <div class="inputGroupBottomRight">
                        <div class="fieldLine">
                            <span class="error"></span>
                            <input name="insurerEmail" type="text" class="field fieldEmail" title="электронная почта"/>
                        </div>
                        <div class="fieldLine">
                            <span class="error"></span>
                            <input name="insurerPhone" type="text" class="field fieldPhone" title="ваш телефон"/>
                        </div>
                        </div>
                </div>

            </div>
            <div id="page4Bottom">
                <div id="agreementGroup">
                    <div id="agreementGroupLeft">Ознакомьтесь, пожалуйста, с текстом Пользовательского соглашения <a class="openPopUp popUpAgreement">здесь</a> и поставьте «галочку» в поле для принятия условий соглашения</div>

                    <div class="agreementCheckBoxGroup">
                        <input type="checkbox" id="agreement"/>
                        <label for="agreement"></label>
                    </div>
                </div>
                <div id="centerGroup">
                    <div class="paymentIcon"></div>

                    <input class="button send" type="button" value="Далее"/>
                </div>

                <div class="error globalError"></div>

                <div>
                    Нажав кнопку «Далее», Вы будете переадресованы на страницу платежной системы. После оплаты дождитесь перехода на оформления РСО Евроинс
                </div>
                <div class="popUpOutside" id="popUpAgreement">
                    <div class="popUpBg"></div>
                    <div class="popUpInside">
                        <p>Настоящим в порядке ч.2 ст.434 Гражданского кодекса Российской Федерации подтверждаю достижение
                            соглашения сторон о признании договора страхования заключенным в письменной форме посредством
                            электронной связи.</p>

                        <p>Действуя от своего имени и в своем интересе как страхователь, подтверждаю, что надлежащим образом
                            ознакомлен и согласен с текстом и условиями «Правил страхования медицинских расходов при выезде за
                            границу» (утвержденными 13.05.2010г.), в подтверждение чего заключаю настоящий договор, текст указанных
                            правил страхования получил. Руководствуясь ч.2 ст. 160 Гражданского кодекса Российской Федерации,
                            подтверждаю достижение соглашения сторон о допустимости использования факсимильного воспроизведения
                            подписей и оттисков печатей с помощью средств копирования. В соответствии с Федеральным законом «О
                            персональных данных» от 27.07.2006 N 152-ФЗ предоставляю свое согласие на обработку персональных данных
                            включая все операции с персональными данными предусмотренные п.З ст.З закона на срок действия договора
                            страхования и в течение 5 (пяти) лет с даты его прекращения».
                        </p>

                        <div class="bird">
                            <a class="closePopUp popUpAgreement"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="page5">
        <div id="page5Top"></div>
        <div id="page5Middle">
            <div class="title3 requestNumber">Заказ № <span>10395946-0001</span> успешно оплачен!
            </div>
            <div class="title2">Ваш элетронный страховой полис будет сформирован автоматически в течение
                10-минут и направлен на указанный email
            </div>
            <div class="bird fill"></div>
        </div>
        <div id="page5Bottom">
            <div>
                По любым вопросам Вы можете обратиться в нашу службу клиентской поддержки по телефону +7 (495) 926-51-55
                ежедневно с 09:00 до 18:00 по московскому времени
            </div>
        </div>
    </div>
</div>
</body>
</html>