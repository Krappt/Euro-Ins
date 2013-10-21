<!DOCTYPE html>
<html>
<head>
    <base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/calc/accident/"; ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Страхование от несчастного случая и болезни</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script language='javascript'>
        var globalDate = new Date();
       realtime =<?php echo time();?>;
        setInterval("realtime++", 1000);
        globalDate = new Date(realtime * 1000);
    </script>
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../postmessage.js"></script>
    <script src="js/data.js"></script>
    <script src="js/date.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
<div id="calc">
    <div id="page1" class="page">
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
        <div class="title2">Цель программ страхования от несчастных случаев – это финансовая поддержка в трудных жизненных ситуациях,
            связанных с изменением состояния Вашего здоровья и здоровья Ваших близких.</div>

        <p>Страховые выплаты компенсируют финансовые расходы на лечение и последующую реабилитацию, а также окажут
            поддержку в критических ситуациях.</p>
    </div>
    <div id="page2" class="page">
    <div id="page2Top">
            <div class="title">Страхование от несчастного случая и болезней</div>
                 <div class="title2">Теперь Вы можете защитить себя и своих близких от возможных финансовых потреть, произошедших
                     из-за несчастного случая или болезни.
                 </div>
                 <div class="title2">Пробрести полис онлайн можно всего за 5 минут, не выходя из дома.</div>
                 <div class="title3">Выберите программу страхования:</div>
                 <div class="buttonBlock">
                     <div class="buttonLink insurance1 page2buttons">
                         <div class="multiLine"><span>Страховая сумма </span><span id="page2InsuranceSum1" class="sums"></span><br/>
                             <span>Стоимость полиса </span><span id="page2cost1" class="sums"></span></div>
                     </div>
                 </div>
                 <div class="buttonBlock">
                     <div class="buttonLink insurance2 page2buttons">
                         <div class="multiLine"><span>Страховая сумма </span><span id="page2InsuranceSum2" class="sums"></span><br/>
                             <span>Стоимость полиса </span><span id="page2cost2" class="sums"></span></div>
                     </div>
                 </div>
                 <div id="addSportLine">
                 <span class="birdMini" id="sportBird"></span><a id="addSportButton">добавить спорт</a><span> - Полис для спортсменов-любителей</span>
                 </div>

    </div>
    <div id="page2Bottom">
            <div id="page2MainHint" class="hint2"></div>

            <div class="title2 textBold">Программа включает защиту от рисков:</div>
            <div>
                <ul id="riskList" class="title2">
                </ul>
            </div>
    </div>
    </div>
    <div id="page2dot1" class="page">
        <div id="page2dot1Inside">
        <div class="title3">Краткосрочный полис для спортсменов-любителей</div>
        <div class="title3">Выберите вид спорта</div>
        <div id="sportList">
           <div id="sportListLeft">
           </div>
           <div id="sportListRight">
           </div>
           <div style="clear:both"></div>
        </div>
        <div class="bird">
            <a id="endChooseSports"></a>
        </div>
        </div>

    </div>
    <form method="POST" class="fieldGroup" action="handler.php" id="sendRequest">
        <div id="page3" class="page">
            <div id="page3Top">
                  <div class="title3">Ваша страховая программа:</div>
                               <div><span>Страховая сумма - </span><span id="insuranceSum" class="title2"></span></div>
                               <div><span id="riskStroke"> </span></div>
                               <div>Спорт: <span id="sportStroke"> Без занятий спортом.</span></div>
                               <div id="finalCostWrap" class="title2"><span>Стоимость страхования: </span><span id="insuranceCost"> </span>
                               <input type="hidden" name="insuranceSum"/>
                               <input type="hidden" name="insuranceCost"/>
                               <input type="hidden" name="sport"/>
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
        <div id="page4" class="page">
            <div id="page4Top">
                <table cellspacing="10">
                    <tr>
                        <td>
                            <div id="insuredFullName" class="title3 personNames"></div>
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
                <div class="title3">Страхователь (лицо старше 18 лет, оплачивающее полис)</div>

                <div class="isInsurerCheckBoxGroup">
                    <input type="checkbox" id="isInsurer" class="checkBoxNormal" checked/>
                    <label for="isInsurer" class="selected">Зарегистрированный является страхователем (если Вы страхуетесь сами)</label>
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
                        <input type="checkbox" id="agreement" class="checkBoxNormal"/>
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
						<p>Я, являясь Страхователем / Застрахованным по Договору, подтверждаю, что Застрахованный<ol>
							<li>В настоящее время НЕ проходит службу в вооруженных силах, не участвует в военных сборах, НЕ занят в профессиональной или непрофессиональной авиации, вооруженной и/или персональной охране, в работах с химическими и взрывчатыми веществами, работах на высоте, под землей, под водой, на нефтяных и газовых платформах, с оружием и др. источниками повышенной опасности; НЕ является водолазом, пожарным, скалолазом, работником ядерной промышленности и спортсменом, НЕ находится в изоляторе временного содержания или других учреждениях, предназначенных для содержания лиц, подозреваемых или обвиняемых в совершении преступлений;</li>
							<li>НЕ занимается горными лыжами, сноубордингом, автоспортом, мотоспортом, аэроспортом, дайвингом, виндсерфингом, фигурным катанием, прыжками с парашютом, спортивной борьбой, боевыми искусствами, парусным спортом, экстремальными видами спорта.<br/>Страховыми признаются события, если они наступили в результате занятий видами спорта, указанными в полисе страхования.</li>
							<li>Ранее и в настоящее время НЕ имел группы инвалидности, врожденных аномалий, НЕ является носителем ВИЧ, больным СПИДом, Гепатитом С; НЕ консультировался, НЕ лечился и НЕ находился под арестом, НЕ употребляет наркотики, токсические вещества с целью токсического опьянения, НЕ страдает алкоголизмом;</li>
							<li>НЕ страдает психическими заболеваниями и их осложнениями; тяжелыми формами заболевания сердечнососудистой системы (ишемическая болезнь сердца, гипертония, врожденные пороки сердца, ревматизм, аневризмы сердца и сосудов, коронарно-артериальные заболевания, кардиосклероз с явлениями недостаточности кровообращения); заболеванием нервной системы (цереброваскулярные заболевания, рассеянный склероз, болезнь Альцгеймера); сахарным диабетом (I и II типа); эпилепсией, рассеянным склерозом; кондуктивной и нейросенсорной потерей слуха врожденной и наследственной патологией; тяжелыми нарушениями опорно-двигательного аппарата; обострениями профессиональных или хронических заболеваний, возникших у Застрахованных лиц до заключения Договора страхования;</li>
							<li>Я, Застрахованный, подтверждаю свое согласие с назначением Выгодоприобретателей на случай смерти по данному договору.</li>
						</ol></p>

						<p>Подписывая настоящий Полис страхования, Я подтверждаю достоверность представленных сведений и информирован о том, что предоставление мной неполных и/или ложных сведений, равно, как и отказ в предоставлении информации, является умышленным предоставлением заведомо ложной информации, что может повлечь за собой признание Договора страхования недействительным, при этом Страховщик освобождается от обязательств по данному полису и все произошедшие события будут являться не страховыми. Я заявляю, что я получил полную информацию об условиях страховой программы, предусмотренной настоящим Договором.<br/>Действуя от своего имени и в своем интересе как Страхователь, подтверждаю, что надлежащим образом ознакомлен и согласен с текстом и условиями «Правил» (утвержденными 26 мая 2013 года), в подтверждение чего заключаю настоящий договор, текст указанных правил страхования получил. В соответствии с Федеральным законом «О персональных данных» от 27.07.2006 N 152-ФЗ предоставляю свое согласие на обработку персональных данных, включая все операции с персональными данными предусмотренные п.3 ст.3 закона на срок действия договора страхования и в течение 10 (десяти) лет с даты его прекращения.</p>
						<p>Разрешаю любому медицинскому работнику или учреждению, имеющему информацию о моей истории болезни или истории болезни Застрахованного, физическом и психическом состоянии здоровья, предоставлять ее в случае необходимости страховой компании ООО РСО «ЕВРОИНС». Настоящим в порядке ч.2 ст.434 Гражданского кодекса Российской Федерации подтверждаю достижение соглашения сторон о признании договора страхования заключенным в письменной форме посредством электронной связи.<br/>Руководствуясь ч.2 ст.160 Гражданского кодекса Российской Федерации, подтверждаю достижение соглашения сторон о допустимости использования факсимильного воспроизведения подписей и оттисков печатей с помощью средств копирования.</p>

                        <div class="bird">
                            <a class="closePopUp popUpAgreement"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>