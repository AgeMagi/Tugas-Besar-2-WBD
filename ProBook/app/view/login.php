<link rel="stylesheet" href="/static/css/login.css">
<link rel="stylesheet" href="/static/css/base.css">

<title>Login</title>

<div class="container">
    <form class="form" action="/login/" method="POST" onSubmit="return validateForm()">
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
</div>

<script src="/static/js/login.js"></script>

<?php
    if ($isError){
        echo "<script>alert(\"Wrong username or password\")</script>";
    }
    include __STATIC__.'/html/footer.html';
?>