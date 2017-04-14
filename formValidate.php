<?php
session_start();
$Firstnameerr='';
$Lastnameerr='';
$Emailerr='';
$Usernameerr='';
$Passworderr='';
$Confirmpasserr='';
$Dateerr='';
$Gendererr='';
$Locationerr='';
$Checkerr='';
$error=0;
include 'config.php';
if(isset($_POST['Submit']))
{
 if(empty($_POST['FirstName']))
 {
     $Firstnameerr="First Name required";
    $error=1;
 }
 if(empty($_POST['LastName']))
 {
     $Lastnameerr="Last Name required";
     $error=1;
 }
 if(empty($_POST['Email']))
 {
        $Emailerr="Email required";
     $error=1;
 }
 elseif (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
         $Emailerr = "Invalid email format";
     $error=1;
     }

 if(empty($_POST['Username'])){
     $Usernameerr="Username field required";
     $error=1;
 }
else{
 $Username=$_POST['Username'];
 $sql="SELECT * FROM User WHERE Username='$Username'";
        $result = $conn->query($sql);
        $numRows = $result->num_rows;
        if($numRows==1){
        $Usernameerr="Username already exists";
        $error=1;
}
} 
 if(empty($_POST['Password'])){
     $Passworderr="Password field required";
     $error=1;

 }
 elseif (!preg_match("#[0-9]+#", $_POST['Password'])) {
         $Passworderr = "Password Must Contain At Least 1 Number";
     $error=1;
     } elseif (!preg_match("#[A-Z]+#", $_POST['Password'])) {
         $Passworderr = "Password Must Contain At Least 1 Capital Letter";
     $error=1;
     } elseif (!preg_match("#[a-z]+#", $_POST['Password'])) {
         $Passworderr = "Password Must Contain At Least 1 Lowercase Letter";

     }elseif(strlen($_POST['Password'])<8)
  {
 $Passworderr = "Password length must be at least 8";
}

   if(empty($_POST['Confirmpassword'])){
        $Confirmpasserr="Confirm Password field required";
       $error=1;
    }
    elseif($_POST['Password']!=$_POST['Confirmpassword'])
        {
            $Confirmpasserr="Passwords dont match";
            $error=1;
        }

    if(empty($_POST['Birthdate'])){
        $Dateerr="Date field required";
        $error=1;
    }
    if(empty($_POST['Gender'])){
        $Gendererr="Gender field required";
        $error=1;
    }



 if(empty($_POST['Location'])){
     $Locationerr="Location field required";
     $error=1;
 }
 if(!isset($_POST['terms'])){
     $Checkerr="Please agree the terms";
     $error=1;
 }


if($error==0) {
    include 'config.php';
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Email = $_POST['Email'];
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $BirthDate = $_POST['Birthdate'];
    $Gender = $_POST['Gender'];
    $Location = $_POST['Location'];
    $Password = md5($Password);
    $sql = "INSERT INTO User VALUES (NULL,'$FirstName','$LastName','$Email','$Username','$Password','$BirthDate','$Gender','$Location','')";
    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully";


    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $sql1 = "SELECT ID from User WHERE Username='$Username'";
    $result = $conn->query($sql1);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $ID = $row['ID'];


        }
    }
    $_SESSION['id']=$ID;
    header("location: home.php");
}

}




?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <title>New User Sign-up</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .error{color:#F66733}
        .form{
    position: fixed;
  top: 50%;
  left: 50%;
  margin-top: -190px;
  margin-left: -275px;
    width:550px;
    padding:30px;
    /*margin:40px auto;*/
    
    color: black;
    border-radius: 10px;
    -webkit-border-radius:10px;
    -moz-border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(255, 83, 0, 1);
    -moz-box-shadow: 0px 0px 10px rgba(255, 83, 0, 1);
    -webkit-box-shadow: 0px 0px 10px rgba(255, 83, 0, 1);
}
a{
color:#ff5300;
}
td{
color: black;
}
.header {
            position:fixed;

            height:12%;
            width:100%;

            overflow:auto;
        }
		body{

padding-top: 50px;}
.form-signin {
    max-width: 330px;
    padding: 15px;
    margin: 0px auto;
    margin-top: 200px;
    
}

.navbar-fixed-top {
    border: 0px none;
    background-color:#F66733;
   padding-top:20px;
   
}

    </style>
    <script type="text/javascript">
        var datefield=document.createElement("input");
        datefield.setAttribute("type", "date");
        if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
            document.write('<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n');
            document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n');
            document.write('<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n');
        }
    </script>
   
    <script>
        if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
            jQuery(function($){ //on document.ready
                $('#birthdate').datepicker({ dateFormat: 'yy-mm-dd' });
            })
        }
    </script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  
     <a class="navbar-brand" href="home.php" style="color:white; padding-top:0px; padding-bottom:0px; font-size: 40px !important;">
