<?
Class login {

    const LOGINDETAILS = 'user';
    const USERFIELD = 'user';
    const UPDATELASTLOGIN = true;
    const LASTLOGINFIELD = 'lastLogin';
    const DELETEEXPIREDCOOKIES = false;
    const COOKIESTABLE = 'loginToken';
    const ALLOWSLI = false;
    const RETURNTO = "index.php";
    const LOGINPAGE = "index.php";

    private $password;
    private $username;
    private $userId;

    function __construct() {

    }

    public function doLogin($u, $p) {

        $this->username = $u;
        $this->password = $p;

        $db = new db();
        $con = $db->newCon();

        $q = "SELECT id, user, pass, email, fullName, lastLogin FROM ".self::LOGINDETAILS." WHERE user = ? OR email = ? LIMIT 0,1";
        $qry = $con->prepare($q);

        $qry->execute(array($this->username, $this->username));

        if ($qry->rowCount() > 0) {
            $row = $qry->fetch(PDO::FETCH_ASSOC);

            if (strtolower($row['user']) == strtolower($this->username) || strtolower($row['email']) == strtolower($this->username)) {

                if ($row['pass'] == sha1($this->password)) {
                    session_start();

                    $_SESSION['log'] = 1;
                    $_SESSION['user'] = new user($row['id'], $_SERVER['REMOTE_ADDR'], $row['email'], $row['fullName'], $row['user'], $row['lastLogin']);

                    $this->userId = $row['id'];

                    $this->checkUpdateLastLogin($con);

                    $this->checkDeleteLastCookies($con);

                    $this->checkIfAllowSLI($con);

                    //header("Location: ".self::RETURNTO);
                    return 1;
                }
                else {
                    //header("Location: ".self::LOGINPAGE."?err=1"); //wrong password
                    return 2;
                }
            }
            else {
                //header("Location: ".self::LOGINPAGE."?err=3"); //wrong user (case sens)
                return 3;
            }
        }
        else {
            //header("Location: ".self::LOGINPAGE."?err=2"); //unknown user
            return 4;
        }
    }

    public function doLogout($userId) {

        session_start();
        session_unset();
        session_destroy();

        if (isset($_COOKIE['LoginToken'])) {
            setcookie('LoginToken', 'DONE', 1, "/");
        }

        header('location: '.self::LOGINPAGE);
        exit;
    }

    #region Private Functions

    private function checkUpdateLastLogin($con) {

        if (self::UPDATELASTLOGIN == true) {
            $qry = $con->query("UPDATE ".self::LOGINDETAILS." SET ".self::LASTLOGINFIELD." = unix_timestamp() WHERE id = '$this->userId'");
            if (!$qry) {
                die("BROKE");
            }
        }
    }

    private function checkDeleteLastCookies($con) {

        if (self::DELETEEXPIREDCOOKIES == true) {
            $qry = $con->query("DELETE FROM ".self::COOKIESTABLE." WHERE unix_timestamp() > expiry");
            if (!$qry) {
                die("BROKE");
            }
        }
    }

    private function checkIfAllowSLI($con) {

        if (self::ALLOWSLI == true) {

            $token = sha1(mt_rand(1, 90000) . 'SALT');
            $exp = time() + 2592000;

            /*$qry = $con->query("DELETE FROM ".self::COOKIESTABLE." WHERE userId = '$this->userId'");
            if (!$qry) {
                die("BROKE");
            }*/

            $qry = $con->query("INSERT INTO ".self::COOKIESTABLE." (userId, token, expiry) VALUES ('$this->userId', '$token', '$exp')");
            if (!$qry) {
                die("BROKE");
            }

            setcookie('LoginToken', $token, $exp, "/");
        }
    }

    #endregion
}
?>