<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function queue()
    {
        $users = User::where('id', '<', 90)->get();
        $users->map(function ($user){
           dispatch(new SendEmail($user));
        });
        dd('done');
    }

    public function import()
    {
        Excel::import(new UsersImport, 'xlsx/houses.xlsx');
    }
}
