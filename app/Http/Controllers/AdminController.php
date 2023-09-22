<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catagory;
use App\Models\Product;




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
    //Add Product ====>
    public function view_product(){
        $data = Catagory::all();
        return view('admin.product',compact('data'));
    }
    // Add product =====>
    public function add_product(Request $request){
        $data = new Product;

        $data->title=$request->title;

        $data->description=$request->description;

        $data->price=$request->price;

        $data->quantity=$request->quantity;
        
        $data->discount_price=$request->discount_price;

        $data->catagory=$request->catagory;

        $image = $request->image;
        if($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('product',$imagename);
            $data->image=$imagename ;
        }

        $data->save();
        return  redirect()->back()->with('message','Product added Successfully');
    }

    public function show_product(){
        $product = Product::all();
        return view('admin.show_product',compact('product'));
    }

    // Delete product as admin ======>
    public function delete_product($id){
        $data = Product::find($id);
        $data->delete();
        return  redirect()->back()->with('message','Product Deleted Successfully');
    }

    //update product ===>
    public function update_product($id){

        $data = Product::find($id);
        return view('admin.update_product',compact('data'));
    }
    //update product ====>
    public function edit_product(Request $request ,$id){
        $product = Product::find($id);

        $product->title=$request->title;

        $product->description=$request->description;

        $product->price=$request->price;

        $product->quantity=$request->quantity;
        
        $product->discount_price=$request->discount_price;

        $product->catagory=$request->catagory;

        $image = $request->image;
        if($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('product',$imagename);
            $product->image=$imagename ;
        }
        $product->save();
        return  redirect()->back()->with('message','Product Updated Successfully');


    }
}
