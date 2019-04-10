<?

Class user {

    const PERM_TABLE = 'permission';
    const USER_PERM_TABLE = 'user_perm';

    private $perms = true;
    public $loggedIn;
    public $userId;
    public $ipAddress;
    public $userName;
    public $fullName;
    public $email;
    public $lastLogin;

    function __construct($id, $ip, $email, $fullname, $username, $lastLogin) {
        $this->loggedIn = true;
        $this->ipAddress = $ip;
        $this->userId = $id;
        $this->email = $email;
        $this->fullName = $fullname;
        $this->userName = $username;
        $this->lastLogin = $lastLogin;

        if ($this->perms) {
            $this->GetPermissionCodesForThisUser();
        }
    }

    public function GetPermissionCodesForThisUser() {

        $db = new db();

        $con = $db->newCon();

        $this->list = array();

        $q = "select p.code from ".self::USER_PERM_TABLE." up inner join ".self::PERM_TABLE." p ON up.perm_id = p.id where up.user_id = ? and p.enabled = '1'";

        $qry = $con->prepare($q);
        $qry->execute(array($this->userId));
        if (!$qry) {
            die("BROKE1");
        }
        else {
            $row = $qry->fetchAll(PDO::FETCH_ASSOC);
        }

        foreach($row as $r) {
            array_push($this->list, $r['code']);
        }
    }

    public function hasPerm($code) {

        if ($this->perms == false) {
            Die("Permissions are turned off!");
        }
        elseif (in_array($code, $this->list)) {
            return true;
        }
        else {
            return false;
        }
    }
}


?>