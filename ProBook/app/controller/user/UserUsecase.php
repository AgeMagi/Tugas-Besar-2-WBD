<?php
    require_once __ROOT__.'/app/controller/user/UserDb.php';
    require_once __ROOT__.'/app/controller/user/User.php';
    require_once __ROOT__.'/util/Routing/Response.php';
    require_once __ROOT__.'/util/JWT.php';
    require __ROOT__.'/config/devel.php';

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    class UserUsecase {
        private $userDb;
        function __construct(UserDb $userDb){
            $this->userDb = $userDb;
        }
        
        function getProfile(Request $request){
            $user_storage_id = $_COOKIE["Authorization"];
            $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
            $ip_address = $_SERVER["REMOTE_ADDR"];

            $result = $this->userDb->getSessionStorage($user_storage_id, $http_user_agent,
            $ip_address);

            $user_id= $result['user_id'];
            $user= $this->userDb->getUserById($user_id);
            if ($user){
                $data = ["user"=>$user];
                render('profile.php', $data);
            }

            
        }

        function registerUser(Request $request){
            $username = $request->payload["username"];
            $fullname = $request->payload["fullname"];
            $email = $request->payload["email"];
            $address = $request->payload["address"];
            $phone = $request->payload["phone"];
            $card_number= $request->payload["card_number"];
            $password = $request->payload["password"];
            $hpass = hash('sha256', $password);

            if (!$this->userDb->isEmailOrUsernameExist($email,$username)){
                $user = new User(null,$username,$fullname,$email,$address,$phone,$card_number,$hpass);
                $user = $this->userDb->createUser($user);
                if ($user){
                    $payload = array(
                        "user_id"=> (int)$user->user_id,
                        "exp"=> time()+APP_CONFIG["jwt_duration"],
                        "username" => $username
                    );
                    setcookie("Authorization", $jwt["token"], time()+APP_CONFIG["cookie_duration"],"/");
                    header('Location: /browse/');                
                } else {
                    writeResponse(500, "Failed register user");
                }
            }
        }

        function getEditProfile(Request $request){
            $user_storage_id = $_COOKIE["Authorization"];
            $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
            $ip_address = $_SERVER["REMOTE_ADDR"];

            $result = $this->userDb->getSessionStorage($user_storage_id, $http_user_agent,
            $ip_address);

            $user_id= $result['user_id'];
            $user= $this->userDb->getUserById($user_id);

            if ($user){
                $data = ["user"=>$user];
                render('edit-profile.php', $data);
            }
        }

        function editProfile(Request $request){
            $user_storage_id = $_COOKIE["Authorization"];
            $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
            $ip_address = $_SERVER["REMOTE_ADDR"];

            $result = $this->userDb->getSessionStorage($user_storage_id, $http_user_agent,
            $ip_address);
            
            $user_id= $result['user_id'];
            $user= $this->userDb->getUserById($user_id);
        

            if ($user){
                $imageFile = $_FILES["profile_picture"];
                $uploadImage = $this->userDb->uploadImage($imageFile);

                $user->username = array_key_exists("username",$_POST) ? $_POST["username"] : $user->username;
                $user->fullname = array_key_exists("fullname",$_POST) ? $_POST["fullname"]: $user->fullname;
                $user->email = array_key_exists("email",$_POST) ? $_POST["email"] : $user->email;
                $user->address = array_key_exists("address",$_POST) ? $_POST["address"] : $user->address;
                $user->phone= array_key_exists("phone",$_POST) ? $_POST["phone"] : $user->phone;
                $user->card_number= array_key_exists("card_number",$_POST) ? $_POST["card_number"] : $user->card_number;
                if ($uploadImage["path"]){
                    $user->imgPath = $uploadImage["path"];
                }
                $newPass = array_key_exists("password",$request->payload) ? hash('sha256', $request->payload["username"]) : $user->getPassword();
                $user->setPassword($newPass);

                $user = $this->userDb->updateUser($user);

                if ($user){
                    header('Location: /profile/');
                    exit;
                }
            }
        }

        function removeUser(Request $request){
            $user_id = (int)$request->params["user_id"];
            if ($this->userDb->deleteUser($user_id)){
                writeResponse(200, "Success remove user");
            } else {
                writeResponse(500, "Success remove user");
            }
        }

        function login(Request $request){
            $username = $request->payload["username"];
            $password = $request->payload["password"];
            $hpass = hash('sha256', $password);
            $user_id = $this->userDb->authenticateUser($username, $hpass);
            if ($user_id) {
                $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $session_storage_id = generateRandomString(16);
                $expired_time = microtime(true) + 3600;
                $session_storage_id = $this->userDb->createSessionStorage($session_storage_id,
                                        $username, $hpass, $user_id, $http_user_agent, $ip_address, $expired_time);
                setcookie("Authorization", $session_storage_id, time() + 600, '/');
                if ($session_storage_id) {
                    header('Location: /browse/');
                    exit;
                }            
            } else {
                render('login.php',array("isError"=>true));
            }
        }

        function validateUsername(Request $request){
            $username = $request->queries["username"];
            $isExist = $this->userDb->isUsernameExist($username);
            if ($isExist) {
                writeResponse(200, "Username exist", $isExist);
            } else {
                writeResponse(200, "Username not exist", $isExist);
            }
        }
        
        function validateEmail(Request $request){
            $email = $request->queries["email"];
            $isExist = $this->userDb->isEmailExist($email);
            if ($isExist) {
                writeResponse(200, "Email exist", $isExist);
            } else {
                writeResponse(200, "Email not exist", $isExist);
            }
        }
    }

?>