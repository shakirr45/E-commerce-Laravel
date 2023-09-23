<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<h1>Order Details</h1>
Name :<h3> {{$order->name}}</h3>
Email :<h3> {{$order->email}}</h3>
Address :<h3> {{$order->address}}</h3>
Phone :<h3> {{$order->phone}}</h3>
Product Name :<h3> {{$order->product_ttitle}}</h3>
Product Quantity :<h3> {{$order->quantity}}</h3>
Product Price :<h3> {{$order->price}}</h3>
Customer ID :<h3> {{$order->user_id}}</h3>
Product Image:<img  width="300" height="300" src="product/{{$order->image}}" alt="">




    
</body>
</html>