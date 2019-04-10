<?
use Twilio\Rest\Client;

require 'inc/inc.funcs.php';
$db = new db();
session_start();
if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    $token->CheckReferer($_SERVER['HTTP_REFERER']);
}

//TODO: ALWAYS CHECK TOKEN??

switch ($_GET['z']) {

    case 'GetCalendarItems':

        $token->CheckToken($_POST['token'], true);

        $items = $db->select('spGetCalendarItems');
        echo json_encode($items);

        break;

    case 'SendTestSMS':

        $to = '+447729209351';
        $toname = 'Russ';
        $message = 'Don\'t forget your appointment!!';

        $sd = SendSMSMessage($to, $toname, $message);

        if (!empty($sd)) {
            $db->insert('spSaveSentSMS', array($to, $message, $sd));
        }

        echo "message sent: $sd";

        break;

    case 'SendTestWhatsapp':

        // Update the path below to your autoload.php,
        // see https://getcomposer.org/doc/01-basic-usage.md
        require_once 'res/twilio/Twilio/autoload.php';

        $sid    = "AC07773044320c1f0b2637961731e0ede1";
        $token  = "e6b94f306010db130d5436191bdf8164";
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create("whatsapp:+447729209351",
                array(
                    "from" => "whatsapp:+14155238886",
                    "body" => "[Message from: Jake Russell Valet] Hi Abi, don't forget your appointment is coming tomorrow [04 April 2019 @ 12:00].  If there are any problems please contact me ASAP.  http://home.rlyness.co.uk/dev/jrv/index.php"
                )
            );

        print($message->sid);

        break;

    case 'CheckBookingAvailability':

        $booking = $db->select('spGetAvailabilityById', array($_POST['id']));
        $item = $booking[0];

        $dte = new DateTime($item['start']);
        $item['start'] = $dte->format('D jS F');
        $item['isoDate'] = $dte->format('Y-m-d');

        echo json_encode($item);

        break;

    case 'MakeBooking':

        $name = $_POST['name'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $time = $_POST['time'];
        $id = $_POST['id'];
        $dte = $_POST['date'];

        $upd = $db->update('spSetAvailabilityBooked', array($id));
        if ($upd) {
            $ins = $db->insert('spInsertNewBooking', array($name, $number, $email, $time, $dte));

            $message = 'Thank you for making an appointment on ' . $dte . ' @ ' . $time . '. You will receive a reminder.';
            $sd = SendSMSMessage($number, $name, $message, false);

            if (!empty($sd)) {
                $db->insert('spSaveSentSMS', array($number, $message, $sd));
            }

            echo ($ins) ? 1 : 0;
            exit;
        }

        echo 0;

        break;

    case 'SendEmail':

        // Check for empty fields
        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            header('HTTP/1.1 500 Internal Server Error');
            exit();
        }

        $name = strip_tags(htmlspecialchars($_POST['name']));
        $email = strip_tags(htmlspecialchars($_POST['email']));
        $phone = strip_tags(htmlspecialchars($_POST['phone']));
        $message = strip_tags(htmlspecialchars($_POST['message']));

        $ins = $db->insert('spInsertNewContactItem', array($name, $email, $phone, $message));

        // Create the email and send the message
        $to = $db->select('spGetSettingByCode', array('CEML'))[0]['settingValue'];
        $subject = "Website Contact Form: $name";
        $body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nPhone: $phone\n\nMessage:\n$message";
        $header = "From: No Reply @ JRV <noreply@jakerussell.com>\n";
        $header .= "Reply-To: $name <$email>";

        if(!mail($to, $subject, $body, $header))
            header('HTTP/1.1 500 Internal Server Error');

        break;
}

?>
