<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

//for stripe payment getway ========>.
use Session;
use Stripe;



class HomeController extends Controller
{
    //
    public function index(){
        $product =Product::paginate(3);

        if(Auth::id()){

            
        //product data show =====>
        // $product =Product::all();

        $id = Auth::user()->id;
        $count = Cart::where('user_id',$id)->count();

        return view('home.userpage',compact('product','count'));

        }else{
        return view('home.userpage',compact('product'));

        }




    }

    public function redirect(){
        $usertype = Auth::user()->usertype;
        if($usertype == '1'){
            //for show all count value in dashboard ======>
            $total_product = Product::all()->count();
            $total_order = Order::all()->count();
            $total_user = User::all()->count();

            $order_revinue = Order::all();
            $total_revinue = 0;
            foreach($order_revinue as $order_revinue){
                $total_revinue = $total_revinue + $order_revinue->price;
            }

            $total_dalivered = Order::where('delivery_status','=' , 'delivered')->get()->count();

            $total_processing = Order::where('delivery_status','=' , 'processing')->get()->count();



            return view('admin.adminhome',compact('total_product','total_order','total_user','total_revinue','total_dalivered','total_processing'));

        }else{
        //product data show =====>
        // $product =Product::all();

        //show for post=====>
        $product =Product::paginate(3);

        $id = Auth::user()->id;
        $count = Cart::where('user_id',$id)->count();

            return view('home.userpage',compact('product','count'));

        }
    }
    //product details page =====>
    public function product_details($id){
        $product = Product::find($id);
        $id = Auth::user()->id;
        $count = Cart::where('user_id',$id)->count();
        return view('home.product_details',compact('product','count'));
    }

    //add to cart ====>
    public function add_cart(Request $request, $id){
        if(Auth::id()){

            //for get the user Data------------------->
            $user = Auth::user();
            // dd($user);
            $user_id = $user->id;
            $user_name = $user->name;
            $user_email = $user->email;
            $user_phone = $user->phone;
            $user_address = $user->address;


            //for get the product Data------------------->
            $product = Product::find($id);
            // dd($product);


            //insert data to Cart--------------------->
            $cart = new Cart;

            //for user =========>
            $cart->name=$user_name;
            $cart->email=$user_email;
            $cart->phone=$user_phone;
            $cart->addres=$user_address;
            $cart->user_id=$user_id;

            //for product =========>
            $cart->product_ttitle=$product->title;
            $cart->quantity=$product->quantity;
            $cart->image=$product->image;
            $cart->product_id=$product->id;

            //discount price check============>
            if($product->discount_price!=null){
                $cart->price=$product->discount_price * $request->quantity;
            }else{
            $cart->price=$product->price * $request->quantity;
            }


            //for form data =========>
            $cart->quantity = $request->quantity;

            $cart->save();


            return redirect()->back();
        }else{
            return redirect('/login');
        }
    }

    //show cart ====>
    public function show_cart(){

        $id = Auth::user()->id;
        $count = Cart::where('user_id',$id)->count();

            if(Auth::id()){
                $id = Auth::user()->id;
                $cart = Cart::where('user_id', '=' ,$id)->get();
        
                    return view('home.show_cart',compact('cart','count'));
            }else{
                return redirect('/login');
            }  
    }

    //remove cart as user ====>
    public function remove_cart($id){
        $data = Cart::find($id);
        $data->delete();
        return redirect()->back();
    }

    //cash order =====>
    public function cash_order(){

        $user = Auth::user();
        $userid = $user->id;
        // dd($userid);

        $data = Cart::where('user_id', '=' , $userid)->get();
        foreach($data as $data){

            $order = new Order;

            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->addres;
            $order->user_id=$data->user_id;
            $order->image=$data->image;
            $order->product_ttitle=$data->product_ttitle;
            $order->quantity=$data->quantity;
            $order->price=$data->price;
            $order->product_id=$data->product_id;
            $order->payment_status= "cash on delivery";
            $order->delivery_status= "Processing";
            $order->save();

            //for remove data from cart
            $cart_id =$data->id;
            $cart= Cart::find($cart_id);
            $cart->delete();

            
        }

        return redirect()->back()->with('message','We have Receivet your Order. W e Will connect with soon Thank You .');

    }

    //For Stripe ==================>>
     public function stripe($totalprice){
        $totalprice = $totalprice;
        $id = Auth::user()->id;
        $count = Cart::where('user_id',$id)->count();
        return view('home.stripe',compact('totalprice','count'));
     }

     public function stripePost(Request $request, $totalprice)
    {
        // dd($totalprice);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks For Payment." 
        ]);
    //for after payment remove and store cart in db =====>

        $user = Auth::user();
        $userid = $user->id;
        // dd($userid);

        $data = Cart::where('user_id', '=' , $userid)->get();
        foreach($data as $data){

            $order = new Order;

            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->addres;
            $order->user_id=$data->user_id;
            $order->image=$data->image;
            $order->product_ttitle=$data->product_ttitle;
            $order->quantity=$data->quantity;
            $order->price=$data->price;
            $order->product_id=$data->product_id;
            $order->payment_status= "paid";
            $order->delivery_status= "Processing";
            $order->save();

            //for remove data from cart
            $cart_id =$data->id;
            $cart= Cart::find($cart_id);
            $cart->delete();

            
        }





        Session::flash('success', 'Payment successful!');
              
        return back();
    }




}
