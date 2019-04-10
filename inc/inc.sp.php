<?

function getQuery($sp, $pages) {
    switch($sp) {

        case 'spGetCalendarItems':
            return "SELECT id, title, start
                    FROM availability
                    WHERE isBooked = 0
                    AND STR_TO_DATE(start,'%Y-%m-%d') > timestamp(current_date)";
            break;

        case 'spGetSettingByCode':
            return "SELECT settingValue
                    FROM settings
                    WHERE settingCode = ?";
            break;

        case 'spGetAllPortfolioItems':
            return "SELECT id, title, date, name, thumbnail, mainImage, isDeleted, body
                    FROM portfolio
                    WHERE isDeleted = 0
                    ORDER BY date DESC
                    LIMIT 0, 6";

        case 'spGetAvailabilityById':
            return "SELECT id, start, title
                    FROM availability
                    WHERE id = ?";
            break;

        case 'spSetAvailabilityBooked':
            return "UPDATE availability SET isBooked = 1 WHERE id = ?";
            break;

        case 'spInsertNewBooking':
            return "INSERT INTO booking (name, number, email, time, date) VALUES
                    (?, ?, ?, ?, ?)";
            break;

        case 'spSaveSentSMS':
            return "INSERT INTO sent_messages (sentTo, date, body, smsId)
                    VALUES (?, unix_timestamp(), ?, ?)";
            break;

        case 'spUpdateBookingConfirmed':
            return"";
            break;

        case 'spSaveReceivedSMS':
            return "INSERT INTO received_message (smsFrom, date, body, smsId)
                    VALUES (?, unix_timestamp(), ?, ?)";
            break;

        case 'spInsertNewContactItem':
            return "INSERT INTO contacts (name, email, phone, date, message)
                    VALUES (?, ?, ?, unix_timestamp(), ?)";
            break;

        case 'spUpdateConfirmedBooking':
            return "UPDATE booking
                    SET isConfirmed = 1
                    WHERE isSentSMSReminder = 1
                    AND RIGHT(number, 10) = RIGHT(?, 10)";
            break;

        case 'spUpdateBookingReminderSent':
            return "UPDATE booking
                    SET isSentSMSReminder = 1
                    WHERE id = ?";
            break;

        case 'spGetAllUnconfirmedBookings':
            return "SELECT id, name, number
                    FROM booking
                    WHERE isConfirmed = 0
                    LIMIT 0,3";
            break;

        case 'spGetBookingsForSMS':
            // get bookings for tomorrow to send reminders
            return "SELECT id, name, number, date, time
                    FROM booking
                    WHERE isConfirmed = 0 AND isSentSMSReminder = 0
                    AND
                    (
                        date = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY), '%Y-%m-%d')                        
                    )";
            break;

        default:
            Die("The stored procedure you have used does not work! Please check and try again: ".$sp);
            break;
    }
}
