<?php
require_once('./php_modules/field_checking.php');
require_once('./php_modules/db_controller.php');

// Global variables
$valid_inputs = false; 
$h2_title = "Congratulations Future Student!";
$user_message = "Your account has been created. Click the button below to login.";
$action = "login.php";
$button_message = "Login!";

if(isset($_POST['submitHidden'])){
    $contact_info = array(
        "fname" => htmlentities(filter_input(INPUT_POST,'fname')),
        "lname" => htmlentities(filter_input(INPUT_POST,'lname')),
        "email" => htmlentities(filter_input(INPUT_POST,"email")),
        "cell-phone" => htmlentities(filter_input(INPUT_POST,'cell-phone')),
        "home-phone" => htmlentities(filter_input(INPUT_POST,'home-phone'))
    );
    $address_info = array(
        "street_address" => htmlentities(filter_input(INPUT_POST,'street-address')),
        'city' => htmlentities(filter_input(INPUT_POST,'city')),
        'state' => htmlentities(filter_input(INPUT_POST,'state')),
        'zip_code' => htmlentities(filter_input(INPUT_POST,'zip')),
        'country' => htmlentities(filter_input(INPUT_POST,'country'))
    );
    $additional_info = array(
        'start_term' => htmlentities(filter_input(INPUT_POST,'start-term')),
        'program' => htmlentities(filter_input(INPUT_POST,'program')),
        'password' => htmlentities(filter_input(INPUT_POST,'create-password'))
    );

    $fname = $contact_info['fname'];
    $h2_title = "Congratulations $fname!";
    $required_fields = array_merge($contact_info,$additional_info);
  
    //$valid_inputs = check_required($required_fields);

    try{
        // Blank Fields
        not_empty($required_fields);
        // Phone
        handle_phone($required_fields['cell-phone']);
        handle_phone($required_fields['home-phone']);
        // Email
        check_email($required_fields['email']);
        // Password
        check_password($required_fields['password']);
        // Submit to database
        insert_into_db($required_fields,$address_info);
    }catch(Exception $e){
        $GLOBALS['h2_title'] = "Error!";
        $GLOBALS['user_message'] = $e->getMessage();
        $action = "apply.php";
        $button_message = "Try again!";
    }
}

function handle_phone($number){
    check_phone($number);
    $number = preg_replace("/[\(\)\- .\+]/","",$number);
}

