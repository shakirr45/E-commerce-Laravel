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

use App\Models\Comment;
use App\Models\Reply;

//for sweetAlert ====>
use RealRashid\SweetAlert\Facades\Alert;




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

        //for comment show in home page ====>
            //show update comment up====>
            $comment = Comment::orderby('id','desc')->get();

            //for comment reply show in home page ====>
            $reply = Reply::all();


        return view('home.userpage',compact('product','count','comment','reply'));

        }else{

            //for comment show in home page ====>
            //show update comment up====>
            $comment = Comment::orderby('id','desc')->get();

            //for comment reply show in home page ====>
            $reply = Reply::all();

        return view('home.userpage',compact('product','comment','reply'));

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

        //for Comment show ====>
        // $comment = Comment::all();
        //show update comment up====>
        $comment = Comment::orderby('id','desc')->get();


        //for comment reply show in home page ====>
        $reply = Reply::all();

            return view('home.userpage',compact('product','count','comment','reply'));

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
            $userid = $user->id;
            // dd($user);
            $user_id = $user->id;
            $user_name = $user->name;
            $user_email = $user->email;
            $user_phone = $user->phone;
            $user_address = $user->address;


            //for get the product Data------------------->
            $product = Product::find($id);
            // dd($product);

            //for this code increase value of same product if add ====>
            $product_exist_id = Cart::where('product_id', '=' , $id)->where('user_id' , '=' ,$userid)->get('id')->first();
            if($product_exist_id){

                $cart =Cart::find($product_exist_id)->first();
                $quantity=$cart->quantity;
                $cart->quantity=$quantity + $request->quantity;
                
                if($product->discount_price!=null){
                    $cart->price=$product->discount_price * $cart->quantity;

                }else{

                $cart->price=$product->price * $cart->quantity;
                }

                $cart->save();
                //for sweetAlert =======>
            Alert::success('Product Added Successfully','We have added product to the Cart');

                return redirect()->back()->with('message' , 'Product Added Successfully');

            }else{

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

            return redirect()->back()->with('message' , 'Product Added Successfully');
            }
       
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

    //for show or cancle order order ==========>

    public function show_order(){
        if(Auth::id()){
            $id = Auth::user()->id;
            $count = Cart::where('user_id',$id)->count();
            $userid = Auth::user()->id;
            $order = Order::where('user_id', '=' , $userid)->get();

            return view('home.order',compact('count','order'));
        }else{
            return redirect('login');
        }
    }

    //for Cancel order ====>
    public function cancel_order($id){
        $order = Order::find($id);
        $order->delivery_status = 'You Canceled the order';
        $order->save();
        return redirect()->back();
    }

    //for comment =====>
    public function add_comment(Request $request){
        if(Auth::id()){

            $user = Auth::user();
            $comment = new Comment;

            $comment->name = $user->name;
            $comment->user_id = $user->id;


            $comment->comment = $request->comment;
            $comment->Save();
            return redirect()->back();
        }else{
            return redirect('/login');
        }
    }

    //for reply =====>
    public function add_reply(Request $request){
        if(Auth::id()){
            $reply = new Reply;
            $reply->name =Auth::user()->name;
            $reply->user_id =Auth::user()->id;

            //its come from home/userpage.blade ======>
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;

            $reply->save();
            return redirect()->back();



        }else{
            return redirect('/login');
        }
    }





    // for search product ====>
    public function product_search(Request $request){

        $id = Auth::user()->id;
        $count = Cart::where('user_id',$id)->count();

         //for comment show in home page ====>
        //show update comment up====>
        $comment = Comment::orderby('id','desc')->get();

        //for comment reply show in home page ====>
        $reply = Reply::all();

        $search_text = $request->search;
        //name will be same as product before i call thats why{also add ->paginate(10)} =====>
        $product =Product::where('title', 'LIKE' , "%$search_text%")->orwhere('catagory', 'LIKE' , "%$search_text%")->paginate(10);

        // send the view into home page onto in order table ====>
        return view('home.userpage',compact('product','comment','reply','count'));

        return redirect()->back();

    }


//for view product as user in home page ====> link page
public function products(){

    $product =Product::paginate(3);


     //for comment show in home page ====>
            //show update comment up====>
            $comment = Comment::orderby('id','desc')->get();

            //for comment reply show in home page ====>
            $reply = Reply::all();

            $id = Auth::user()->id;
            $count = Cart::where('user_id',$id)->count();
    


    return view('home.all_product',compact('product','comment','reply','count'));
}



    // for search allll product ====>
    public function product_search_all(Request $request){

        $id = Auth::user()->id;
        $count = Cart::where('user_id',$id)->count();

        //for comment show in home page ====>
       //show update comment up====>
       $comment = Comment::orderby('id','desc')->get();

       //for comment reply show in home page ====>
       $reply = Reply::all();

       $search_text = $request->search;
       //name will be same as product before i call thats why{also add ->paginate(10)} =====>
       $product =Product::where('title', 'LIKE' , "%$search_text%")->orwhere('catagory', 'LIKE' , "%$search_text%")->paginate(10);

       // send the view into home page onto in order table ====>
       return view('home.all_product',compact('product','comment','reply','count'));

       return redirect()->back();

   }

    


}
