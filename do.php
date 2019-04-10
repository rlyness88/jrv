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
