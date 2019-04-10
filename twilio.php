<?
require 'inc/inc.funcs.php';
$db = new db();

// GET THE POST DATA FROM THE HTTP REQUEST
$post = file_get_contents('php://input');

//SPLIT THE DATA INTO AN ARRAY
$data = array();
parse_str($post, $data);

// CAPTURE THE KEY INFORMATION FROM THE REQUEST
$from = $data['From'];
$body = $data['Body'];
$smsId = $data['SmsMessageSid'];

// SAVE THE DETAIL TO THE DATABASE
$ins = $db->insert('spSaveReceivedSMS', array($from, $body, $smsId));

// IF THE BODY OF THE MESSAGE IS 'YES'
if (trim(strtolower($body)) == 'yes') {
    //UPDATE THE LATEST BOOKING FOR THE CUSTOMER AS CONFIRMED
    $upd = $db->update('spUpdateConfirmedBooking', array($from));
}
?>