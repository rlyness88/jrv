<?
class token {

    public $id;
    public $isLive = false;

    function __construct() {
        // CREATE A NEW UNIQUE TOKEN ID
        $this->id = md5(uniqid(rand(), true));
        $_SESSION['token'] = $this; // SET VALUE TO SESSION
    }

    public function CheckReferer($ref) {

        // IF THE REQUEST HAS NOT COME FROM SELF AND ISLIVE IS TRUE, KILL APPLICATION
        if (strpos($ref, Constants::SITETOKENURL) === false || $ref == null) {
            if ($this->isLive) {
                Die("CSRF0");
            }
        }
    }

    public function CheckToken($t, $expire = true) {

        // IF SECURITY SETTINGS ARE TURNED ON
        if ($this->isLive) {

            // IF THE PASSED VALUE IS NOT EQUAL TO THE SESSION TOKEN, KILL APPLICATION WITH ERROR
            if ($t <> $this->id) {
                Die("CSRF1");
            } elseif (!isset($this->id)) {
                Die("CSRF2");
            } elseif ($t == null || $t == '') {
                Die("CSRF3");
            }

            // AFTER PROCESSING, UNSET TOKEN VALUE
            if ($expire) {
                unset($_SESSION['token']);
            }
        }
    }

    // PLACE HIDDEN TOKEN FIELD IN THE HTML
    public function field() {
        echo '<input type="hidden" id="token" value="'.$this->id.'" />';
    }
}
?>