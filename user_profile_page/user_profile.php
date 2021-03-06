<?php include('../resources/header.php'); ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Edit Profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link type="text/css" rel="stylesheet" href="../resources/style.css" />
    <link type="text/css" rel="stylesheet" href="resources/style_user_page.css" />
    <link href="https://fonts.googleapis.com/css?family=Bowlby+One+SC" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Suez+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <header>
    <ul id="homebar">
      <li><a href="../index.php"> HOME </a></li>
      <div class="right">
        <?php include('../resources/menubar.php'); ?>

      </div>
    </ul>
  </header>

  <body>

    <!-- php to upload all form data to database or delete user for database -->
    <?php
      // connect to database           
      $dbname = 'websysproject';
      $user = 'root';
      $pass = '';             
      $conn = mysqli_connect("localhost", $user, $pass, $dbname);

      // Check connection
      if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

      $UserName = $_SESSION['username'];
      echo("<script>var uname = '" . $UserName . "';</script>");

      // check if save button pressed  
      if (isset($_POST['save']) && $_POST['save'] == 'Save') {
        // declare all vars for easy submission
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $preferredjob = $_POST['preferredjob'];
        $skill1 = $_POST['skill1'];
        $skill2 = $_POST['skill2'];
        $skill3 = $_POST['skill3'];
        $skill4 = $_POST['skill4'];
        $linkdinlink = $_POST['linkdinlink'];
        $biography = $_POST['biography'];
        
        $sql = "UPDATE users SET FirstName='$firstname', LastName='$lastname', Email='$email', PreferredJob='$preferredjob', LinkdinLink='$linkdinlink', Biography='$biography', Skill1='$skill1', Skill2='$skill2', Skill3='$skill3', Skill4='$skill4' WHERE username='$UserName' LIMIT 1";

        mysqli_query($conn, $sql);

        
        /*
        $imgData = addslashes(file_get_contents($_FILES['userImage']));

        $sql = "UPDATE users SET image = VALUES('{$imgData}') WHERE username=".$UserName." LIMIT 1";

        $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
        if (isset($current_id)) {
          header("Location: listImages.php");
        */
      }
      if (isset($_POST['submit_image']) && $_POST['submit_image'] == 'Upload Image') {
        $imgData = addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
        $sql = "UPDATE users SET image='$imgData' WHERE username='$UserName' LIMIT 1";
        mysqli_query($conn, $sql);
      }
    ?>

    <div id="user-acount-page-wrapper">
      <h1>Edit Profile</h1>
      <table id="table-outer">
        <tr>
          <th style="float: right;">
            <!-- php to load image upload to database -->
            <?php
            /*
              //session_start();
              //$_SESSION['UserID'] = 1; // set user id for debugging
              
              $UserName = $_SESSION['username'];

              if (count($_FILES) > 0) {
                
                if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
                  //require_once "db.php";
                
                  $imgData = addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
                  
                  $sql = "UPDATE users SET image = VALUES('{$imgData}') WHERE username='".$UserName."' LIMIT 1";
                  $current_id = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
                  if (isset($current_id)) {
                    header("Location: listImages.php");
                  }
                }
              }
            */
            ?>

            <!-- profile photo, on click bring up file browser to pick new image, save to database -->
            <div id="image-wrapper">
              <form id="image-upload-form" enctype="multipart/form-data" action="user_profile.php" method="post">    

                <img id="display-image" src="resources/default_user_photo.png" alt="User Photo" width="170px" height="170px"/>
                
                <br>
                <br>

                <input id="input-image" name="userImage" type="file" onchange="readURL(this);">
                <label id="choose-file-button" for="input-image">Choose a Picture</label>
                <script type="text/javascript">
                  function readURL(input) {
                    if (input.files && input.files[0]) {
                      var reader = new FileReader();

                      reader.onload = function (e) {
                          $('#display-image')
                              .attr('src', e.target.result)
                              .width(170)
                              .height(170);
                      };

                      reader.readAsDataURL(input.files[0]);
                    }
                  }              
                </script>

                <br>
                <br>

                <input id="upload-file-button" type="submit" name="submit_image" value="Upload Image">
              </form>
            </div>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>

            <table id="buttonTable">
              <tr>
                <th>
                  <!-- button to clear current form data to form -->
                  <script type="text/javascript">
                    function clearFields() {
                      document.getElementById("firstname").value = "";
                      document.getElementById("lastname").value = "";
                      document.getElementById("preferredjob").value = "";
                      document.getElementById("skill-1").value = "";
                      document.getElementById("skill-2").value = "";
                      document.getElementById("skill-3").value = "";
                      document.getElementById("skill-4").value = "";
                      document.getElementById("contact-email").value = "";
                      document.getElementById("biography").value = "";
                    };
                  </script>
                  <button type="button" class="controleButton" id="clearButton" onclick="clearFields();">Clear</button>
                </th>
                <!--
                <th>
        
                  <button style="visibility: hidden;"><label for="submit-user-data" type="button" class="controleButton" id="saveButton" value="Save" name="save" onclick="submitForms();" style="visibility: visible;">Save</label></button>
                  <script type="text/javascript">
                    /*
                    function submitForms() {
                      document.getElementById("image-upload-form").submit();
                    };
                    */
                  </script>
                </th>
            -->
              </tr>
              <tr>
                <th>
                  <!-- button to delete user from database -->
                  <script>
                    function deleteAccount() {
                      if (confirm('Are you sure you want to completely delete your account? All of your account data will be erased and unrecoverable.')) {
                        $.post('user_profile.php', {delete: 1}, function() {
                          location.href = "../index.php";
                        });
                      }
                    }
                  </script>

                  <button type="button" class="controleButton" id="deleteButton" onclick="deleteAccount()">Delete</button>
                </th>
                <th>
                  <!-- button to exit out of edit mode and view the page normaly -->
                  <button type="button" class="controleButton" id="viewButton" onclick="window.location = 'user_profile_view.php?target='+uname;">View</button>               
                </th>
              </tr>
            </table>

          </th>
          <th>
            <div id="user-data-form-wrapper">

              <?php
                // connect to database           
                $dbname = 'websysproject';
                $user = 'root';
                $pass = '';
                $conn = mysqli_connect("localhost", $user, $pass, $dbname);

                // Check connection
                if (mysqli_connect_errno()) {
                  echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                $UserName = $_SESSION['username'];

                $sql = "SELECT * FROM users WHERE username='".$UserName."' LIMIT 1";
                $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

                //echo "<table>";
                while($row = mysqli_fetch_assoc($result)){
                  $image_data = $row['image'];
                  //echo '<img src="data:image/png;base64,'.base64_encode( $image_data ).'"/>';
                  $new_image_attr = "data:image/png;base64,".base64_encode( $image_data );
                  //document.getElementsById("display-image").setAttribute("scr", "data:image/png;base64,'.base64_encode( $image_data ).'");

                  echo "<script type='text/javascript'>
                          document.getElementById('display-image').setAttribute('src', '".$new_image_attr."');
                        </script>";
                                    
                  $first_name = $row['FirstName'];
                  $last_name = $row['LastName'];
                  $email = $row['Email'];
                  $skill_1 = $row['Skill1'];
                  $skill_2 = $row['Skill2'];
                  $skill_3 = $row['Skill3'];
                  $skill_4 = $row['Skill4'];
                  $linkdin = $row['LinkdinLink'];
                  $preferred_job = $row['PreferredJob'];
                  $biography = $row['Biography'];

                  echo '<!-- form for user data, should pull current values from database to fill fields -->
                        <form id="user-data-form" method="post" action="user_profile.php">
                          <!-- name data -->
                          <textarea name="firstname" class="input-field" type="text" id="firstname" placeholder="First Name" rows="1" maxlength="25" >'.$first_name.'</textarea><br>
                          <textarea name="lastname" class="input-field" type="text" id="lastname" placeholder="Last Name" rows="1" maxlength="25">'.$last_name.'</textarea><br>

                          <textarea name="preferredjob" class="input-field" type="text" id="preferredjob" placeholder="Preferred Job" rows="1" maxlength="50">'.$preferred_job.'</textarea><br>

                          <!-- top skills input -->
                          <textarea name="skill1" class="input-field" type="text" id="skill-1" placeholder="Skill 1" rows="1" maxlength="25">'.$skill_1.'</textarea>
                          <textarea name="skill2" class="input-field" type="text" id="skill-2" placeholder="Skill 2" rows="1" maxlength="25">'.$skill_2.'</textarea><br>
                          <textarea name="skill3" class="input-field" type="text" id="skill-3" placeholder="Skill 3" rows="1" maxlength="25">'.$skill_3.'</textarea>
                          <textarea name="skill4" class="input-field" type="text" id="skill-4" placeholder="Skill 4" rows="1" maxlength="25">'.$skill_4.'</textarea><br>

                          <textarea name="email" class="large-input-field" type="text" id="contact-email" placeholder="Contact Email" rows="1" maxlength="50">'.$email.'</textarea><br>

                          <textarea name="linkdinlink" class="large-input-field" type="text" id="linkdin-link" placeholder="Linkdin Link" rows="1" maxlength="50">'.$linkdin.'</textarea><br>

                          <textarea name="biography" id="biography" class="input-field" type="text" placeholder="Biography..." rows="8" maxlength="440">'.$biography.'</textarea>
                          
                          <br>


                          <!-- button to save current form data to database -->
                          <button for="submit-user-data" type="submit" class="controleButton" id="saveButton" value="Save" name="save" onclick="submitForms();" style="visibility: visible;">Save</button>

                        </form> ';
                }              
                // if deteting account
                if (isset($_POST['delete'])) {
                  $sql = "DELETE FROM users WHERE username='".$UserName."';";
                  $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
                  // delete session
                  
                }
              ?>
            </div>

          </th> 
        </tr>
      </table>

      
    </div>
    <?php include('../resources/footer.php'); ?>
  </body>
</html>