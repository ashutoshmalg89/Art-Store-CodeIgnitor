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
  <h1>Assignment 4</h1>
</header>

<div id="registerform">
<form action="userRegister" method="POST" class="register" id="register">
  <table align="center">
    <tr><th colspan="2"><b> Register Here </b> </th></tr>
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
    <td> <label for="address" class="addr">Address :</label></td>
    <td><input type="text" required="required" name="address" id="address" placeholder="Address" oninvalid="this.setCustomValidity('Address cannot be blank')">
    </td>
    </tr>
    <tr>
    <td> <label for="phone" class="phn">Phone :</label></td>
    <td><input type="text" required="required" name="phone" id="phone" placeholder="Phone" oninvalid="this.setCustomValidity('Phone cannot be blank')">
    </td>
    </tr>
    <tr>
    <td> <label for="email" class="email">Email :</label></td>
    <td><input type="email" required="required" name="email" id="email" placeholder="Email" oninvalid="this.setCustomValidity('Email cannot be blank')">
    </td>
    </tr>
    <tr>
    <td>
    <input type="submit" value="Register" name="register">
        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
    </td>
    <td></td></tr>
    <tr><td></td><td></td></tr>
  </table>
</form>
</div>
<footer></footer>
</div>

</body>
</html>