function insert_into_db($required_fields,$address_info){
    $db_controller = new DB_CONTROLLER("localhost", "root", "", "nlaufenberg_hwc_db");

    try{
        $db_controller->connect_to_db();

        $last_person_id = $db_controller->get_specific_field("SELECT person_id FROM person ORDER BY person_id DESC LIMIT 1", 'person_id');
        $last_student_id = $db_controller->get_specific_field("SELECT student_id FROM student ORDER BY student_id DESC LIMIT 1", 'student_id');
        $current_person_id = check_id($last_person_id);
        $current_student_id = check_id($last_student_id);
        
        if(isset($current_person_id) && isset($current_student_id)){
            // Required fields
            $fname = $required_fields['fname'];
            $lname = $required_fields['lname'];
            $email = $required_fields['email'];
            $cell_phone = $required_fields['cell-phone'];
            $home_phone = $required_fields['home-phone'];
            $start_term = $required_fields['start_term'];
            $term_name = preg_replace("/[^a-zA-Z]+/","",$start_term);
            $term_year = preg_replace("/[^ \d]+/","",$start_term);
            $term_id = $db_controller->get_specific_field("SELECT term_id FROM term WHERE term_name = '$term_name' AND term_year = $term_year;", 'term_id');
          
            $program = $required_fields['program'];
            $program_id = $db_controller->get_specific_field("SELECT program_id FROM program
            WHERE program_name = '$program'", 'program_id');
       
            $password = $required_fields['password'];
            
            // Inserts everything for required except the student's classes
            $db_controller->execute_query("INSERT INTO person VALUES('$current_person_id','$fname','$lname','$cell_phone','$home_phone')");
            $db_controller->execute_query("INSERT INTO login_info 
            VALUES('$current_person_id','$email','$password')");
            $db_controller->execute_query("INSERT INTO student
            VALUES('$current_student_id', '$current_person_id')");
            $db_controller->execute_query("INSERT INTO student_program 
            VALUES('$current_student_id','$program_id')");
            $db_controller->execute_query("INSERT INTO student_term
            VALUES('$current_student_id','$term_id')");
          
            // Student Classes handling
            $result = $db_controller->execute_query("SELECT class_id FROM program_class WHERE program_id = $program_id");
          
            $row_number = mysqli_num_rows($result);
            for($i = 0; $i < $row_number; $i++){
                $class_row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                $class_id = $class_row['class_id'];
                $db_controller->execute_query("INSERT INTO grade VALUES ('$current_student_id','$class_id','NULL')");
               
            }

            //Address handling down here. If no info, MUST insert person_id
            $addresses = non_empty_addresses($address_info);
            $db_controller->execute_query("INSERT INTO address(person_id) VALUES ('$current_person_id')");
          
            if(!empty($addresses)){
                //Validate zip code
                if($addresses['zip_code']){
                    $addresses['zip_code'] = validate_zip($addresses['zip_code']);
                    if(!$addresses['zip_code']){
                        unset($addresses['zip_code']);
                    }
                }
                // Update for each filled in address
                foreach($addresses as $key => $value){
                    $db_controller->execute_query("UPDATE address SET $key = '$value' WHERE person_id = '$current_person_id'");   
                }   
            }
        }
        $db_controller->close_connection();
     
    }catch(mysqli_sql_exception $e){
        throw new Exception("Unable to make a student account due to database issues. Please try again or check back later.");
        echo $e;
    }
}

/**
 * Checks if the id exists and is valid. Otherwise, the id will be null
 */
function check_id($id){
    try{
        $current_id = ((int) $id) + 1;
    }catch(Exception $e){
        $current_id = null;
    }finally{
        return $current_id;
    }
    
}

/**
 * Functions returns non-empty addresses based on addresses array.
 * If the addresses array is empty, then it returns a new empty array;
 */
function non_empty_addresses($addresses){
    $new_addresses = array();
    foreach($addresses as $key => $value){
        if(!empty($value)){
            $new_addresses[$key] = $value;
        }
        
    }
    return $new_addresses;
}

// Checks if valid zip number and trims it. Returns NULL as a string if invalid
function validate_zip($zip){
    $zip_check = "/^\d{5}(-\d{4})?$/";
    if(!preg_match($zip_check,$zip)){
        return false;
    }
    $zip = preg_replace("/(-\d{4})$/","",$zip);
    return $zip;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Welcome to Hello World College. The perfect college for anything IT. With an acceptance rate of 100%, it's no wonder why we are the number one choice for education."
    />
    <meta
      name="keywords"
      content="college, IT school, college education,
    technology institute"
    />
    <title> Thanks for Applying! | Hello World College</title>
    <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/main.css" />
  </head>
  <body>
    <header id="form-header">
      <h1><a href="index.php">&lt;Hello World College/&gt;</a></h1>
    </header>
<main id="apply-results">
   
<form id="apply-results-form" class = "main-form" action = <?=$action?> >
    <div id = "form-header">
        <h2><?=$h2_title?></h2>
        <hr />
    </div>
    <p><?=$user_message?></p>
    <div id="form-actions">
        <button type="submit"><?=$button_message?></button>  
    </div>
</form>
</main>
<footer id="form-footer">
<div id="logo-footer">
<h1>
    <a href="index.php">&lt;Hello World College/&gt;</a>
</h1>
</div>
<div id="address-footer">
<p>
    Hello World College <br />
    345 Main St <br />
    Imaginary City, OH 99999 <br />
</p>
<p>
    555-555-5555 <br />
    John.Doe@gmail.com
</p>
<p>
    &copy; 2022 Hello World College <br />
    Site designed by Nicholas Laufenberg.
</p>
</div>
</footer>
  </body>
</html>

