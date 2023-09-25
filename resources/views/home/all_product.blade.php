<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />

      <!-- /////////////// for jquery cdn for comments //////////////================= -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
       


  
    
      <!-- product section -->
      @include('home.product_view')
      <!-- end product section -->
      <!-- Comment and reply system starts here -->
      <div style="text-align:center; padding-bottom:30px;">
         <h1 style="font-size:30px; text-align:center; padding-top:20px; padding-bottom:20px;">Comments</h1>

         <form action="{{url('add_comment')}}" method="POST">
            @csrf
            <textarea style="height:150px; width:600px;" name="comment" placeholder="Comment Something here" rows="10"></textarea>
            <input type="submit" class="btn btn-brimary" value="Comment">
         </form>

      </div>

      <div>
         <h1 style="font-size:20px; padding-bottom:20px;">All Comments</h1>

         @foreach($comment as $comment)

         <div>
            <b>{{$comment->name}}</b>
            <p>{{$comment->comment}}</p>

            <!-- //for take id from this then data-commentid = "{{$comment->id}}" -->

            <a href="javascript::void(0);" onclick="reply(this)" data-commentid = "{{$comment->id}}">Reply</a>

            <!-- //for show reply [[when foreach into foreach then {now will be $reply as $reply it will $reply as $rep}]] =====> -->
            @foreach($reply as $rep)

            @if($rep->comment_id == $comment->id)

            <div style=" padding-left:3%; padding-bottom: 10px;">

            <b>{{$rep->name}}</b>
            <p>{{$rep->reply}}</p>

            <a style="color:blue;" href="javascript::void(0);" onclick="reply(this)" data-commentid = "{{$comment->id}}">Reply</a>

            </div>
         @endif

         @endforeach

         @endforeach

         </div>


         <!-- <div>
            <b>srs</b>
            <p>This is my 2nd comment</p>
            <a href="javascript::void(0);" onclick="reply(this)">Reply</a>
         </div>

         <div>
            <b>ssssssss</b>
            <p>This is my 3rd comment</p>
            <a href="javascript::void(0);" onclick="reply(this)">Reply</a>
         </div> -->


      <!-- //for reply textarea====> -->

         <div style="display:none;" class="replyDiv">

         <form action="{{url('add_reply')}}" method="POST">
            @csrf

         <!-- //for take id from this so uder the input for id and go script -->
         <input type="text" id="commentId" name="commentId" hidden>

         <textarea style="height:100px; width:500px;" name="reply" placeholder="Write Something Here"></textarea>
         <br>
         <!-- <input type="submit" value="Reply" class="btn btn-primary"> -->
         <button type="submit" class="btn btn-warning">Reply</button>
         <a href="javascript::void(0);" class="btn btn-danger" onClick="reply_close(this)">close</a>

         </form>

      </div>

      </div>


      <!-- Comment and reply system ends here -->



      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

         </p>
      </div>

      <!-- //for comment ===========================>> -->

      <script>
         function reply(caller){

            //for reply ====>
            document.getElementById('commentId').value=$(caller).attr('data-commentid');

            $('.replyDiv').insertAfter($(caller));
            $(".replyDiv").show();

         }

         // for close =====>
         function reply_close(caller){

            $(".replyDiv").hide();

         }
      </script>

      <!-- //for not reload ========================= then comment or reply>> -->
      <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>

      <!-- jQery ====================================also need for comments -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>