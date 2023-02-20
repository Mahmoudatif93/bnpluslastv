<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    

        protected $fillable = ['card_name','company_id','api',
     'card_price','card_code','amounts','offer','avaliable','purchase','old_price',
     'card_image','nationalcompany','productId','enable','api2','api2id','purchaseprice'];


        protected $casts = [
               'id' => 'integer',
        'card_name' => 'string',
        'company_id' => 'integer',
        'card_price' => 'double',
        'card_code' => 'string',
        'amounts' => 'integer',
         'card_image' => 'string',
          'purchaseprice' => 'double',
    ];
    
    
    public function orders()
    {
        return $this->hasMany(Order::class);

    }//end of orders

    public function company()
    {
        return $this->belongsTo(Company::class);

    }//end of user

}
