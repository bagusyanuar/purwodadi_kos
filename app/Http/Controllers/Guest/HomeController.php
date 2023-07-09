<?php


namespace App\Http\Controllers\Guest;


use App\Helper\CustomController;

class HomeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('guest.home');
    }
}
