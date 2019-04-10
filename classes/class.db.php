<?
//singleton pattern
class db {

    // GET LOGIN DETAILS FROM CONSTANTS
    const DB_DSN = Constants::CONSTRING;
    const DB_USERNAME = Constants::DBUSER;
    const DB_PASSWORD = Constants::DBPASS;

    private $storedProc; // THE STORED PROC BEING USED
    private $con; // THE CONNECTION OBJECT
    private $query;

    public $rowCount; // NUMBER OF ROWS IN SELECT OR NUMBER OF AFFECTED ROWS IN UPDATE/INSERT
    public $lastInsertId; // THE PRIMARY KEY OF THE MOST RECENT INSERT

    private $trace = false; // BOOLEAN TO ENABLE DATABASE TRACING

    public function __construct() {
        // CREATE NEW CONNECTION TO DATABASE
        $this->con = $this->newCon();
    }

    public function select($sp, $args = null, $pages = false) {

        $this->storedProc = $sp;
        //GET SQL STRING FROM STORED PROC LIST
        $this->query = $this->returnQuery($pages);

        $qry = $this->con->prepare($this->query);

        if ($args) { //FOREACH ARGUMENT PASSED IN, BIND TO QUERY
            $i = 1;
            foreach ($args as $a) {
                $qry->bindValue($i, $a, PDO::PARAM_STR);
                //IF LOGGING=TRUE, WRITE THE QUERY TO DATABASE.TXT
                if ($this->trace) { WriteLog("bind: ".$a, "database.txt"); }
                $i++;
            }
        }

        $qry->execute(); //EXECUTE THE QUERY
        $this->rowCount = $qry->rowCount(); //SET ROWCOUNT IN LOCAL VARIABLE
        if ($this->rowCount == 0) { //IF 0 RESULTS, RETURN EMPTY ARRAY
            return array();
        }
        else {
            // RETURN LIST OF RESULTS IN ASSOCIATIVE ARRAY
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
        // GET THE ID OF THE LAST INSERT
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

        // PERFORM THE DELETE
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
            // IF UPDATE WAS SUCCESSFUL
            return true;
        }
        else {
            return false;
        }
    }

    public function newCon() {

        try {
            //CONNECT TO DATABASE
            return new PDO(self::DB_DSN, self::DB_USERNAME, self::DB_PASSWORD);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function returnQuery($pages = false) {

        require_once 'inc/inc.sp.php';

        // GET THE FULL QUERY FROM THE LIST OF STORED PROCS
        $qr = getQuery($this->storedProc, $pages);

        // IF TRACING ENABLED, WRITE TO LOG
        if ($this->trace) {
            WriteLog('', "database.txt", false);
            WriteLog($this->storedProc.' | '.$qr, "database.txt", false);
        }

        return $qr;
    }
} 