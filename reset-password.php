<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
</head>
<style>
    .mainDiv {
    display: flex;
    min-height: 100%;
    align-items: center;
    justify-content: center;
    background-color: #f9f9f9;
    font-family: 'Open Sans', sans-serif;
  }
 .cardStyle {
    width: 500px;
    border-color: white;
    background: #fff;
    padding: 36px 0;
    border-radius: 4px;
    margin: 30px 0;
    box-shadow: 0px 0 2px 0 rgba(0,0,0,0.25);
  }
#signupLogo {
  max-height: 100px;
  margin: auto;
  display: flex;
  flex-direction: column;
}
.formTitle{
  font-weight: 600;
  margin-top: 20px;
  color: #2F2D3B;
  text-align: center;
}
.inputLabel {
  font-size: 12px;
  color: #555;
  margin-bottom: 6px;
  margin-top: 24px;
}
  .inputDiv {
    width: 70%;
    display: flex;
    flex-direction: column;
    margin: auto;
  }
input {
  height: 40px;
  font-size: 16px;
  border-radius: 4px;
  border: none;
  border: solid 1px #ccc;
  padding: 0 11px;
}
input:disabled {
  cursor: not-allowed;
  border: solid 1px #eee;
}
.buttonWrapper {
  margin-top: 40px;
}
  .submitButton {
    width: 70%;
    height: 40px;
    margin: auto;
    display: block;
    color: #fff;
    background-color: #065492;
    border-color: #065492;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 0 2px 0 rgba(0, 0, 0, 0.035);
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
  }
.submitButton:disabled,
button[disabled] {
  border: 1px solid #cccccc;
  background-color: #cccccc;
  color: #666666;
}

#loader {
  position: absolute;
  z-index: 1;
  margin: -2px 0 0 10px;
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #666666;
  width: 14px;
  height: 14px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<body>
<?php
    // Check if 'key' and 'token' parameters are present in the URL query string
    if (isset($_GET['key']) && isset($_GET['token'])) {
        require("includes/conn.php");
        $email = $_GET['key'];
        $token = $_GET['token'];
    
        // Prepare the SQL statement with named placeholders
        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `reset_link_token` = :token AND `email` = :email");
    
        // Bind parameters using named placeholders
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
    
        // Execute the statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $curDate = date("Y-m-d H:i:s");
    
        if ($result) {
            // Check if the token has not expired
            if ($result['exp_date'] >= $curDate) {
                ?>
                <div class="mainDiv">
                    <div class="cardStyle">
                        <form action="" method="post" name="signupForm" id="signupForm">
                            <img src="" id="signupLogo"/>
                            <h2 class="formTitle">Reset your password</h2>
                            <div class="inputDiv">
                                <input type="hidden" name="user_email" value="<?php echo $email; ?>">
                                <input type="hidden" name="reset_link_token" value="<?php echo $token; ?>">
                                <label class="inputLabel" for="password">New Password</label>
                                <input type="password" id="password" name="passwordreset" required>
                            </div>
                            <div class="inputDiv">
                                <label class="inputLabel" for="confirmPassword">Confirm Password</label>
                                <input type="password" id="confirmPassword" name="passwordconf">
                            </div>
                            <div class="buttonWrapper">
                                <button type="submit" name="reset" id="submitButton" class="submitButton">
                                    <span>Continue</span>
                                    <span id="loader"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            } else {
                // Display message if the reset link has expired
                echo "<div style='color:red; text-align:center;'>This reset link has expired</div>";
            }
        } else {
            echo "<div style='color:red; text-align:center;'>Invalid reset link</div>";
        }
    }


    if (isset($_POST['reset'])) {
      require 'includes/conn.php';
      $emailId = $_POST['user_email'];
      $token = $_POST['reset_link_token'];
      $password = $_POST['passwordreset'];
  
      $hashedpassword = sha1($password);
  
      $loginpage = 'https://citizen-apptment.cleverapps.io/index2.php';
      $reset = 'https://citizen-apptment.cleverapps.io/reset-password.php';
  
      // Prepare the statement to check if the token and email match
      $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `reset_link_token` = :token AND `email` = :email");
      $stmt->bindParam(':token', $token);
      $stmt->bindParam(':email', $emailId);
      $stmt->execute();
      $row = $stmt->rowCount(); // Use rowCount() to check the number of rows
  
      $exp = "0000-00-00";
      if ($row) {
          // Prepare the update statement
          $stmt = $pdo->prepare("UPDATE `users` SET `password` = :password, `reset_link_token` = NULL, `exp_date` = :exp_date WHERE `email` = :email");
          $stmt->bindParam(':password', $hashedpassword);
          $stmt->bindParam(':exp_date', $exp);
          $stmt->bindParam(':email', $emailId);
          $stmt->execute();
          echo "<p style='text-align: center; color:green;'>Congratulations! Your password has been updated successfully <a href='$loginpage'>Login</a></p>";
      } else {
          echo "<h1 style='text-align: center; color:red;'>This reset link is invalid or has expired. <a href='$reset' style='color:red;'>Please try again!</a></h1>";
      }
  }
  

    ?>
<script>
    var password = document.getElementById("password");
    var confirm_password = document.getElementById("confirmPassword");

document.getElementById('signupLogo').src = "https://s3-us-west-2.amazonaws.com/shipsy-public-assets/shipsy/SHIPSY_LOGO_BIRD_BLUE.png";
enableSubmitButton();

function validatePassword() {
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
    return false;
  } else {
    confirm_password.setCustomValidity('');
    return true;
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

function enableSubmitButton() {
  document.getElementById('submitButton').disabled = false;
  document.getElementById('loader').style.display = 'none';
}

function disableSubmitButton() {
  document.getElementById('submitButton').disabled = true;
  document.getElementById('loader').style.display = 'unset';
}

function validateSignupForm() {
  var form = document.getElementById('signupForm');
  
  for(var i=0; i < form.elements.length; i++){
      if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
        console.log('There are some required fields!');
        return false;
      }
    }
  
  if (!validatePassword()) {
    return false;
  }
  
  onSignup();
}

function onSignup() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    
    disableSubmitButton();
    
    if (this.readyState == 4 && this.status == 200) {
      enableSubmitButton();
    }
    else {
      console.log('AJAX call failed!');
      setTimeout(function(){
        enableSubmitButton();
      }, 1000);
    }
    
  };
  
  xhttp.open("GET", "ajax_info.txt", true);
  xhttp.send();
}
</script>
</body>
</html>