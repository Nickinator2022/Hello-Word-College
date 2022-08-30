<?php
  $countries = array('Afghanistan','Albania','Algeria','Andorra','Angola','Antigua & Deps','Argentina','Armenia','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina','Burundi','Cambodia','Cameroon','Canada','Cape Verde','Central African Rep','Chad','Chile','China','Colombia','Comoros','Congo','Congo (Democratic Rep)','Costa Rica','Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','East Timor','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Ethiopia','Fiji','Finland','France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti','Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland {Republic}','Israel','Italy','Ivory Coast','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Korea North','Korea South','Kosovo','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Macedonia','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar,','Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','Norway','Oman','Pakistan','Palau','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar','Romania','Russian Federation','Rwanda','St Kitts & Nevis','St Lucia','Saint Vincent & the Grenadines','Samoa','San Marino','Sao Tome & Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Swaziland','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania','Thailand','Togo','Tonga','Trinidad & Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe');
  
  $programs = array("Cybersecurity","Data Analytics","Graphic/Web Design","Network Administration","Software Development","Web Development");

  function generate_custom_option_tag($value, $text){
    return "<option value = \"$value\">$text</option>";
  }

  function determine_semesters($month,$year){
      // Current Semester: Fall
    if($month >= 9 && $month <= 12){
        $future_year = $year + 1;
        echo generate_custom_option_tag("Fall $future_year", "Fall $future_year");
        echo generate_custom_option_tag("Spring $future_year", "Spring $future_year");
        echo generate_custom_option_tag("Summer $future_year", "Summer $future_year");
    }
    // Current Semester: Spring
    else if($month >= 1 && $month <= 4){
        $future_year = $year + 1;
        echo generate_custom_option_tag("Summer $year", "Summer $year");
        echo generate_custom_option_tag("Fall $year", "Fall $year");
        echo generate_custom_option_tag("Spring $future_year", "Spring $future_year");
    }
    // Current Semester: Summer
    else{
        $future_year = $year + 1;
        echo generate_custom_option_tag("Fall $year", "Fall $year");
        echo generate_custom_option_tag("Spring $future_year", "Spring $future_year");
        echo generate_custom_option_tag("Summer $future_year", "Summer $future_year");
    }
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
    <title> Apply Today! | Hello World College</title>
    <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/main.css" />
  </head>
  <body>
    <header id="form-header">
      <h1><a href="index.php">&lt;Hello World College/&gt;</a></h1>
    </header>
<main id="apply-content">
<form class = "main-form" id = "apply-form" action="apply_results.php" method = "POST">
    <div id = "form-header">
        <h2>Create an Account to Apply</h2>
        <hr />
    </div>
    <fieldset>
       <h3>Contact Information</h3>
       <div class="field-group">
        <div>
       <label for="fname">First Name  </label>
       <br>
        <input type="text" name="fname" id="fname-input">
        </div>

        <div>
       <label for="lname">Last Name </label>
       <br>
        <input type="text" name="lname" id="lname-input">
       </div>

       <div>
       <label for="email">Email </label>
       <br>
        <input type="text" name="email" id="email-input">
        </div>

        <div><label for="confirm-email">Confirm Email </label>
        <br>
        <input type="text" name="confirm-email" id="confirm-email-input"></div>
       
      <div><label for="cell-phone">Cell Phone</label>
      <br>
        <input type="text" name="cell-phone" id="cell-phone-input"></div>

        <div>
       <label for="home-phone">Home Phone  </label>
       <br>
        <input type="text" name="home-phone" id="home-phone-input">
      </div>
       
       </div>
    </fieldset>
    <fieldset>
        <h3>Address Information</h3>
        <div class="field-group">
        <div>
        <label for="street-address">Street Address</label>
        <br>
        <input type="text" name="street-address" id="street-address-input">
        </div>
        <div>
        <label for="city">City</label>
        <br>
        <input type="text" name="city" id="city-input">
        </div>
        <div>
        <label for="state">State/Region</label>
        <br>
        <input type="text" name="state" id="state-input">
        </div>
        <div>
        <label for="zip">ZIP/Postal Code</label>
        <br>
        <input type="text" name="zip" id="zip-input">
        </div>
        <div>
        <label for="country">Country</label>
        <br>
        <select name="country" id="country-select">
            <?php 
            echo generate_custom_option_tag("","Select Country");
            foreach($countries as $country){
              echo generate_custom_option_tag($country,$country);
            }
            ?>
        </select>
        </div>
        </div>
    </fieldset>
    <fieldset>
        <h3>Additional Information</h3>
        <div class="field-group">
            <div>
        <label for="start-term">Start Term</label> 
        <br>
        <select name="start-term" id="start-term-select">
            <?php
            /*
            Determines the appropriate semester years based on the current month
            as well as the current year
            */
            
            date_default_timezone_set('UTC');
            $date = getdate();
            $month = $date["mon"];
            $year = $date["year"];
            determine_semesters($month,$year);
            ?>
        </select>
        </div>
        <div>
        <label for="program">Program</label>
        <br>
        <select name="program" id="program-select">
            <?php 
            foreach($programs as $program){
              echo generate_custom_option_tag($program, $program);
            }
            ?>
        </select>
        </div>
        <div id="create-password-div">
        <label for="create-password">Create Password</label>
        <br>
        <input type="password" name="create-password" id="create-password-input" autocomplete = "on">
        </div>
        <div id="confirm-password-div">
        <label for="confirm-password">Confirm Password</label>
        <br>
        <input type="password" name="confirm-password" id="confirm-password-input" autocomplete = "on">
        </div>
        </div>
    </fieldset>
    <div id="form-actions">
        <button type="submit" name = "submitBtn">Apply!</button>
        <br>
        <a href="login.php">Already applied? Login!</a>
    </div>

    <input type="hidden" name="submitHidden" value="Form Submitted">
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
    <script type = "module" src="./js/apply_form.js"></script>
  </body>
</html>