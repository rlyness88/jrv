<?
require 'inc/inc.funcs.php';
$db = new db(); //new database connection
session_start();
$token = new token();

switch ($_GET['z']) {

    case 'SendSMSReminders':

        // get a list of booking that need to be reminded
        // bookings that have not yet been reminded for 'tomorrow'
        $reminders = $db->select('spGetBookingsForSMS');

        // if debug mode, display the reminders without
        // sending the SMS messages
        if ($_GET['debug'] == 1) {
            print_r($reminders);
            exit;
        }

        foreach ($reminders as $r) {

            // build up the body of the text message
            $body = 'This is a reminder of your appointment on ' . $r['date'] . ' @ ' . $r['time'] .'. Problems? Contact me.';

            // call the function to send the message passing the name number and body of the text
            // returns the API smsId from the Twilio API
            $id = SendSMSMessage($r['number'], $r['name'], $body, true);

            // if message has been sent successfully
            if (!empty($id)) {
                // update booking stating SMS has been sent
                $up = $db->update('spUpdateBookingReminderSent', array($r['id']));

                // insert into sent_message table
                $db->insert('spSaveSentSMS', array($r['number'], $body, $id));
            }
        }
        break;
}


echo 'Completed: ' . $_GET['z'];
