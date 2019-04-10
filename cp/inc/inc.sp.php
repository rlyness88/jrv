<?

function getQuery($sp, $pages) {
    switch($sp) {

        case 'spGetPassForUser':
            return "SELECT pass
                    FROM user 
                    WHERE id = ?";
            break;

        case 'spUpdateUserPassword':
            return "UPDATE user
                    SET pass = ?
                    WHERE id = ?";
            break;

        case 'spGetPortfolioItemById':
            return "SELECT id, title, body, name
                    FROM portfolio
                    WHERE id = ?
                    LIMIT 0,1";
            break;

        case 'spUpdatePortfolioItemById':
            return "UPDATE portfolio
                    SET name = ?, title = ?, body = ?
                    WHERE id = ?";
            break;

        case 'spGetCalendarItems':
            return "SELECT id, title, start
                    FROM availability
                    WHERE isBooked = 0
                    AND STR_TO_DATE(start,'%Y-%m-%d') >= timestamp(current_date)";
            break;

        case 'spGetAvailableShifts':
            return "SELECT id, shift
                    FROM shifts
                    WHERE isDeleted = 0
                    ORDER BY shift ASC";
            break;

        case 'spGetSettingByCode':
            return "SELECT settingValue
                    FROM settings
                    WHERE settingCode = ?";
            break;

        case 'spUpdateSettingByCode':
            return "UPDATE settings
                    SET settingValue = ?
                    WHERE settingCode = ?
                    LIMIT 1";
            break;

        case 'spInsertNewCalendarItem':
            return "INSERT INTO availability (title, start) VALUES (?, ?)";
            break;

        case 'spCheckPortfolioIsDeleted':
            return "SELECT isDeleted
                    FROM portfolio
                    WHERE id = ?";
            break;

        case 'spGetRecentNotifications':
            return "SELECT id, date, message
                    FROM notification
                    WHERE isDeleted = 0
                    ORDER BY date DESC
                    LIMIT 0, 5";
            break;

        case 'spGetAllBookings':
            return "SELECT b.name, b.number, b.email, b.date, b.isConfirmed, b.isSentSMSReminder
                    FROM booking b
                    ORDER BY date DESC";
            break;

        case 'spTogglePortfolioItem':
            return "UPDATE portfolio SET isDeleted = 1 - isDeleted
                    WHERE id = ?";
            break;

        case 'spGetAllPortfolioItems':
            return "SELECT id, title, date, name, thumbnail, mainImage, isDeleted
                    FROM portfolio
                    ORDER BY isDeleted ASC, date DESC";
            break;

        case 'spInsertNewPortfolioItem':
            return "INSERT INTO portfolio (thumbnail, mainImage, title, body, name, date)
                    VALUES (?, ?, ?, ?, ?, unix_timestamp())";
            break;

        default:
            Die("The stored procedure you have used does not work! Please check and try again: ".$sp);
            break;
    }
}
