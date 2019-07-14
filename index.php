<html>

  <head>
    <title>Sign Up Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link  href="css/styles.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Biryani|Pattaya|Rosario&display=swap" rel="stylesheet">
  </head>
  
  <body>
    <div id="container">
      <h1> Sign Up </h1>
        <form id="signupForm" method="post" action="welcome.html">
          First Name: <input type="text" name="fName"><br>
          Last Name:  <input type="text" name="lName"><br>
          Gender:     <input type="radio" name="gender" value="m"> Male
                      <input type="radio" name="gender" value="f"> Female<br><br>

          Zip Code: <input type="text" name="zip" id="zip"><br><br>
          City:      <span id="city"></span><br><br>
          Latitude:  <span id="latitude"></span><br><br>
          Longitude: <span id="longitude"></span><br><br>

          State:
          <select id="state" name="state">
              <option value="">Select One</option>
          </select><br />
          Select a County:  <select id="county"></select><br><br>

          Desired Username: <input type="text" id="username" name="username"><br>
                            <span id="usernameError"></span><br>
          Password:         <input type="password" id="password" name="password"><br>
                            <span id="passwordError"></span><br>
          Password Again:   <input type="password" id="passwordAgain"><br>
                            <span id="passwordAgainError"></span><br/><br>

          <input type="submit" value="Sign up!">
        </form>
    </div>
    <script>
        var usernameAvailable = false;
        //Displaying City form API after typing a zip code
        $("#zip").on("change", function(){
          //alert($("#zip").val());
          $.ajax({
            method: "GET",
            url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
            dataType: "json",
            data: { "zip" : $("#zip").val()},
            success: function(result,status) {
              //alert(result);
              $("#city").html(result.city);
              $("#latitude").html(result.latitude);
              $("#longitude").html(result.longitude);
            }
          });//ajax
        });//zip
         
        $.ajax({
          method: "GET",
          url: "https://cst336.herokuapp.com/projects/api/state_abbrAPI.php",
          dataType: "json",
          data: {"state": $("#state").val() },
          success: function(result,status){
            result.forEach(function(i){
              var abbr = i.usps.toLowerCase();
              $("#state").append("<option value='" + abbr + "'>" + i.state + "</option>");
            });
          }
        });//ajax
      
        $("#state").on("change", function(){
          //alert($("#state").val());
          $.ajax({
            method: "GET",
            url: "https://cst336.herokuapp.com/projects/api/countyListAPI.php",
            dataType: "json",
            data: { "state": $("#state").val() },
            success: function(result,status){
              //alert(result[0].county);
              $("#county").html("<option> Select One </option>");
              result.forEach(function(i){
                $("#county").append("<option>" + i.county + "</option>");              
              });
            }
          });//ajax
        });//state

        $("#username").change(function(){
          //alert($("#username").val());
          $.ajax({
            method: "GET",
            url: "https://cst336.herokuapp.com/projects/api/usernamesAPI.php",
            dataType: "json",
            data: { "username": $("#username").val() },
            success: function(result,status){
                if(result.available){
                  $("#usernameError").html("Username is available!");
                  $("#usernameError").css("color", "green");
                  usernameAvailable = true;
                }
                else{
                  $("#usernameError").html("Username is unavailable!");
                  $("#usernameError").css("color", "red");
                  usernameAvailable = false;
                }
            }
          });//ajax
        });//username

        $("#signupForm").on("submit", function(e){
          alert("Submitting form...");
            if(!isFormValid()){
              e.preventDefault();
            }
        });

      function isFormValid(){
        isValid = true;
        if(!usernameAvailable){
          isValid = false;
        }
        
        if($("#username").val().length == 0){
          isValid = false;
          $("#usernameError").html("Username is required");
          $("#usernameError").css("color", "red");
        }

        if($("#password").val() != $("#passwordAgain").val()){
          $("#passwordAgainError").html("Password Mismatch!");
          isValid = false;
        }
        
        if($("#password").val().length < 6){
          $("#passwordError").html("Password is less than 6 characters");
          $("#passwordError").css("color", "red");
          isValid = false;
        }
        
        return isValid;
      }
    </script>
  </body>
 
</html>