<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Page1Controller extends Controller
{
    public function doLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $users = DB::select('select username from customers where username = ? and password=?', [$username,md5($password)]);

        foreach ($users as $user) {
            $in_user=$user->username;

            if($in_user == $username){
                session(['active_user' => $username]);
                return view('Page2');
            }
            else {
                return view('Page1');
            }
        }

    }

    public function doLogout()
    {
        auth()->logout();
        Session::flush();
        return redirect('/');

    }


    public function doRegister()
    {
        return view('page4');
    }

    public function userRegister(Request $request){

        $username = $request->input('username');
        $password = $request->input('password');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $email = $request->input('email');

        $userExist = DB::select('select username from customers where username=?',[$username]);
        print_r($userExist);

        if(!$userExist){
            echo "In Insert";
            DB::insert('Insert into customers values(?,?,?,?,?)',[$username, md5($password), $address, $phone, $email]);
            return view('Page1');
        }else{

        echo "User Already Exists";
    }

    }


    public function doSearch(Request $request){

    if($request->input('author')){

        $searchStr = $request->input('search');

        if(!trim($searchStr)){

            $qryResult = DB::select('select b.isbn as isbn, b.title as title, b.year as year, b.price as price, b.publisher as publisher,(select sum(s.number) from stocks s where s.isbn = b.isbn) as count from author a,writtenby w, book b where a.ssn = w.ssn	and w.isbn = b.isbn');

            return view('Page2')->with('qryResult',$qryResult);

        } else{

            $qryResult = DB::select("select b.isbn as isbn, b.title as title, b.year as year, b.price as price, b.publisher as publisher,(select sum(s.number) from stocks s where s.isbn = b.isbn) as count from author a,writtenby w, book b where a.ssn = w.ssn 	and lower(a.name) like '%".$searchStr."%' and w.isbn = b.isbn",[$searchStr]);

            return view('Page2')->with('qryResult',$qryResult);

        }



    }
        elseif ($request->input('title')){

            $searchStr = $request->input('search');
            if(!trim($searchStr)){


                $qryResult = DB::select('select b.isbn, b.title, b.year, b.price, b.publisher, sum(s.number) as count from book b, stocks s where  s.number > 0 and b.isbn = s.isbn group by b.isbn');

                return view('Page2')->with('qryResult',$qryResult);

            } else{


                $qryResult = DB::select("select b.isbn, b.title, b.year, b.price, b.publisher, sum(s.number) as count from book b, stocks s where lower(b.title) like '%".$searchStr."%' and s.number > 0 and b.isbn = s.isbn group by b.isbn",array($searchStr));

                print_r($qryResult);

                return view('Page2')->with('qryResult',$qryResult);

            }

        }
    }


    public function addCart(Request $request)
    {
        $isbn = $request->input('bookinfo');
        $sum = 0;
        if(!session('bucket')){
            session(['bucket'=>array($isbn=>1)]);

        }
        else{
            $items = session('bucket');
            $flag = 1;
            foreach ($items as $key => $value){
                if($key == $isbn){
                    $items[$key]=$value+1;
                    $flag=0;
                }
            }
            if($flag==1){
                $items[$isbn]=1;
            }

            session(['bucket'=>$items]);
        }
        return view('Page2');
    }


    public function shopBasket(){

        if(session('bucket')){

            $items=session('bucket');
            $msg = "<b>Shopping Cart</b>
 			<table border='1'>
 			<tr><th>ISBN</th><th>TITLE</th><th>QUANTITY</th><th>PRICE</th></tr>";
            $sum = 0.0;
            foreach ($items as $key=>$value){

                $isbn = $key;
                $bookCnt = $value;


                $query = DB::select('select title, price from book where isbn=?',[$isbn]);

                foreach ($query as $res){
                    $title = $res->title;
                    $price = $res->price;
                    $total_price = $bookCnt * $price;

                    $msg.="<tr><td>".$key."</td><td>".$title."</td><td>".$bookCnt."</td><td>".$total_price."</td></tr>";
                    $sum = $sum + $total_price;
                }


            }
            $token = csrf_token();
            $msg.="<tr><td colspan='3'> Total :</td><td>".$sum." USD</td></tr>
			</table>
			<form action='buy' method='POST'>
			<input type='submit' value='Buy'>
			<input type='hidden' name='_token' value=".$token.">
			</form>";
            return view('Page3')->with('msg',$msg);



        } else{
            return view('Page3')->with('msg',"<h4>Shopping Cart Empty</h4><br><a href='/Page2'>Continue Shopping</a>");
        }


    }


    public function buy(){

    $username = session('active_user');

    DB::insert('Insert into shoppingbasket(username) values (?)',[$username]);

    $fetchQry = DB::select('select basketid from shoppingbasket where username=? order by basketid desc limit 1',[$username]);

    $bId = 0;
    foreach ($fetchQry as $res) {
        # code...
        $bId = $res->basketid;
    }

    $data = session('bucket');

    foreach ($data as $key => $value) {
        $isbn = $key;
        $qty = $value;

        DB::insert('Insert into contains values(?,?,?)',[$isbn,$bId,$qty]);


        $fetchQry1 = DB::select('select warehousecode, number from stocks where isbn=?',[$isbn]);



            foreach ($fetchQry1 as $res2) {
                # code...
                $warehousecode = $res2->warehousecode;
                $stock = $res2->number;

                if($qty != 0){
                    if($stock >= $qty){


                        DB::insert('insert into shippingorder values (?,?,?,?)',[$isbn,$warehousecode,$username,$qty]);

                        DB::update('update stocks set number = number - ? where warehousecode=? and isbn=?',[$qty,$warehousecode,$isbn]);

                        $qty = 0;
                        #Session::flush();
                        #return view('Page3')->with('msg',"<h4>Purchase Successfull</h4><br><a href='/Page2'>Continue Shopping</a>");
                    } else{

                        DB::insert('insert into shippingorder values (?,?,?,?)',[$isbn,$warehousecode,$username,$stock]);

                        DB::update('update stocks set number = number - ? where warehousecode=? and isbn=?',[$stock,$warehousecode,$isbn]);

                        $qty = $qty - $stock;

                    }
                }


            }



        }
        Session::flush();
        return view('Page3')->with('msg',"<h4>Purchase Successfull</h4><br><a href='/Page2'>Continue Shopping</a>");



    }


}
