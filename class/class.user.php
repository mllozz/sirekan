<?php

abstract class User {

    const AKSES_ADMIN = 1;
    const AKSES_SATKER = 2;
    const USER_ERROR_UNKNOWN_SUBCLASS = 1001;

    protected $id_user;
    public $username;
    public $password;
    public $kddept;
    public $kdunit;
    public $kdsatker;
    static public $valid_kdakses = array(
        User::AKSES_ADMIN => 'Admin',
        User::AKSES_SATKER => 'Satker',
    );
    public $kdakses;
    protected $date_created;
    protected $data_updated;

    function __construct($data = array()) {

        $this->_init();
        $this->date_created=date('Y-m-d H:i:s');
        if (!is_array($data)) {
            trigger_error('Class baru tidak dapat diinisialisai ' . get_class($name));
        }

        if (count($data) > 0) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
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
    final public static function cekUser($ver = array()) {
        $username = $ver['username'];
        if($ver['password']!=null) {
            $password = md5($ver['password']);
        }
        $data = array(
            'is_true' => false,
            'message' => 'Username dan Password salah',
        );

        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM users WHERE username='" . $username."' ";
        if($ver['password']!=null) {
            $query .=" AND password='" . $password . "'";
        }
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() == 1) {
            $arr = $result->fetch();
            $user_checked = self::getInstance($arr['kdakses'], $arr);
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
     * Get jenis akses
     * @return array
     */
    final public static function getAkses($kdakses) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT * FROM akses WHERE kdakses=" . (int) $kdakses;

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() != 1) {
            return false;
        }
        return $result->fetch();
    }

    /**
     * Mengambil object user sesuai id
     * @param int $id_user
     * @return object class
     */
    final public static function getUser($id_user) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT username,kddept,kdunit,kdsatker,kdakses FROM users WHERE id_user='" . (int) $id_user . "'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() != 1) {
            return false;
        }
        $user = $result->fetch();
        return self::getInstance($user['kdakses'], $user);
    }
    
    /**
     * Mengambil object user sesuai id
     * @param int $id_user
     * @return object class
     */
    final public static function getAllUser() {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT id_user,kddept,kdunit,kdsatker,username,users.kdakses kdakses,nmakses FROM users ";
        $query.= " LEFT JOIN akses ON users.kdakses=akses.kdakses";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() == 0) {
            return false;
        }
        $user = $result->fetchAll();
        return $user;
    }
    
    final public static function cariUser($kata) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT id_user,kddept,kdunit,kdsatker,username,users.kdakses kdakses,nmakses FROM users ";
        $query.= " LEFT JOIN akses ON users.kdakses=akses.kdakses ";
        $query .= " WHERE username LIKE  '%".$kata."%' OR kdsatker LIKE  '%".$kata."%' ";
        //$query .= " OR nmsatker LIKE  '%".$kata."%'";
        
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() == 0) {
            return false;
        }
        $user = $result->fetchAll();
        return $user;
    }
    
    /**
     * Update password user
     * @param User $user
     * @return boolean
     */
    final public static function updateUser($id_user,$password) {
        $db=Database::getInstance();
        $conn=$db->getConnection(1);
        
        $date_updated=date('Y-m-d H:i:s');
        
        $query="UPDATE users SET password='".$password."', date_updated='".$date_updated."' ";
        $query .=" WHERE id_user='".$id_user."'";
        
        $result=$conn->prepare($query);
        $result->execute();
        
        if($result->rowCount()==1) {
            return true;
        }
        return false;
    }
    
    /**
     * Blokir user
     * @param type $id_user
     * @return boolean
     */
