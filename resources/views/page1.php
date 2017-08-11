<?php
session_start();
$errorMsg	= '';

if(isset($_SESSION['currUser']) && $_SESSION['currUser'] != '') {
	header("location:page2.php");
} else {
	if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] != '') {
		$errorMsg = $_SESSION['errorMsg'];
		unset($_SESSION['errorMsg']);
	}
}

if(isset($errorMsg) && $errorMsg != '') {
	echo $errorMsg;
}
?>
<!DOCTYPE html>
<html>
<head>
<style> 
.flex-container {
    display: -webkit-flex;
    display: flex;  
    -webkit-flex-flow: row wrap;
    flex-flow: row wrap;
    text-align: center;
}

.flex-container > * {
    padding: 15px;
    -webkit-flex: 1 100%;
    flex: 1 100%;
}

header {background: black;color:white;}
footer {background: #aaa;color:white;}

.nav ul {
    list-style-type: none;
  padding: 0;
}
      
</style>
<script type="text/javascript">
  

</script>

</head>
<body>

<div class="flex-container">
<header>
  <h1>Assignment 6</h1>
</header>
<div id="loginform">
  <table align="center">
  <form action="login" method="POST" class="login" id="login">
    <tr><th colspan="2"><b> Login Here </b> </th></tr>
    <tr>
    <td><label for="username" class="uname">Username :</label></td>
    <td><input type="text" required="required" name="username" id="username" placeholder="Enter Username" oninvalid="this.setCustomValidity('Username cannot be blank')">
    </td>
    </tr>
    <tr>
    <td> <label for="password" class="pwd">Password :</label></td>
    <td><input type="password" required="required" name="password" id="password" placeholder="Enter Password" oninvalid="this.setCustomValidity('Password cannot be blank')">
    </td>
    </tr>
    <tr>
    <td>
    <input type="submit" value="Login" onclick="return validate()">
        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
    </td></form>
    <td><form action="register" method="POST">
            <input type="submit" name="register" value="Register">
            <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
        </form></td></tr>
  </table>

</div>
<footer></footer>
</div>

</body>
</html>