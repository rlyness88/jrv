<?
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
use Twilio\Rest\Client;

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

function RedirectHttps() {
    if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' ||
            $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
    {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

function writeLog($m, $file = 'outputLog.txt') {

    $t = date("d-m H:i", time());

    $file = fopen('logs/'.$file, "a");
    fwrite($file, $t.'| '.$m."\r\n");
    fclose($file);
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

function SendSMSMessage($tonumber, $toname, $message, $yesToConfirm = false) {

    // If PAYMENTS SYSTEM IS LIVE
    if (Constants::SMSLIVE) {

        /*list($scriptPath) = get_included_files();
        echo $scriptPath;*/

        // CAPTURE FIRSTNAME FROM THE FULLNAME
        $toname = split_name($toname)['first_name'];

        // LOAD THE TWILIO LIBRARY
        require_once 'res/twilio/Twilio/autoload.php';
        // CREATE A NEW TWILIO OBJECT FROM CLASS
        $twilio = new Client(Constants::SID, Constants::TOKEN);

        // BUILD THE BODY
        $body = ($yesToConfirm) ? "[Jake Russell Valet] Hi $toname, " . $message . ' Reply YES to confirm' : "[Jake Russell Valet] Hi $toname, " . $message;

        // CALL THE CREATE METHOD ON THE OBJECT
        $message = $twilio->messages
            ->create($tonumber,
                array(
                    "from" => Constants::FROM,
                    "body" => $body
                )
            );

        // RETURN THE UNIQUE ID OF THE MESSAGE
        return $message->sid;
    }
}