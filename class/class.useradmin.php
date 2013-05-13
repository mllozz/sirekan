<?php

class UserAdmin extends User {
    protected function _init(){
        $this->_setKdAkses(User::AKSES_ADMIN);
    }
    
    final public static function getUserBlok(){
        
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT DISTINCT  a.id_user,if( b.is_blokir = '0', NULL , b.is_blokir )  blok
                    FROM users a LEFT JOIN blokir b ON a.id_user = b.id_user GROUP BY a.id_user ORDER BY blok";
        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() == 0) {
            return false;
        }
        $data = $result->fetchAll();
        return $data;
    }
    final public static function getUserByUsername($username) {
        $db = Database::getInstance();
        $conn = $db->getConnection(1);

        $query = "SELECT kddept,kdunit,kdsatker,kddekon,kdakses FROM users WHERE username='$username'";

        $result = $conn->prepare($query);
        $result->execute();

        if ($result->rowCount() != 1) {
            return false;
        }
        $user = $result->fetch();
        return $user;
    }
}

