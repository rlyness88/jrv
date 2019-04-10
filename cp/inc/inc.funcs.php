<?
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

//***************include classes
require 'classes/class.const.php';
//******************************

function __autoload($n) {
    include 'classes/class.'.$n.'.php';
}

function CheckReferer($ref) {
    if (strpos($ref, 'home.rlyness.co.uk') === false || ref == null) {
        exit;
    }
}

function split_name($string) {
    $arr = explode(' ', $string);
    $num = count($arr);
    $first_name = $middle_name = $last_name = null;

    if ($num == 2) {
        list($first_name, $last_name) = $arr;
    } else {
        list($first_name, $middle_name, $last_name) = $arr;
    }

    return (empty($first_name) || $num > 3) ? false : compact(
        'first_name', 'middle_name', 'last_name'
    );
}

function incFavIcon() {
    //https://realfavicongenerator.net
    ?><link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicons/favicon-16x16.png">
    <link rel="manifest" href="img/favicons/site.webmanifest">
    <link rel="mask-icon" href="img/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="img/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff"><?
}

function writeLog($m, $file = 'outputLog.txt') {

    $t = date("d-m H:i", time());

    $file = fopen('logs/'.$file, "a");
    fwrite($file, $t.'| '.$m."\r\n");
    fclose($file);
}

function Since($time, $def) {
    switch ($time) {

        // less than a minute
        case ($time >= 0) && ($time <= 60):
            return "just now";
            break;

        //1-59 min
        case ($time >= 61) && ($time <= 3540):
            $out = round($time / 60,0);
            if ($out > 1) {
                return $out." minutes ago";
            }
            else {
                return $out." minute ago";
            }
            break;

        //1-23 hour
        case ($time >= 3541) && ($time <= 82800):
            $out =  round(($time / 60) / 60,0);
            if ($out > 1) {
                return $out." hours ago";
            }
            else {
                return $out." hour ago";
            }
            break;

        // 1-30 days
        case ($time >= 82801) && ($time <= 2592000):
            $out =  round((($time / 60) / 60) / 24,0);
            if ($out > 1) {
                return $out." days ago";
            }
            else {
                return $out." day ago";
            }
            break;

        default:
            // more than 30 days ago, display date
            return date("d-M-Y @ H:i", $def);
            break;
    }
}