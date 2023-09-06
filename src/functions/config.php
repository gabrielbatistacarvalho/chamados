<?php

$envs = parse_ini_file('.env');

foreach ($envs as $key => $value) {
    define($key, $value);
}

define('NOW', date('H:i:s'));
define('TODAY', date('Y-m-d'));
define('YEAR', date('Y'));
define('LINKANEXO', "https://chamados.gabrielcarvalho.site/anexos/");

?>