MeTube
</a>
    </nav>


<div class="form">
<form name="signup" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h2 class="form-signin-heading">

    Please register

    </h2>
    <table>
        <tr>
            <td>First Name</td>
            <td><input type="text" name="FirstName"><span class="error"><?php echo $Firstnameerr; ?></span></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" name="LastName"><span class="error"><?php echo $Lastnameerr; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="Email"><span class="error"><?php echo $Emailerr; ?></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" name="Username"><span class="error"><?php echo $Usernameerr; ?></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="Password"><span class="error"><?php echo $Passworderr; ?></td></tr>
        <tr>
            <td><a href="#" onclick="window.alert('Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 digit and must have length of at least 8')">show password rules</a></td>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td><input type="password" name="Confirmpassword"><span class="error"><?php echo $Confirmpasserr; ?></td>
        </tr>
        <tr>
            <td>Birth Date</td>
            <td><input type="date" id="birthdate" name="Birthdate" value=""><span class="error"><?php echo $Dateerr; ?></td>
        </tr>
        <td>Gender</td>
        <td><input type="radio"  name="Gender" value="Male">Male<input type="radio" name="Gender" value="Female">Female<input type="radio" name="Gender" value="Other">Other<span class="error"><?php echo $Gendererr; ?></td>
        </tr>
        <tr>
            <td>Location</td>
            <td>
                <select name="Location">
                    <option value="">Country...</option>
                    <option value="Afganistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bonaire">Bonaire</option>
                    <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Canary Islands">Canary Islands</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Channel Islands">Channel Islands</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos Island">Cocos Island</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote DIvoire">Cote D'Ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Curaco">Curacao</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="East Timor">East Timor</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands">Falkland Islands</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Ter">French Southern Ter</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Great Britain">Great Britain</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Hawaii">Hawaii</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Isle of Man">Isle of Man</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea North">Korea North</option>
                    <option value="Korea Sout">Korea South</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Laos">Laos</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libya">Libya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macau">Macau</option>
                    <option value="Macedonia">Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Midway Islands">Midway Islands</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Nambia">Nambia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherland Antilles">Netherland Antilles</option>
                    <option value="Netherlands">Netherlands (Holland, Europe)</option>
                    <option value="Nevis">Nevis</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau Island">Palau Island</option>
                    <option value="Palestine">Palestine</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Phillipines">Philippines</option>
                    <option value="Pitcairn Island">Pitcairn Island</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Republic of Montenegro">Republic of Montenegro</option>
                    <option value="Republic of Serbia">Republic of Serbia</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russia">Russia</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="St Barthelemy">St Barthelemy</option>
                    <option value="St Eustatius">St Eustatius</option>
                    <option value="St Helena">St Helena</option>
                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                    <option value="St Lucia">St Lucia</option>
                    <option value="St Maarten">St Maarten</option>
                    <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                    <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                    <option value="Saipan">Saipan</option>
                    <option value="Samoa">Samoa</option>
                    <option value="Samoa American">Samoa American</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia">Serbia</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syria">Syria</option>
                    <option value="Tahiti">Tahiti</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Erimates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States of America">United States of America</option>
                    <option value="Uraguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City State">Vatican City State</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                    <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                    <option value="Wake Island">Wake Island</option>
                    <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zaire">Zaire</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                </select><span class="error"><?php echo $Locationerr; ?>
            </td>
        </tr>
    </table>

    <input type="checkbox" name="terms" value="terms">I agree to the terms and the conditions of MeTube&nbsp;<span class="error"><?php echo $Checkerr; ?><br>
    <input type="submit"  class="btn" name="Submit" value="Submit">

</form>
</div>
</body>

</html>
