<?php

/*** begin our session ***/
session_start();
/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );
/*** set the session form token ***/
$_SESSION['form_token'] = $form_token;
?>

<html>
<head>
<title>Login</title>
</head>

<body>
<center>
<h2>Login</h2>
<form action="dashboard.php" method="post">
<fieldset>
<p>
<label for="username">Username</label>
<input type="text" id="username" name="username" value="" maxlength="20" />
</p>
<p>
<label for="password">Password</label>
<input type="password" id="password" name="password" value="" maxlength="20" />
</p>
<p>
<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
<input type="submit" value="Login" />
</p>
</fieldset>
</form>
</center>
</body>
</html>
