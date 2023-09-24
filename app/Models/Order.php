<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//for send email we can fint this in models/user.php=====>
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory;
//for send email we can fint this in models/user.php=====>

    use Notifiable;
}