//    final public static function blokirUser($id_user,$int) {
//        $db=Database::getInstance();
//        $conn=$db->getConnection(1);
//        
//        $date_updated=date('Y-m-d H:i:s');
//        
//        $query="UPDATE users SET is_blokir=".(int) $int.", date_updated='".$date_updated."' ";
//        $query .=" WHERE id_user='".$id_user."'";
//        $result=$conn->prepare($query);
//        $result->execute();
//        
//        if($result->rowCount()==1) {
//            return true;
//        }
//        return false;
//    }

    /**
     * save user baru
     * @return User
     */
    final public static function saveUser(User $user) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $password=self::generateRandomPassword();
        $query = "INSERT INTO users(username,password,kdakses,kddept,kdunit,kdsatker,date_created) VALUES(?,?,?,?,?,?,?)";

        $data = array($user->username, md5($password) , $user->kdakses, $user->kddept, $user->kdunit, $user->kdsatker, $user->date_created);

        $result = $conn->prepare($query);
        $result->execute($data);
 
        if ($result->rowCount() != 1) {
            return false;
        }
        $id_user = $conn->lastInsertId();
        //print_r($id_user.''.$password);
        $user = self::getUser($id_user);
        $data=array(
            'username' => $user->username,
            'password' => $password,
            'kddept' => $user->kddept,
            'kdunit' => $user->kdunit,
            'kdsatker' => $user->kdsatker,
        );
        return $data;
    }
    
    /**
     * 
     * @param User $user
     * @return array
     */
    final public static function resetPass(User $user) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);
        $password=self::generateRandomPassword();
        $passmd5=md5($password);
        $date_updated=date('Y-m-d H:i:s');
        $query = "UPDATE users SET password='".$passmd5."', date_updated='".$date_updated."' ";
        $query .= " WHERE username='".$user->username."' AND kdakses='".$user->kdakses."' ";
        
        if($user->kddept!='' && $user->kdunit!='' && $user->kdsatker!='') {
            $query .=" AND kddept='".$user->kddept."' ";
            $query .=" AND kdunit='".$user->kdunit."' ";
            $query .=" AND kdsatker='".$user->kdsatker."' ";
        }
        

        $result = $conn->prepare($query);
        $result->execute();
 
        if ($result->rowCount() != 1) {
            return false;
        } else {
            $data=array(
                'username' => $user->username,
                'password' => $password,
                'kddept' => $user->kddept,
                'kdunit' => $user->kdunit,
                'kdsatker' => $user->kdsatker,
            );
            return $data;
        }
    }
    
    /**
     * Cek ketersediaan user
     * @param User $user
     * @return boolean
     */
    final public static function checkAvailability(User $user) {
        $db=Database::getInstance();
        $conn=$db->getConnection(1);
        
        $query="SELECT username FROM users WHERE username='".$user->username."' ";
        if($user->kddept!='' && $user->kdunit!='' && $user->kdsatker!='') {
            $query .=" AND kddept='".$user->kddept."' ";
            $query .=" AND kdunit='".$user->kdunit."' ";
            $query .=" AND kdsatker='".$user->kdsatker."' ";
        }
        $result=$conn->prepare($query);
        $result->execute();
        if($result->rowCount()==0) {
            return true;
        }
        return false;
    }
    
    /**
     * Cek apakah username admin
     * @param type $username
     * @return boolean
     */
    final public static function isAdmin($username) {
        $db=Database::getInstance();
        $conn=$db->getConnection(1);
        
        $query="SELECT kdakses FROM users WHERE username='".$username."'";
        
        $result=$conn->prepare($query);
        $result->execute();
        if($result->rowCount()!=1) {
            return false;
        }
        $user = $result->fetch();
        if($user['kdakses']==1) {
            return true;
        }
        return false;
    }
    
    
//    final protected static function getUserPasswordGenerated($id_user){
//        $db = Database::getInstance();
//        $conn = $db->getConnection(1);
//
//        $query = "SELECT username,password,kddept,kdunit,kdsatker,kdakses FROM users WHERE id_user='" . (int) $id_user . "'";
//
//        $result = $conn->prepare($query);
//        $result->execute();
//
//        if ($result->rowCount() != 1) {
//            return false;
//        }
//        $user = $result->fetch();
//        return self::getInstance($user['kdakses'], $user);
//    }

    protected static function generateRandomPassword() {
        $string = 'qwertyuiopasdfghjklzxcvbnm1234567890@#$%&';
        $password = '';
        $length = 8;
        for ($i = 0; $i < $length; $i++) {
            $password .= $string[mt_rand(0, strlen($string)-1)];
        }
        return $password;
    }

    public static function isValidAkses($kdakses) {
        return array_key_exists($kdakses, self::$valid_kdakses);
    }

    protected function _setKdAkses($kdakses) {
        if (self::isValidAkses($kdakses)) {
            $this->kdakses = $kdakses;
        }
    }

    final public static function getInstance($kdakses, $data = array()) {
        $class_name = 'User' . self::$valid_kdakses[$kdakses];
        if (!class_exists($class_name)) {
            throw new ExceptionClass('User subclass not found, cannot create.', self::USER_ERROR_UNKNOWN_SUBCLASS);
        }
        return new $class_name($data);
    }

}

?>