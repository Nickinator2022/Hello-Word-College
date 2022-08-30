<?php 
/**
 * This function checks if the associative array's values are not empty or null.
 */
function not_empty($assoc_array){
    foreach($assoc_array as $key => $value){
        if(empty($value) || !isset($value)){
            throw new Exception("Error. Values cannot be empty");
        }
    }
}

// Check if the phone number's valid
function check_phone($number){
    $numeric_check = "/^\+?(1[ .-]?)?(\(?\d{3}\)?)[ .-]?\d{3}[ .-]?\d{4}$/";
    regular_exp_check($number, $numeric_check, "Phone number(s) must be valid 10-11 number(s).");
}

function regular_exp_check($value, $regExp, $exceptionMessage){
    $value = trim($value);
    if(!preg_match($regExp, $value)) throw new Exception($exceptionMessage);
}

// Checks if a valid email has been provided
function check_email($email){
    $email_check = "/^[_\w\-]+(\.[_\w\-]+)*@[\w\-]+(\.[\w\-]+)*(\.[\D]{2,6})$/";
    regular_exp_check($email, $email_check, "Email must be a valid email.");
}
// Checks if a valid password has been provided
function check_password($password){
    $password_check = "/^(?=.*\d)(?=.*[@!#$%^&*()])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z@!#$%^&*()]{8,}/";
    regular_exp_check($password, $password_check, "Password doesn't match requirements. Please try applying again.");
}

?>