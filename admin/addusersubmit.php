<?php
include_once __DIR__ . '/lib/DB.php';
/*** begin our session ***/
session_start();

/*** first check that both the username, password and form token have been sent ***/
if(!isset( $_POST['username'], $_POST['password'], $_POST['group_id'],$_POST['form_token']))
{
    $message = 'Please enter a valid username and password';
}
/*** check the form token is valid ***/
elseif( $_POST['form_token'] != $_SESSION['form_token'])
{
    $message = 'Invalid form submission';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4)
{
    $message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['username']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
/*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['password']) != true)
{
        /*** if there is no match ***/
        $message = "Password must be alpha numeric";
}
else
{
        $stmt = $dbh->prepare("SELECT users.username, users.password, users.group_id, groups.group_id
                                FROM groups INNER JOIN users ON groups.group_id = users.group_id
                                WHERE users.group_id = '1' AND user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $username = $stmt->fetchColumn();
        if($username == false)
        {
            $message = 'Access Denied';
        }
        else {
            /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $group_id   = filter_var($_POST['group_id'], FILTER_SANITIZE_STRING);

    /*** now we can encrypt the password ***/
    $password = '{SHA}' . base64_encode(sha1($password, true));
    try
    {
        /*** prepare the insert ***/
        $stmt = $dbh->prepare("INSERT INTO users (username, password, group_id ) VALUES (:username, :password, :group_id)");

        /*** bind the parameters ***/
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);
        $stmt->bindParam(':group_id', $group_id, PDO::PARAM_STR);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** unset the form token session variable ***/
        unset( $_SESSION['form_token'] );

        /*** if all is done, say thanks ***/
        $message = 'New user added';
    }
    catch(Exception $e)
    {
        /*** check if the username already exists ***/
        if( $e->getCode() == 23000)
        {
            $message = 'Username already exists';
        }
        else
        {
            /*** if we are here, something has gone wrong with the database ***/
            $message = 'We are unable to process your request. Please try again later"';
        }
}
    }
}
?>
<html>
<head>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<title>Successfull</title>
</head>
<body>
<p><?php echo $message; ?>
<br />
<button onclick="goBack()">Go Back</button>
</body>
</html>