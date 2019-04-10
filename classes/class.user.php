<?

Class user {

    const PERM_TABLE = 'permission';
    const USER_PERM_TABLE = 'user_perm';

    // DOES USER HAVE PERMISSIONS?
    private $perms = false;
    public $loggedIn;
    public $userId;
    public $ipAddress;
    public $userName;
    public $fullName;
    public $email;

    // CONSTRUCTOR FOR GENERATING NEW USER OBJECT
    function __construct($id, $ip, $email, $fullname, $username) {
        $this->loggedIn = true;
        $this->ipAddress = $ip;
        $this->userId = $id;
        $this->email = $email;
        $this->fullName = $fullname;
        $this->userName = $username;

        // GO OFF GET PERMISSIONS FOR THIS USER
        if ($this->perms) {
            $this->GetPermissionCodesForThisUser();
        }
    }

    public function GetPermissionCodesForThisUser() {

        $db = new db();
        $con = $db->newCon(); // CONNECT TO DB

        $this->list = array();
        $q = "select p.code from ".self::USER_PERM_TABLE." up inner join ".self::PERM_TABLE." p ON up.perm_id = p.id where up.user_id = ? and p.enabled = '1'";
        $qry = $con->prepare($q);
        // EXECUTE QUERY
        $qry->execute(array($this->userId));

        if (!$qry) {
            die("BROKE1");
        }
        else {
            $row = $qry->fetchAll(PDO::FETCH_ASSOC);
        }

        // ADD PERMISSIONS TO PERMS OBJECT WITH PERM CODE
        foreach($row as $r) {
            array_push($this->list, $r['code']);
        }
    }

    public function hasPerm($code) {

        // CHECK IF USER HAS PERMISSION
        // IF PERMISSIONS ARE ENABLED
        if ($this->perms == false) {
            Die("Permissions are turned off!");
        }
        elseif (in_array($code, $this->list)) {
            // IF PERMISSION EXISTS, RETURN TRUE
            return true;
        }
        else {
            // NOT PERMITTED
            return false;
        }
    }
}


?>