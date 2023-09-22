<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    
    <style>
        .center{
            margin: auto;
            width:60%;
            border: 2px solid white;
            text-align:center;
            margin-top: 40px;
        }
        .font_size{
            font-size: 40px;
            text-align:center;
            padding-bottom: 10px;
        }
        .img_size{
            height:150px;
            width: 150px;
        }
        .th_color{
            background: skyblue;
            color: black;
        }
        .th_deg{
            padding: 20px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
     @include('admin.sidebar')
      <!-- partial -->
     @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">

          <div>
          @if(session()->has('message'))
          <div class="alert alert-success"> 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{session()->get('message')}}
          </div>
          @endif


            <h1 class="font_size">All Products</h1>
            <table class="center">
                <tr class="th_color">
                    <td class="th_deg">Product Title</td>
                    <td class="th_deg">Description</td>
                    <td class="th_deg">Quantity</td>
                    <td class="th_deg">Catagory</td>
                    <td class="th_deg">Product Price</td>
                    <td class="th_deg">Discount Price</td>
                    <td class="th_deg">Product Image</td>
                    <td class="th_deg">Delete Product</td>
                    <td class="th_deg">Update Product</td>


                </tr>
                @foreach($product as $product)
                <tr>
                    <td>{{$product->title}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->catagory}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->discount_price}}</td>
                    <td><img class="img_size" src="product/{{$product->image}}" alt=""></td>
                    <td><a onclick="return confirm('Are You Sure To Delete This?')" class="btn btn-danger" href="{{url('delete_product',$product->id)}}">Delete</a></td>
                    <td><a class="btn btn-success" href="{{url('update_product',$product->id)}}">Update</a></td>
                </tr>
                @endforeach
            </table>
          </div>



            </div>

            </div>       

    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')

    <!-- End custom js for this page -->
  </body>
</html>