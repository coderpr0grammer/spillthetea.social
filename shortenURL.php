<?
// Include database configuration file
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER["DOCUMENT_ROOT"] ."/functions.php";

$longURL = $_POST["longURL"];

$query = "SELECT * FROM `short_urls` WHERE `long_url`='" . $longURL . "'";
$result = mysqli_query($link, $query);
$codeLength = 7;



if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo $row["short_code"];
} else {
    $shortURL = generateRandomString();
    $query2 = "INSERT INTO `short_urls` (`long_url`, `short_code`, `hits`) VALUES('" . $longURL . "', '" . $shortURL . "', 0)";
    if ($result = mysqli_query($link, $query2)) {
        echo "https://spillthetea.social/".$shortURL;
    } else {
        echo 0;
    }

}





function generateRandomString($length = 7){
    $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
        $sets = explode('|', $chars);
        $all = '';
        $randString = '';
        foreach($sets as $set){
            $randString .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++){
            $randString .= $all[array_rand($all)];
        }
        $randString = str_shuffle($randString);
        return $randString;
    }

?>