<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catagory;
use App\Models\Product;
use App\Models\Order;
//for pdf=====>
use PDF;

//for email=====>
use Notification;
use App\Notifications\MyFirstNotification;



use Illuminate\Support\Facades\Auth;
use App\Models\User;




class AdminController extends Controller
{

    //  catagory page ====>
    public function view_catagory(){
        if(Auth::id()){
            $data = Catagory::all();
            return view('admin.catagory',compact('data'));
        }else{
            return redirect('login/');
        }

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
            if(Auth::id()){
                $data = Catagory::all();
                return view('admin.product',compact('data'));
            }else{
                return redirect('login/');
            }

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
        if(Auth::id()){
            $product = Product::all();
            return view('admin.show_product',compact('product'));
           
        }else{
            return redirect('login/');
        }

    }

    // Delete product as admin ======>
    public function delete_product($id){
        $data = Product::find($id);
        $data->delete();
        return  redirect()->back()->with('message','Product Deleted Successfully');
    }

    //update product ===>
    public function update_product($id){       
        if(Auth::id()){
            $data = Product::find($id);
            return view('admin.update_product',compact('data'));
        }else{
            return redirect('login/');
        }

    }
    //update product ====>
    public function edit_product(Request $request ,$id){

        
        if(Auth::id()){

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
           
        }else{
            return redirect('login/');
        }
        
    }

    //for view order as order =======>>
    public function order(){
        if(Auth::id()){

            $order_data = Order::all();
            return view('admin.order',compact('order_data'));
           
        }else{
            return redirect('login/');
        }
    }

    //for delivered ====> 
    public function delivered($id){
        $order = Order::find($id);
        $order->delivery_status ='delivered';
        $order->payment_status ='paid';

        $order->save();
        return redirect()->back();
    }

    //for download pdf ====>
    public function print_pdf($id){
        $order= Order::find($id);
        $pdf = PDF::loadView('admin.pdf',compact('order'));
        return $pdf->download('order_details.pdf');

    }

    //For Sending Email =====>
    public function send_email($id){
        $order = Order::find($id);
        return view('admin.email_info',compact('order'));
    }

    //send email =====>
    public function send_user_email(Request $request , $id){
        $order = Order::find($id);
        //its come from app notifications----->$details
        $details = [
            'greeting' =>$request->greeting,
            'firstline' =>$request->firstline,
            //'body' =>'anything i can write',
            'body' =>$request->body,
            'button' =>$request->button,
            'url' =>$request->url,
            'lastline' =>$request->lastline,

        ];
        Notification::send($order, new MyFirstNotification($details));
        return redirect()->back();
    }

    //for search as admin in order table======>
    public function search(Request $request){
        $search = $request->search;
        $order_data = Order::where('name' , 'like', '%' .$search.'%')->orWhere('phone' , 'like' , '%'.$search. '%' )->get();
        return view('admin.order',compact('order_data'));

    }



}
