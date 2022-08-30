<?php 
require_once('./php_modules/db_controller.php');
require_once('./php_modules/reusable_functions.php');
$error_message = "";

$db_controller = new DB_CONTROLLER("localhost", "root", "", "nlaufenberg_hwc_db");

if (!empty($_POST)) {
    fields_handling();
}

function fields_handling(){
    $email = htmlentities(filter_input(INPUT_POST,'email'));    
    $password = htmlentities(filter_input(INPUT_POST,'password'));
    if(check_field('email',$email) && check_field('password',$password)) send_to_student_hub_page();
}

function check_field($column,$column_value){
    $isValid = false;
    
    if(is_set_and_not_empty($column_value)){
        $isValid = check_field_in_database($column,$column_value);
    }else{
         $GLOBALS['error_message'] = "Please enter a valid email and password.";
    }

    if($isValid) return true;
    else return false;
}


function check_field_in_database($column,$column_value){
    $valid_field = "";
    
    $valid_field = database_handling($column,$column_value);

    if(is_set_and_not_empty($valid_field)) return true;
    else return false;
}

function database_handling($column,$column_value){
    global $db_controller;
    $query_fields = array("column"=>$column, "table"=>"login_info", "where_column"=>$column, "where_column_value"=>$column_value);
    $result = db_single_query_handling($db_controller, $query_fields);
    return $result; 
    
}

function send_to_student_hub_page(){
    session_start();
    $_SESSION = $_POST;
    session_write_close();
    header("Location: ./student_hub.php");
    exit;
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
    <title> Login Page | Hello World College</title>
    <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/main.css" />
  </head>
  <body>
    <header id="form-header">
      <h1><a href="index.php">&lt;Hello World College/&gt;</a></h1>
    </header>
<main id="login-content">
<form class="main-form" id = "login-form" method = "POST" action="login.php" >
    <div id = "form-header">
        <h2>Login</h2>
        <hr />
    </div>
    <p style = "color:red; margin:0.5rem 0rem;"><?=$error_message?></p>
    <fieldset>
        <div class="field-group" id="login-field-group">
        <div>
        <label for="email">Email </label>
       <br>
        <input type="text" name="email" id="email-input">
        </div>
        <div>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password-input" autocomplete = "on">
        </div>
        </div>
    </fieldset>
    <div id="form-actions">
        <button type="submit" name = "submitBtn">Login!</button>
        <br>
        <a href="apply.php">Need an account? Create an account</a>
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
    <script type="module" src="js/login.js"></script>
  </body>
</html>