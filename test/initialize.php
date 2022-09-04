<?php
define("TEST",true);

define("SESSION_STORER_DEFAULT_SESSION_NAME","session");
define("SESSION_STORER_COOKIE_NAME_SESSION","%session_name%");
define("SESSION_STORER_COOKIE_NAME_CHECK","check");
define("SESSION_STORER_SESSION_MAX_LIFETIME",60 * 60 * 24 * 1);  // a day
define("CURRENT_TIME",time());

require("../vendor/autoload.php");
require("../vendor/atk14/dbmole/test/connections_and_handler.php");

// rectreating database structures
$dbmole = PgMole::GetInstance();
$dbmole->doQuery(file_get_contents(__DIR__."/drop_structures.postgresql.sql"));
$dbmole->doQuery(file_get_contents(__DIR__."/../src/structures.postgresql.sql"));

$HTTP_REQUEST = new HTTPRequest();
$HTTP_RESPONSE = new HTTPResponse();

$HTTP_REQUEST->setRemoteAddr("127.0.0.1");
