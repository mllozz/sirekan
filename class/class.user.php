<?php

abstract class User {

    const AKSES_ADMIN = 1;
    const AKSES_SATKER = 2;
    const USER_ERROR_UNKNOWN_SUBCLASS=1001;
    
    protected $id_user;
    public $username;
    public $password;
    protected $kddept;
    protected $kdunit;
    protected $kdsatker;
    static public $valid_kdakses = array(
        User::AKSES_ADMIN => 'Admin',
        User::AKSES_SATKER => 'Satker',
    );
    protected $kdakses;
    protected $date_created;
    protected $data_updated;
    protected $is_blokir = 0;

    function __construct($data = array()) {
        
        $this->_init();

        if (!is_array($data)) {
            trigger_error('Class baru tidak dapat diinisialisai ' . get_class($name));
        }

        if (count($data) > 0) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
            $this->date_created = time();
        }
    }

    /**
     * Fungsi autoload class
     */
    function __autoload($class_name) {
        include 'class/class.' . strtolower($class_name) . '.php';
    }
    
    abstract protected function _init();

    /**
     * Pengecekan terhadap user
     * @param User $user
     * @return array $data
     */
    final public static function cekUser($ver=  array()) {
        $username = $ver['username'];
        $password = $ver['password'];

        $data = array(
            'is_true' => false,
            'message' => 'Username dan Password salah',
        );

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM users WHERE username='" . $username . "' AND ";
        $query .="password='" . $password . "'";

        $result = $conn->prepare($query);
        $result->execute();
       
        if ($result->rowCount() == 1) {
            $arr=  $result->fetch();
            $user_checked = self::getInstance($arr['kdakses'], $arr);
            //print_r($user_checked);
            if (((int) $user_checked->is_blokir) == 1) {
                $data = array(
                    'is_true' => false,
                    'message' => 'User diblokir',
                );
                return $data;
            }
            $data = array(
                'is_true' => true,
                'id_user' => $user_checked->id_user,
                'message' => '',
            );
            return $data;
        }
        return $data;
    }
    
    /**
     * Mengambil object user sesuai id
     * @param int $id_user
     * @return array
     */
    final public static function getUser($id_user) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT kddept,kdunit,kdsatker,kdakses FROM users WHERE id_user='" . (int) $id_user . "'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() != 1) {
            return false;
        }
        $user = $result->fetch();
        return self::getInstance($user['kdakses'], $user);
    }
    
    static public function isValidAkses($kdakses) {
        return array_key_exists($kdakses, self::$valid_kdakses);
    }
    
    protected function _setKdAkses($kdakses) {
        if(self::isValidAkses($kdakses)){
            $this->kdakses=$kdakses;
        }
    }
    
    final public static function getInstance($kdakses,$data=array()) {
        $class_name = 'User' . self::$valid_kdakses[$kdakses];
        if (!class_exists($class_name)) {
          throw new ExceptionClass('User subclass not found, cannot create.',
            self::USER_ERROR_UNKNOWN_SUBCLASS);
        }
        return new $class_name($data);
    }

}

?>