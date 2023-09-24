<!DOCTYPE html>
<html lang="en">
  <head>

  <base href="/public">
    <!-- Required meta tags -->
    @include('admin.css')

    <style>
        .font_size{
            font-size: 25px;
            text-align: center;
            padding-bottom: 40px;
        }
        .div_center{
            text-align:center;
            padding-top: 30px;
        }
        label{
            display:inline-block;
            width:200px;
            font-size: 15px;
            font-weight:bold;
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
          <h1 class="font_size">Send Email to {{$order->email}}</h1>

          <form action="{{url('send_user_email',$order->id)}}" method="POST">
            @csrf

          <div class="div_center">
            <label for="">Email Greeting:</label>
            <input style="color:black;" type="text" name = "greeting">
          </div>

          <div class="div_center">
            <label for="">Email First Line:</label>
            <input style="color:black;" type="text" name = "firstline">
          </div>

          <div class="div_center">
            <label for="">Email Body:</label>
            <input style="color:black;" type="text" name = "body">
          </div>

          <div class="div_center">
            <label for="">Email Button name:</label>
            <input style="color:black;" type="text" name = "button">
          </div>

          <div class="div_center">
            <label for="">Email Url:</label>
            <input style="color:black;" type="text" name = "url">
          </div>

          <div class="div_center">
            <label for="">Email Last Line:</label>
            <input style="color:black;" type="text" name = "lastline">
          </div>

          <div class="div_center">
            <input type="submit" value="Send Email" class="btn btn-primary">
          </div>



          </form>




            </div>
          </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')

    <!-- End custom js for this page -->
  </body>
</html>