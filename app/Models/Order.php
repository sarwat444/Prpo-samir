<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

     protected $table = "orders";

      protected $fillable = [

                'title',
                'description',
                'price',
                'order_no',
                'total_amount',
                'user_id',
                'offer_id',
                'bank_transaction_id',



      ];
}
