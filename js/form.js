    var userNameAvailable = false;
    var pw = "";
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

    $("#state").on("change", function(){
      //alert($("#state").val());
      $.ajax({
        method: "GET",
        url: "https://cst336.herokuapp.com/projects/api/countyListAPI.php",
        dataType: "json",
        data: { "state": $("#state").val() },
        success: function(result,status){
          //alert(result[0].county);
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
        e.preventDefault();
    });

    $("#signupForm").on("submit", function(e){
      isValid = true;
      if(!userNameAvailable){
        isValid = false;
      }
      return isValid;
    });
  
function isFormValid(){
    isValid = true;
    if(!usernameAvailable){
      isValid = false;
    }
    
    if($("#username").val().length == 0){
      isValid = false;
      $("#usernameError").html("Username is required");
    }
    console.log($("password").val());
    if($("#password").val() != $("#passwordAgain").val()){
      console.log("conditional worked");
      $("#passwordAgainError").html("Password Mismatch!");
      isValid = false;
    }
    return isValid;
  }