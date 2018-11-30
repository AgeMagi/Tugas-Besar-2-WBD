<link rel="stylesheet" href="/static/css/login.css">
<link rel="stylesheet" href="/static/css/base.css">
<meta name="google-signin-client_id" content="1060991174100-25djgbghs9gumj5lra1ns4a8q5j332kb.apps.googleusercontent.com">

<title>Login</title>

<div class="container">
    <form class="form" id="form_login" action="/login/" method="POST" onSubmit="return validateForm()">
        <h1 class="form-title">LOGIN</h1>
        <div class="row">
            <label for="username_form" class="form-label">Username</label>
            <input class="form-input" type="text" name="username" id="username_form" required>
        </div>
        <div class="row">
            <label for="password_form" class="form-label">Password</label>
            <input class="form-input" type="password" name="password" id="password_form" required>
        </div>
        <a class="register-link" href="/register/">Don't have an account?</a>
        <br>
        <div class="submit-row">
            <input class="submit-button" type="submit" id="login_button" value="LOGIN">
        </div>
        
    </form>
    <div class="g-signin2" data-onsuccess="onSignIn"></div>
	<a href="#" onclick="signOut();">Sign out</a>
</div>

<script src="/static/js/login.js"></script>

<?php
    if ($isError){
        echo "<script>alert(\"Wrong username or password\")</script>";
    }
    include __STATIC__.'/html/footer.html';
?>

<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
	function onSignIn(googleUser) {
		  var profile = googleUser.getBasicProfile();
		  var gId = profile.getId();
          var gName = profile.getName();
          var gImage = profile.getImageUrl();
          var gEmail = profile.getEmail();
          var str = gEmail.split("@");
          var gUname = str[0];

          document.getElementById("username_form").value = gUname;
          document.getElementById("password_form").value = gId;

          console.log(gId);
         // document.getElementById("form_login").submit();
         // signOut();
		}

  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }

</script>