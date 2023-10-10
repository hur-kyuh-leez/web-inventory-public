<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Client;
use App\User;



class ReactController extends Controller
{
    public function index()
    {
//        $clients = User;
//        return view('react.react', compact('clients'));

//        $clients = User;
        return view('react.react');
    }
    //
}
