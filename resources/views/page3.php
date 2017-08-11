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

.search{
	border: 1px solid black;
	padding: 50px;
}  

.searchresult{
	width: 75%;
	float: left;
	padding: 15px;
	border: 1px solid black;
}

.logout{
	width: 25%;
	float: left;
	padding: 15px;
	border: 1px solid black;
}
.cart{
	width: 25%;
	float: right;
	padding: 15px;
	border: 1px solid black;
}
</style>


</head>
<body>

<div class="flex-container">
<header>
  <h1> Welcome <?php echo session('active_user')?></h1>
  
  <div class="logout">
      <form action="logout" method="POST">
          <input type="submit" name="logout" value="Logout">
          <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
      </form>
  </div>
</header>
<div class="search">
<?php
echo $msg;
?>
</div>
