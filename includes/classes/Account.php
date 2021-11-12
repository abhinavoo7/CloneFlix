<?php
 

    class Account{

        private $con;
        private $errorArray = array();

        public function  __construct($con) {
            $this->con = $con;
        }

        public function register($fname, $lname, $uname, $em, $em2, $pw, $pw2){
            $this->validateFirstName($fname);
            $this->validateLastName($lname);
            $this->validateUserName($uname);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray)){
                return $this->insertUserDetails($fname, $lname, $uname, $em, $pw);
            }

            return false;
        }

        public function login($uname, $pw){
            $pw = hash("sha512", $pw);

            $query = $this->con->prepare("Select * from users where username=:uname AND password=:pw");
            $query->bindValue(":uname", $uname);
            $query->bindValue(":pw", $pw);

            $query->execute();

            if($query->rowCount() == 1){
                return true;
            }

            array_push($this->errorArray, Constants::$loginFailed);

            return false;
        }

        private function insertUserDetails($fname, $lname, $uname, $em, $pw){            
            $pw = hash("sha512",$pw);

            $query = $this->con->prepare("Insert into users (firstName, lastName, username, email, password)
                                            Values (:fname, :lname, :uname, :em, :pw)");
            $query->bindValue(":fname", $fname);
            $query->bindValue(":lname", $lname);
            $query->bindValue(":uname", $uname);
            $query->bindValue(":em", $em);
            $query->bindValue(":pw", $pw);

            return $query->execute();
        }

        private function validateFirstName($fname){
            if(strlen($fname)<2 || strlen($fname)>50){
                array_push($this->errorArray, Constants::$firstNameCharacters);
            }
        }
        
        private function validateLastName($lname){
            if(strlen($lname)<2 || strlen($lname)>50){
                array_push($this->errorArray, Constants::$lastNameCharacters);
            }
        }
        private function validateUserName($uname){
            if(strlen($uname)<2 || strlen($uname)>50){
                array_push($this->errorArray, Constants::$userNameCharacters);
            }

            $query = $this->con->prepare("Select * from users where username=:uname");
            $query->bindValue(":uname", $uname);
            $query->execute();

            if($query->rowCount() > 0){
                array_push($this->errorArray, Constants::$userNameTaken);
            }
        }
        
        private function validateEmails($em, $em2){

            if (!filter_var($em, FILTER_VALIDATE_EMAIL) || !filter_var($em2, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }

            if($em != $em2){
                array_push($this->errorArray, Constants::$emailsDiffer);
                return;
            }
            
            $query = $this->con->prepare("Select * from users where email=:email");
            $query->bindValue(":email", $em);
            $query->execute();

            if($query->rowCount() > 0){
                array_push($this->errorArray, Constants::$emailUsed);
            }
        }
        
        private function validatePasswords($pw, $pw2){

        // if (!filter_var($pw, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/.{6,1000}/"))) || !filter_var($pw2,FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/.{6,1000}/"))) {
        //     array_push($this->errorArray, Constants::$emailInvalid);
        //     return;
        // }

            if (strlen($pw) < 6 || strlen($pw) > 25) {
                array_push($this->errorArray, Constants::$passwordLength);
                return;
        }

            if ($pw != $pw2) {
                array_push($this->errorArray, Constants::$passwordsDiffer);
                return;
            }
            
            if (strlen($pw2) < 6 || strlen($pw2) > 25) {
                array_push($this->errorArray, Constants::$passwordLength);
            }

        
        }

        public function getError($error){
            if(in_array($error, $this->errorArray)){
                return "<span class='errorMessage'>$error</span>";
            }
        }
    }

?>