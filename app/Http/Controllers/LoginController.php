<?php
/**
 * Created by PhpStorm.
 * User: Ashutosh
 * Date: 12/1/2016
 * Time: 12:57 AM
 */



class LoginController extends \App\Http\Controllers\Controller{

    public function doLogin(Request $request)
    {
       $username = $request->input('username');
       print_r($request);
       echo $username;
    }


}