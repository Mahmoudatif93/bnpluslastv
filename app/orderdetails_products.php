<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderdetails_products extends Model
{
   protected $connection = 'products';
    protected $table = 'order_details';
   
    protected $fillable = [
        'orderid',
       'productid',
       'quantity' ,
        'price',
        'userid',
     
        
       
    ];

    






}
