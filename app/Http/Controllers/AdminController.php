<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    // View catagory ====>

    public function view_catagory(){
        return view('admin.catagory');
    }
    
}
