<?
require 'inc/inc.funcs.php';
$db = new db();
session_start();
$user = $_SESSION['user'];
if (isset($_SESSION['token']))
{
    $token = $_SESSION['token'];
    $token->CheckReferer($_SERVER['HTTP_REFERER']);
}

switch ($_GET['z'])
{
    #region custom

    case 'SampleProcess':

        $token->CheckToken($_POST['token'], false);
        break;

    case 'SaveSetting':
        //print_r($_POST); exit;

        switch ($_GET['setting']) {

            case 'contact':

                $upd = $db->update('spUpdateSettingByCode', array('#empty', 'CEML'));
                $upd = $db->update('spUpdateSettingByCode', array($_POST['CEML'], 'CEML'));
                if ($upd) {
                    header('location: index.php?z=site-settings&error=0');
                }
                else {
                    header('location: index.php?z=site-settings&error=1');
                }
                break;

            case 'about':

                $upd = $db->update('spUpdateSettingByCode', array('#empty', 'ABT1'));
                $upd = $db->update('spUpdateSettingByCode', array($_POST['ABT1'], 'ABT1'));

                $upd2 = $db->update('spUpdateSettingByCode', array('#empty', 'ABT2'));
                $upd2 = $db->update('spUpdateSettingByCode', array($_POST['ABT2'], 'ABT2'));

                if ($upd && $upd2) {
                    header('location: index.php?z=site-settings&error=0');
                }
                else {
                    header('location: index.php?z=site-settings&error=1');
                }
                break;

            case 'socialmedia':

                $upd1 = $db->update('spUpdateSettingByCode', array('#empty', 'SMFB'));
                $upd1 = $db->update('spUpdateSettingByCode', array($_POST['SMFB'], 'SMFB'));

                $upd2 = $db->update('spUpdateSettingByCode', array('#empty', 'SMIN'));
                $upd2 = $db->update('spUpdateSettingByCode', array($_POST['SMIN'], 'SMIN'));

                $upd3 = $db->update('spUpdateSettingByCode', array('#empty', 'SMTW'));
                $upd3 = $db->update('spUpdateSettingByCode', array($_POST['SMTW'], 'SMTW'));

                $upd4 = $db->update('spUpdateSettingByCode', array('#empty', 'SMLI'));
                $upd4 = $db->update('spUpdateSettingByCode', array($_POST['SMLI'], 'SMLI'));

                $upd5 = $db->update('spUpdateSettingByCode', array('#empty', 'SMOT'));
                $upd5 = $db->update('spUpdateSettingByCode', array($_POST['SMOT'], 'SMOT'));

                $upd6 = $db->update('spUpdateSettingByCode', array('#empty', 'SMOI'));
                $upd6 = $db->update('spUpdateSettingByCode', array($_POST['SMOI'], 'SMOI'));

                if ($upd1 && $upd2 && $upd3 && $upd4 && $upd5 && $upd6) {
                    header('location: index.php?z=site-settings&error=0');
                }
                else {
                    header('location: index.php?z=site-settings&error=1');
                }
                break;

            case 'google':

                $upd = $db->update('spUpdateSettingByCode', array('#empty', 'GAEM'));
                $upd = $db->update('spUpdateSettingByCode', array($_POST['GAEM'], 'GAEM'));

                $upd2 = $db->update('spUpdateSettingByCode', array('#empty', 'GAPA'));
                $upd2 = $db->update('spUpdateSettingByCode', array($_POST['GAPA'], 'GAPA'));

                $upd3 = $db->update('spUpdateSettingByCode', array('#empty', 'GAID'));
                $upd3 = $db->update('spUpdateSettingByCode', array($_POST['GAID'], 'GAID'));

                if ($upd && $upd2 && upd3) {
                    header('location: index.php?z=site-settings&error=0');
                }
                else {
                    header('location: index.php?z=site-settings&error=1');
                }

                break;

            case 'other':

                $upd = $db->update('spUpdateSettingByCode', array('#empty', 'OTHL'));
                $upd = $db->update('spUpdateSettingByCode', array($_POST['OTHL'], 'OTHL'));

                $upd2 = $db->update('spUpdateSettingByCode', array('#empty', 'OTHT'));
                $upd2 = $db->update('spUpdateSettingByCode', array($_POST['OTHT'], 'OTHT'));

                if ($upd && $upd2) {
                    header('location: index.php?z=site-settings&error=0');
                }
                else {
                    header('location: index.php?z=site-settings&error=1');
                }

                break;
        }
        break;

    case 'ChangeAdminPassword':

        $token->CheckToken($_POST['token'], false);
        $userPass = $db->select('spGetPassForUser', array($_POST['userId']))[0]['pass'];

        if ($userPass == sha1($_POST['currentPass'])) {
            $upd = $db->update('spUpdateUserPassword', array(sha1($_POST['newPass1']), $_POST['userId']));
            echo ($upd) ? 0 : 1;
        }
        else {
            echo 1;
        }

        break;

    case 'AdminAddNewPortfolioItem':

        $token->CheckToken($_POST['token'], false);

        $link = "../img/portfolio/";

        $ext1 = end((explode(".", $_FILES['file']['name'])));
        $ext2 = end((explode(".", $_FILES['file2']['name'])));

        $name1 = substr(md5(rand()), 0, 15).'.'.$ext1;
        $name2 = substr(md5(rand()), 0, 15).'.'.$ext2;

        move_uploaded_file($_FILES['file']['tmp_name'], $link . $name1);
        move_uploaded_file($_FILES['file2']['tmp_name'], $link . $name2);

        $caption = $_POST['caption'];
        $body = $_POST['body'];
        $name = $_POST['custName'];

        $ins = $db->insert('spInsertNewPortfolioItem', array($name1, $name2, $caption, $body, $name));

        if ($ins)
            header('location: index.php?z=portfolio');

        break;

    case 'GetCalendarItems':

        $token->CheckToken($_POST['token'], true);

        $items = $db->select('spGetCalendarItems');
        echo json_encode($items);

        break;

    case 'AdminAddNewCalendarItem':

        $ins = $db->insert('spInsertNewCalendarItem', array($_POST['time'], $_POST['date']));
        echo ($ins) ? 1 : 0;

        break;

    case 'GetPortfolioItemById':

        $items =  $db->select('spGetPortfolioItemById', array($_POST['portfolioid']));
        $item = $items[0];

        echo json_encode($item);

        break;

    case 'UpdatePortfolioItemById':

        $newName = $_POST['newName'];
        $newTitle = $_POST['newCaption'];
        $newBody = $_POST['newBody'];
        $id = $_POST['id'];

        $upd = $db->update('spUpdatePortfolioItemById', array($newName, $newTitle, $newBody, $id));

        echo ($upd) ? 1 : 0;

        break;

    case 'ToggleDeletedPortfolioItem':

        $toggle = $db->update('spTogglePortfolioItem', array($_POST['id']));

        $del = $db->select('spCheckPortfolioIsDeleted', array($_POST['id']));
        $d = $del[0];
        echo $d['isDeleted'];

        break;

    #endregion

    #region DEFAULT

    case 'CheckValueExists':

        //$token->CheckToken($_POST['token'], false);

        $con = new PDO(Constants::CONSTRING, Constants::DBUSER, Constants::DBPASS);

        $query = "SELECT $_GET[column] FROM $_GET[table]";

        $qry = $con->prepare($query);
        $qry->execute();
        //$result = $qry->fetchall(PDO::FETCH_ASSOC);

        $usersArray = array();

        while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            array_push($usersArray, $row[$_GET[column]]);
        }

        echo implode(",", array_values($usersArray));

        break;

    case 'doLogin':

        //sleep(1);
        $log = new login();
        echo $log->doLogin($_POST['username'], $_POST['password']);

        break;

    case 'doLogout':

        login::doLogout($user->userId);

        break;

    #endregion
}
?>