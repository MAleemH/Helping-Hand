<?php

    class Signup extends Dbh {
        protected function setUser($username, $password, $email) {
            $stmt = $this->connect()->prepare('INSERT INTO users (users_username, users_password, users_email) VALUES (?, ?, ?);');

            $hasedPassword = password_hash($password, PASSWORD_DEFAULT);  

            if(!$stmt->execute(array($username, $hasedPassword, $email))) {
                $stmt = null;
                header("Location: ../index.php?error=stmtfailed");
                exit();
            }

            $stmt = null;
        }
        protected function checkUser($username, $email) {
            $stmt = $this->connect()->prepare('SELECT users_username FROM users WHERE users_username = ? OR users_email = ?;');
            if(!$stmt->execute(array($username, $email))) {
                $stmt = null;
                header("Location: ../index.php?error=stmtfailed");
                exit();
            }

            $resultCheck = false;
            if($stmt->rowCount() > 0) {
                $resultCheck = false;
            } else {
                $resultCheck = true;
            }

            return $resultCheck;
        }
    }