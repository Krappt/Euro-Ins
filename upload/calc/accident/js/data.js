/*!
 *Скрипт с JSON данными для сценария №1 и сценария №2, а так же объект с текстовым описанием ошибок
 *
 *№1 - программа страхования для детей
 *№2 - программа страхования для себя
 */

var scenarioForChildren = {
    page2: {
        insuranceSum1: "100 000 руб.",
        cost1: "950 руб.",
        insuranceSum2: "250 000 руб.",
        cost2: "1500 руб.",
        stringTip: "По программе могут быть застрахованы дети в возрасте от 1 года до 17 лет",
        stringsList: [
            "Телесные повреждения - выплата до 100%  в зависимости от тяжести повреждения.",
            "Переломы и ожоги - выплата до 100% от страховой суммы.",
            "Инвалидность в категории «ребенок-инвалид» в результате несчастного случая - выплата всей страховой суммы."
        ]
    },
    page3: {
        riskStroke: "Покрывает Ваши риски в результате телесных повреждений, переломов и ожогов,  инвалидности в категории «ребенок-инвалид», полученных в результате несчастного случая.",
        ageRange: "(от 1 года до 17 лет)"
    }
};

var scenarioForHimself = {
    page2: {
        insuranceSum1: "100 000 руб.",
        cost1: "750 руб.",
        insuranceSum2: "250 000 руб.",
        cost2: "1500 руб.",
        stringTip: "По программе могут быть взрослые в возрасте от 18 до 64 лет",
        stringsList: [
            "Телесные повреждения - выплата до 100% в зависимости от тяжести повреждения.",
            "Переломы и ожоги - выплата до 100% от страховой суммы.",
            "Инвалидность I ст.  в результате несч. случая - 100% от страховой суммы.",
            "Инвалидность II ст. в результате несч. случая  - 75% от страховой суммы.",
            "Инвалидность III ст. в результате несч. случая  - 50% от страховой суммы.",
            "Смерть в результате несчастного случая - выплата всей страховой суммы"
        ]
    },
    page3: {
        riskStroke: "Покрывает Ваши риски в результате телесных повреждений, переломов и ожогов,  инвалидности I, II и III групп, смерти,  полученных в результате несчастного случая.",
        ageRange: "(от 18 до 64 лет)"
    }
};

var sportList = [
    "Альпинизм в зале",
    "Бальные танцы",
    "Баскетбол",
    "Беговые лыжи",
    "Бейсбол",
    "Боулинг",
    "Водное поле",
    "Волейбол",
    "Гребля",
    "Езда на велосипеде (кроме триала и скоростного спуска)",
    "Йога",
    "Картинг",
    "Катание на коньках",
    "Керлинг",
    "Легкая атлетика",
    "Летняя рыбалка",
    "Пейнтбол",
    "Пешие походы без применения альпинистского снаряжения",
    "Плавание в бассейне",
    "Спортивное ориентирование",
    "Спортивные танцы",
    "Стрельба из лука",
    "Теннис",
    "Фехтование",
    "Фитнес",
    "Хождение на яхте вдоль берега",
    "Хореография"
]

var errors = {
    cyrillic: "Введите кириллицей",
    scenario1InsuranceBirthday: "Возраст от 1 до 17 лет включительно",
    scenario2InsuranceBirthday: "Возраст от 18 до 64 лет включительно",
    insuredIssueDocument: "Дата позднее текущего дня",
    page3GlobalError: "Заполните все поля",
    email: "Введите корректный e-mail",
    phone: "Введите корректный номер телефона",
    empty: "Поле не должно быть пустым",
    lastError: "Для продолжения необходимо заполнить все поля и согласиться с условиями соглашения"
};