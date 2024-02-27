<?php

function validation(array $errors): array {
    function nameVerif(array $errors) {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];

            if (empty($name)) {
                return $errors['name'] = 'Name not be empty';
            } elseif (strlen($name) < 2) {
                return $errors['name'] = 'The name must have more than 2 characters';
            } else {
                return $name;
            }

        }
    }

    function emailVerif(array $errors) {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            if (empty($email)) {
                return $errors['email'] = 'Email not be empty';
            } elseif (strlen($email) < 2) {
                return $errors['email'] = 'The email must contain more than 2 characters';
            } else {
                return $email;
            }
        }
    }

    function pswVerif(array $errors)
    {
        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
        }

        if (isset($_POST['psw-repeat'])) {
            $passwordRep = $_POST['psw-repeat'];
        }

        if ($password !== $passwordRep) {
            return $errors['pwd'] = "Passwords don't match";
        } else {
            return $password;
        }

    }
    return $errors;
}



#*******************************************************************************************************
#*******************************************************************************************************
#*******************************************************************************************************



if (isset($_POST['name'])) {
    $name = $_POST['name'];

    if (empty($name)) {
        $errors['name'] = 'Name not be empty';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'The name must have more than 2 characters';
    }

} else {
    $errors['name'] = 'The name must be filled in';
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (empty($email)) {
        $errors['email'] = 'Email not be empty';
    } elseif (strlen($email) < 2) {
        $errors['email'] = 'The email must contain more than 2 characters';
    }

} else {
    $errors['email'] = 'The email must be filled in';
}

if (isset($_POST['psw'])) {
    $password = $_POST['psw'];
}

if (isset($_POST['psw-repeat'])) {
    $passwordRep = $_POST['psw-repeat'];
}

if ($password !== $passwordRep) {
    $errors['pwd'] = "Passwords don't match";
}



#*******************************************************************************************************
#*******************************************************************************************************
#*******************************************************************************************************



