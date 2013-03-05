<?php
	
	class User {
            
            protected $id_user;
            public $username;
            public $password;
            protected $kd_ba;
            protected $kd_es;
            protected $kd_satker;
            protected $date_created;
            protected $data_updated;
            protected $is_blokir=0;
                    
                    
            function __construct($data=array()) {
                
                if(!is_array($data)) {
                    trigger_error('Class baru tidak dapat diinisialisai '.get_class($name));
                }
                
                if(count($data)>0) {
                    foreach ($data as $name => $value) {
                        $this->$name=$value;
                    }
                    $this->date_created=time();
                }
            }
            
            /**
            * Fungsi autoload class
            */
            function __autoload($class_name) {
                    include 'class/class.' . strtolower($class_name) . '.php';
            }
            
            /**
             * Pengecekan terhadap user
             * @param User $user
             * @return array $data
             */
            function cekUser(User $user) {
                $username=$user->username;
                $password=$user->password;
                
                $data=array(
                    'is_true' => false,
                    'message' => 'Username dan Password salah',
                );
                
                $db=  Database::getInstance();
                $conn = $db->getConnection(1);
                
                $query="SELECT * FROM users WHERE username='".$username."' AND ";
                $query .="password='".$password."'";
                
                $result=$conn->prepare($query);
                $result->execute();
                
                if($result->rowCount()==1){
                    
                    $class = get_called_class();
                    $result->setFetchMode(PDO::FETCH_CLASS, $class);
                    $user_checked = $result->fetch();
                    
                    if(((int) $user_checked->is_blokir)==1) {
                        $data=array(
                            'is_true' => false,
                            'message'=>'User diblokir',
                        );
                        return $data;
                    }
                    $data=array(
                        'is_true' => true,
                        'message'=>'',
                    );
                    return $data;
                }
                return $data;
            }
	}
	
?>