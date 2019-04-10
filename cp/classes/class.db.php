<?
class db { //singleton pattern

    const DB_DSN = Constants::CONSTRING;
    const DB_USERNAME = Constants::DBUSER;
    const DB_PASSWORD = Constants::DBPASS;

    #region Member Variables

    private $storedProc;
    private $con;
    private $query;

    public $rowCount;
    public $lastInsertId;

    private $trace = true;

    #endregion

    #region Constructor

    public function __construct() {

        $this->con = $this->newCon();
    }

    #endregion

    #region Public Methods

    public function select($sp, $args = null, $pages = false) {

        $this->storedProc = $sp;
        $this->query = $this->returnQuery($pages);

        $qry = $this->con->prepare($this->query);

        if ($args) {
            $i = 1;
            foreach ($args as $a) {
                $qry->bindValue($i, $a, PDO::PARAM_STR);
                if ($this->trace) { WriteLog("bind: ".$a, "database.txt"); }
                $i++;
            }
        }

        $qry->execute();

        $this->rowCount = $qry->rowCount();

        if ($this->rowCount == 0) { //if empty resultset, return null
            return array();
        }
        else {
            return $qry->fetchall(PDO::FETCH_ASSOC);
        }
    }

    public function insert($sp, $args = null) {

        $this->storedProc = $sp;
        $this->query = $this->returnQuery();

        $qry = $this->con->prepare($this->query);

        if ($args) {
            $i = 1;
            foreach ($args as $a) {
                $qry->bindValue($i, $a);
                if ($this->trace) { WriteLog("bind: ".$a, "database.txt"); }
                $i++;
            }
        }

        $qry->execute();

        $this->rowCount = $qry->rowCount();
        $this->lastInsertId = $this->con->lastInsertId();

        if ($this->rowCount > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function delete($sp, $args = null) {

        $this->storedProc = $sp;
        $this->query = $this->returnQuery();

        $qry = $this->con->prepare($this->query);

        if ($args) {
            $i = 1;
            foreach ($args as $a) {
                $qry->bindValue($i, $a);
                if ($this->trace) { WriteLog("bind: ".$a, "database.txt"); }
                $i++;
            }
        }

        $qry->execute();

        $this->rowCount = $qry->rowCount();

        if ($this->rowCount > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function update($sp, $args = null) {

        $this->storedProc = $sp;
        $this->query = $this->returnQuery();

        $qry = $this->con->prepare($this->query);

        if ($args) {
            $i = 1;
            foreach ($args as $a) {
                $qry->bindValue($i, $a);
                if ($this->trace) { WriteLog("bind: ".$a, "database.txt"); }
                $i++;
            }
        }

        $qry->execute();

        $this->rowCount = $qry->rowCount();

        if ($this->rowCount > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function newCon() {

        try {
            return new PDO(self::DB_DSN, self::DB_USERNAME, self::DB_PASSWORD); //our new PDO Object
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    #endregion

    #region Private Methods

    private function returnQuery($pages = false) {

        require_once 'inc/inc.sp.php';

        $qr = getQuery($this->storedProc, $pages);
        //echo '<br />'.$qr.'<br />';

        if ($this->trace) {
            WriteLog('', "database.txt", false);
            WriteLog($this->storedProc.' | '.$qr, "database.txt", false);
        }

        return $qr;
    }

    #endregion
} 