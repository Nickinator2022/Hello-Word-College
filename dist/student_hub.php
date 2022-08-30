<?php
require_once('./php_modules/db_controller.php');
require_once('./php_modules/reusable_functions.php');
$db_controller = new DB_CONTROLLER("localhost", "root", "", "nlaufenberg_hwc_db");
$error_message = "";

$email = "";
$password = "";
$name = "";
$home_phone = "";
$cell_phone = "";

session_start();

if(check_email_and_password_session()){
    $email = $_SESSION['email'];
    $password = $_SESSION['email'];
    set_student_fields();
    
}else{
    header("Location: ./login.php");
    exit;
}

function check_email_and_password_session(){
    if(is_set_and_not_empty($_SESSION['email']) && is_set_and_not_empty($_SESSION['password'])){
    return true;
    }else{
    return false;
    }
}

function set_student_fields(){
    global $name,$home_phone,$cell_phone;
    $person_id = get_person_id();
    
    if(is_set_and_not_empty($person_id)){
        $first_name = get_person_field_based_on_id($person_id,'first_name');
        $last_name = get_person_field_based_on_id($person_id,'last_name');
        $name = $first_name . ' ' . $last_name;
        $home_phone = get_person_field_based_on_id($person_id,'home_phone');
        $home_phone = format_phone_number($home_phone);
        $cell_phone = get_person_field_based_on_id($person_id,'cell_phone');
        $cell_phone = format_phone_number($cell_phone);
    }

}

function get_person_id(){
    // Assuming email addresses are unique
    global $email;
    global $db_controller;
    $query_fields = array("column"=>"person_id", "table"=>"login_info", "where_column"=>"email", "where_column_value"=>$email);
   
    $result = db_single_query_handling($db_controller, $query_fields);
    return $result;
}

function get_person_field_based_on_id($id,$column){
    global $db_controller;
    $query_fields = array("column"=>$column, "table"=>"person", "where_column"=>"person_id", "where_column_value"=>$id);
    
    $result = db_single_query_handling($db_controller, $query_fields);
    return $result;
}

function format_phone_number($phone_number_string){
    $string_length = strlen($phone_number_string);
    if($string_length === 10){
        $phone_number_string = substr_replace($phone_number_string,"-",3,0);
        $phone_number_string = substr_replace($phone_number_string,"-",7,0);
    }else if($string_length === 11){
        $phone_number_string = substr_replace($phone_number_string,"-",1,0);
        $phone_number_string = substr_replace($phone_number_string,"-",5,0);
        $phone_number_string = substr_replace($phone_number_string,"-",9,0);
    }
        
    return $phone_number_string;
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
    <title>
    Student Hub
    </title>
    <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/main.css" />
  </head>
  <body>
    <header>
      <h1><a href="student_hub.php">&lt;Student Hub/&gt;</a></h1>
      <nav>
          </nav>
    </header>
<main id="student-hub-content">
<div id="student-hub-nav">
    <div id="nav-header"></div>
</div>
<div id="student-info">
    <div id="student-info-header">
        <h2>Student Information</h2>
        <hr />
    </div>
    <p>Name: <span><?=$name ?></span></p>
    <p>Email: <span><?=$email ?></span></p>
    <p>Home Phone: <span><?=$home_phone ?></span></p>
    <p>Cell Phone: <span><?=$cell_phone ?></span></p>
</div>
</main>
<footer>
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