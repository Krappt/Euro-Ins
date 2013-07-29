<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'acbgrou2_euroins');

/** Имя пользователя MySQL */
define('DB_USER', 'acbgrou2_euroins');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '1111');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':|sEC/lXvd|/>S>:-:p(F,}^O?M0LX?|{njPZ?wV, Uva!/|%$S|__c4V4 })zZ{');
define('SECURE_AUTH_KEY',  'OE=!b9/({JuO~_KzCjMi`z-s!|*+vyt`B(S{eS.VS8VJD&pnusrc)sj`neF9M8?M');
define('LOGGED_IN_KEY',    ']_!]E|/hbdtn<O&#%Xp]GlGA[!{h6~T*D~--F:(CBy-cfOvh#8w3>[=86zDtfEKv');
define('NONCE_KEY',        'TuHOmFYXBWR&Qnb||X ~3<a~-s|*Ly2AH#|kN7`|wQnss-A#8@S!u/<+T~+ui/iR');
define('AUTH_SALT',        '(<Y.<Vy+><P-?hl/ ha#Rt%M7fT%m~y`NA/zIMmhL<bA?T9a:D1JSz659-;>vzh/');
define('SECURE_AUTH_SALT', '0GTNQ):S{c]|_1i@|{#A+<cmA#{^N+l<<.7][mlLK@l3mDg}!TLjc-`/WVV N&JQ');
define('LOGGED_IN_SALT',   'i%i#[Du@@<;K w^GDb_IJE)SW@J.#&>)i28M@|%5c|`8!@ lb4%=q25s`sQDlh7|');
define('NONCE_SALT',       'd=CEj+^6A+Bw1;9!W%lyD19 up-dk/BdfobKj^~J}N/Lne/@`ZN#$:eK$B?.qPAX');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Язык локализации WordPress, по умолчанию английский.
 *
 * Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
 * для выбранного языка должен быть установлен в wp-content/languages. Например,
 * чтобы включить поддержку русского языка, скопируйте ru_RU.mo в wp-content/languages
 * и присвойте WPLANG значение 'ru_RU'.
 */
define('WPLANG', 'ru_RU');

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
