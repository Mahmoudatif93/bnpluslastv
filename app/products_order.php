<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products_order extends Model
{

   
    protected $fillable = [
        'addressId',
       'arrivalDate',
       'createDate' ,
        'discount',
        'promoCodeId',
        'addressName',
        'total',
        'userId',
        'addressDetails','price'
        ,
        'quantity','product_id',
        
        'client_name','client_id'
        ,
        'customer_phone','client_email',
        
        'result','custom_ref','url'
        
     
       
    ];

    






}
