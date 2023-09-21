<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catagory;



class AdminController extends Controller
{
    //
    //  catagory page ====>

    public function view_catagory(){
        $data = Catagory::all();
        return view('admin.catagory',compact('data'));
    }
    //  add catagory ====>

    public function add_catagory(Request $request){

        $data = $request->name;
        if($data){
            $data = new Catagory;
            $data->Catagory_name=$request->name;
            $data->save();
            return redirect()->back()->with('message','Catagory Added Successfully');
        }else{
        return redirect()->back();
        }
    } 

    // Delete catagory ====>

    public function delete_catagory($id){
        $data = Catagory::find($id);
        $data->delete();
        return redirect()->back()->with('message','Catagory Deleted Successfully');

    }




    
}
