<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// phpinfo();

$parentDir = dirname(getcwd()) . "/";

    include($_SERVER["DOCUMENT_ROOT"] . "/functions.php");

    include($_SERVER["DOCUMENT_ROOT"] . "/views/header.php");

    include($_SERVER["DOCUMENT_ROOT"] . "/views/explore.php");

    include($_SERVER["DOCUMENT_ROOT"] ."/views/footer.php");
?>