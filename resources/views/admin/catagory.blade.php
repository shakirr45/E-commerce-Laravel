<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style>
        .dev_center{
            text-align:center;
            padding-top: 40px;
        }
        .h2_font{
            font-size: 40px;
            padding-bottom:40px;

        }
        .input_color{
            color: black;
        }
        .center{
            margin: auto;
            width:50%;
            text-align:center;
            margin-top: 40px;
            border:3px solid white;
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

          @if(session()->has('message'))
          <div class="alert alert-success"> 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{session()->get('message')}}
          </div>
          @endif

              <div class="dev_center">
                <h1 class="h2_font">Add Catagory</h1>
                <form action="{{url('add_catagory')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input style="border-radius: 25px; height:50px; width:400px" class="input_color" type="text" name ="name" placeholder="Whrite a Catagory Name">
                    <input type="submit"  style="border-radius: 25px; height:50px; width:150px" class="btn btn-primary" name="submit" value="Add Catagory">

                </form>
             </div>
             <div>
                <table class="center">
                    <tr>
                        <td>Catagory Name</td>
                        <td>Action</td>
                    </tr>

                    @foreach($data as $data)
                    <tr>
                        <td style="padding:10px;">{{$data->catagory_name}}</td>
                        <td>
                            <a onclick="return confirm('Are You Sure To Delete This?')" href="{{url('delete_catagory',$data->id)}}" class="btn btn-danger">Delete</a>
                        </td>

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