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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        var token = $('meta[name="csrf-token"]').attr('content');

        $('#myaccount-name').editable({
            type: 'text',
            title: 'Enter new name',
            params: {_token:token},
        });
    </script>

</head>
<body>

<div class="flex-container">
<header>
  <h1> Welcome <?php echo session('active_user'); ?></h1>
  
  <div class="logout">
  	<form action="logout" method="POST">
        <input type="submit" name="logout" value="Logout">
        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
    </form>
  </div>
  <div class="cart">
  <form id='basket' method="POST" action="shopBasket">
  <table>
  	<tr><td></td><td><input type="submit" name="SBasket" value="ShoppingBasket">
            <input type="hidden" name="_token" value="<?php echo csrf_token();?>"></td></tr>
	<tr>
  	<td>No of Items: </td>
  	<td>
        <?php
        $sum = 0;
        if(!session('bucket')){
            echo $sum;
        }else{
            $items = session('bucket');
            foreach ($items as $key => $value){
                $sum = $sum + $value;

            }
            echo $sum;
        }

        ?>
	</td>
  	</tr>
  </table>
  </form>
  </div>
</header>
<div class="search">
	<form id=search method="POST" action="search">
	<table>
		<tr><td colspan="3">Search :<input type="text" name="search" id="search"></td></tr>
		<tr>
		<td><input type="submit" name="title" value="SearchByBookTitle"></td>
		<td><input type="submit" name="author" value="SearchByAuthor"></td>
            <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
    </form>
	</table>
	
</div>

    <div class="searchResult">
        <?php

        if(isset($_POST['search'])) {
            $output = "<table border='1'>
						<tr><th>ISBN</th><th>Title</th><th>Year</th><th>Price</th><th>Publisher</th><th>Qty</th></tr>";
            foreach ($qryResult as $row) {
                if ($row->count > 0) {

                    $data['isbn'] = $row->isbn;
                    $data['title'] = $row->title;
                    $data['year'] = $row->year;
                    $data['price'] = $row->price;
                    $data['publisher'] = $row->publisher;
                    $data['in_stock'] = $row->count;
                    $_token = csrf_token();
                    $output .= "	<form id='AddToCart' action='addCart'  method='POST'>
						<tr><td>" . $data['isbn'] . "</td>
						<td>" . $data['title'] . "</td>
						<td>" . $data['year'] . "</td>
						<td>" . $data['price'] . "</td>
						<td>" . $data['publisher'] . "</td>
						<td>" . $data['in_stock'] . "</td>
						<td><input type='hidden' value='" . $data['isbn'] . "' name='bookinfo'></td>
						<td><input type='submit' value='Add to cart' name='addtocart'>
						<input type='hidden' name='_token' value='$_token'>
						</td>
						</form>";

                }
            }
            $output .= "</table>";
            echo $output;
            session(['searchResult'=>$output]);
        }
        else{
            echo session('searchResult');
        }
        ?>
    </div>


<footer></footer>
</div>

</body>
</html>
