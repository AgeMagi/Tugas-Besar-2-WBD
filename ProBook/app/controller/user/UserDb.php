<?php
    require_once __ROOT__."/util/Database.php";
    require_once __ROOT__."/app/controller/user/User.php";

    class UserDb extends Database{ 
        function __construct(PDO $conn){
            parent::__construct($conn);
        }

        function getUserById($id){
            $user = null;
            $sql = 'SELECT * FROM user WHERE user_id = ?';
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$id])){
                $row = $stmt->fetch();
                $user_id = (int) $row["user_id"];
                $fullname = $row["fullname"];
                $username = $row["username"];
                $email = $row["email"];
                $address = $row["address"];
                $phone = $row["phone"];
                $imgPath = $row["img_path"];
                $hpass = $row["hpass"];
                
                $user = new User($user_id, $username, $fullname, $email, $address, $phone, $hpass, $imgPath);
            };      
            return $user;
        }

        function createUser($user){
            $userRes = null;
            $sql = 'INSERT INTO user(username,fullname,email,address,phone,hpass) VALUES(?,?,?,?,?,?)';
            $stmt = $this->conn->prepare($sql);

            if ($stmt->execute([$user->username, $user->fullname, $user->email, $user->address,$user->phone, $user->getPassword()])){
                $user_id = 0;
                $last_insert_id = $this->conn->query("SELECT LAST_INSERT_ID()");
                foreach($last_insert_id as $row){
                    $user_id = $row["LAST_INSERT_ID()"]; 
                };
                $userRes = new User($user_id, $user->username, $user->fullname, $user->email, $user->address, $user->phone, $user->getPassword());
            }
            return $userRes;
        }

        function updateUser($user){
            $sql = 'UPDATE user SET username=?, fullname=?, email=?, address=?, phone=?, img_path=?, hpass=? WHERE user_id=?';
            $stmt = $this->conn->prepare($sql);

            if ($stmt->execute([$user->username, $user->fullname, $user->email, $user->address,  $user->phone, $user->imgPath, $user->getPassword(), $user->user_id])){
                return $user;
            } else {
                return null;
            }
        }

        function deleteUser($user_id){
            $sql = 'DELETE FROM user WHERE user_id=?';
            $stmt = $this->conn->prepare($sql);
            return ($stmt->execute([$user_id]));
        }

        function isEmailorUsernameExist($email,$username){
            $sql = 'SELECT 1 from user WHERE username=? OR email=?';
            $stmt = $this->conn->prepare($sql);

            if ($stmt->execute([$username,$email])){
                if (count($stmt->fetchAll()) == 0) {
                    return false;
                } else {
                    return true;
                }
            } 

            return false;
        }

        function authenticateUser($username,$hpass){
            $sql = 'SELECT user_id from user WHERE username=? AND hpass=?';
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$username,$hpass])){
                $row = $stmt->fetch();
                return $row["user_id"];
            } else {
                echo "error";
            }
            return null;
        }

        function createSessionStorage($session_storage_id, $username, $hpass, 
                                        $user_id, $http_user_agent, $ip_address, $expired_time) {
            $sql = 'INSERT INTO session_storage(session_storage_id, username, 
                    hpass, user_id, http_user_agent, ip_address, expired_time) VALUES(?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$session_storage_id, $username, $hpass, $user_id, $http_user_agent, $ip_address, $expired_time])) {
                $row = $stmt->fetch();
                return $session_storage_id;
            } else {
                echo "error";
            }
            return null;
        }

        function getSessionStorage($session_storage_id, $http_user_agent, $ip_address) {
            $timeNow = microtime(true);

            $sql = 'SELECT * FROM session_storage WHERE session_storage_id=? AND 
                    http_user_agent=? AND ip_address=? AND expired_time > ?';
            
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$session_storage_id, $http_user_agent, $ip_address, $timeNow])) {
                $row = $stmt->fetch();
                if ($row) {
                    $result = array(
                        "username" => $row["username"],
                        "user_id" => $row["user_id"],
                    );
                } else {
                    return null;
                }
                return $result;
            }
            return null;
        }

        function isEmailExist($email){
            $sql = 'SELECT 1 from user WHERE email=?';
            $stmt = $this->conn->prepare($sql);

            if ($stmt->execute([$email])){
                if (count($stmt->fetchAll()) == 0) {
                    return false;
                } else {
                    return true;
                }
            } 

            return false;
        }

        function isUsernameExist($username){
            $sql = 'SELECT 1 from user WHERE username=?';
            $stmt = $this->conn->prepare($sql);

            if ($stmt->execute([$username])){
                if (count($stmt->fetchAll()) == 0) {
                    return false;
                } else {
                    return true;
                }
            }
            return false;
        }

        function uploadImage($imageFile){
            $target_dir = __STATIC__.'/img/';
            $target_file = $target_dir . basename($imageFile["name"]);
            if (move_uploaded_file($imageFile["tmp_name"], $target_file)) {
                return ["success"=>true, "path"=>'/static/img/'.$imageFile["name"]];
            } else {
                return false;
            }
        }
    }
?>