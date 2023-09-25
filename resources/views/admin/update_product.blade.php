<!DOCTYPE html>
<html lang="en">
  <head>
    
    <!-- Required meta tags -->
    @include('admin.css')

    <style>
        .div_center{
            text-align:center;
            padding-top: 5px;
        }
        .font_size{
            font-size: 40px;
            padding-bottom: 40px;
        }
        .text_color{
            color:black;
            padding-bottom: 20px;
        }
        label{
            display:inline-block;
            width:200px;
        }
        .div_design{
            padding-bottom: 15px;

        }
        .img_size{
            height:150px;
            width: 150px;
            margin: auto;

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

          <div class="div_center">
          @if(session()->has('message'))
          <div class="alert alert-success"> 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{session()->get('message')}}
          </div>
          @endif
            <h1 class="font_size">Update Product</h1>
            <form action="{{url('edit_product',$data->id)}}" method="POST" enctype="multipart/form-data">

            @csrf


            <div class="div_design">
                <label for="">Product Title:</label>
                <input class="text_color" type="text" name="title" placeholder="Write a Title" required="" value="{{$data->title}}">
            </div>
            <div class="div_design">
                <label for="">Product Description:</label>
                <input class="text_color" type="text" name="description" placeholder="Write a Description" required="" value="{{$data->description}}">
            </div>
            <div class="div_design">
                <label for="">Product Price:</label>
                <input class="text_color" type="number" name="price" placeholder="Write a Price" required="" value="{{$data->price}}">
            </div>
            <div class="div_design">
                <label for="">Discount Price:</label>
                <input class="text_color" type="number" name="discount_price" placeholder="Write Discount Price" value="{{$data->discount_price}}">
            </div>
            <div class="div_design">
                <label for="">Product Quantity:</label>
                <input class="text_color" type="number" min="0" name="quantity" placeholder="Write a Quantity" required="" value="{{$data->quantity}}">
            </div>

            <div class="div_design"> 
                <label for="">Product Catagory:</label> 
                <select class="text_color" name="catagory" id="" required="">  
                <option value="{{$data->catagory}}" selected="">{{$data->catagory}}</option> 
            </select> 
            </div>

            <div class="div_design">
                <label for="">Old Image Here:</label>
                <img class="img_size" src="/product/{{$data->image}}" alt="">
            </div>

            <div class="div_design">
                <label for="">New Image Here:</label>
                <input type="file"name="image" required="">
            </div>

            <div class="div_design">
                <input type="submit" value="update Product" class="btn btn-primary">
            </div>

            </form>

          </div>



          
          </div>
          </div>
       
       
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')

    <!-- End custom js for this page -->
  </body>
</html>