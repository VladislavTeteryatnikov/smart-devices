<?php

    class Validation
    {
        public function checkLength($string, $lengthMax = 255, $lengthMin = 2)
        {
            if (mb_strlen($string) >= $lengthMax || mb_strlen($string) < $lengthMin) {
                return true;
            }
        }

        public function userNameCheck($name)
        {
            if (!preg_match("~^[а-яё]+$~ui", $name)) {
                return true;
            }
        }

        public function manufacturerNameCheck($nameManufacturer)
        {
            if (!preg_match("~^[\w'&\- ]+$~ui", $nameManufacturer)) {
                return true;
            }
        }

        public function emailCheck($email)
        {
            if (!preg_match("~^[\w\.%+-]+@[a-z0-9-]+\.[a-z]{2,4}$~i", $email)) {
                return true;
            }
        }

        public function passwordCheck($password)
        {
            if (!preg_match("~^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,10}$~", $password)) {
                return true;
            }
        }

        public function addressCheck($address)
        {
            if (!preg_match("~^[а-я \.,\-\d№]*$~ui", $address)) {
                return true;
            }
        }

        public function validateRecaptcha()
        {
            $error = true;
            $secret = '6LfJd-QmAAAAACC40rR9HJqeKfE53qvb6cmrMelG';
            if (!empty($_POST['g-recaptcha-response'])) {
                $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
                $out = curl_exec($curl);
                curl_close($curl);

                $out = json_decode($out);
                if ($out->success == true) {
                    $error = false;
                }
            }
            return $error;

        }

    }
