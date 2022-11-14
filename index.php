<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    include("functions.php");


    if (isset($_GET["c"])) {
        $shortcode = $_GET["c"];
        // if (isset($_COOKIE["redirects"]) {
        //     $redirects = json_decode($_COOKIE["redirects"]);
        //     if (array_key_exists($_GET["c"], $redirects)) {
        //         header("Location: " . $redirects[$_GET["c"]]);
        //         die();
        //     }
        // }
        
        $query = "SELECT * FROM `short_urls` WHERE `short_code`='" . $shortcode . "' LIMIT 1";
        $result = mysqli_query($link, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            header("Location: " . $row["long_url"]);
            // $urlToCache = json_encode(array($shortcode => $row["long_url"]));
            // setcookie("redirects", $urlToCache, time() + (10 * 365 * 24 * 60 * 60));
        } else {
            header("Location: /");
        }

    }

    include("views/header.php");

    include("views/home.php");

    include("views/footer.php");
?>