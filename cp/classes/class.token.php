<?

class token {

    public $id;
    public $isLive = false;

    function __construct() {
        $this->id = md5(uniqid(rand(), true));
        $_SESSION['token'] = $this;
    }

    public function CheckReferer($ref) {
        if (strpos($ref, Constants::SITETOKENURL) === false || $ref == null) {
            Die("CSRF0");
        }
    }

    public function CheckToken($t, $expire = true) {

        if ($this->isLive) {

            if ($t <> $this->id) {
                Die("CSRF1");
            } elseif (!isset($this->id)) {
                Die("CSRF2");
            } elseif ($t == null || $t == '') {
                Die("CSRF3");
            }

            if ($expire) {
                unset($_SESSION['token']);
            }
        }
    }

    public function field() {
        echo '<input type="hidden" id="token" value="'.$this->id.'" />';
    }
}

?>