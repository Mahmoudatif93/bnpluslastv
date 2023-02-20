<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Cards;
use App\Carbon\Carbon;
use App\Order;
use App\cards_anais;
use App\Client;
use App\Currency;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Http;
class ProfitRatio extends Controller
{


    public function index(Request $request)
    {  
        
        $Companies=array();
        
        if(!empty($request->date1) && !empty($request->date2)){
            
        $date1=$request->date1;
        $date2=$request->date2;
$profit=0;

//$allorders=Order::where(array('paid'=>'true','updated_at')->get();
$mytime =\Carbon\Carbon::now();
$times= $mytime->toDateTimeString();
$allorders=DB::select("select * FROM `orders` WHERE  paid ='true' and updated_at BETWEEN '$request->date1' and '$request->date2'");

//dd($allorders);

foreach($allorders as $roworder ){
    $allcardss=Cards::where('id',$roworder->card_id)->get();

$curr = Currency::where('id', 1)->first();


foreach($allcardss as $allcarda){
    if($allcarda->api2==1){
        $profit +=$allcarda->card_price- $allcarda->old_price;

    }
    if($allcarda->api1==1){
        $profit +=$allcarda->card_price / $curr->amount;

    }
    if($allcarda->api1 !=1 &&  $allcarda->api2 !=1){
        $profit +=$allcarda->card_price - $allcarda->purchaseprice  ;

    }

}
}
  }else{
      
            $date1='';
        $date2='';
        $profit='';
      
  }

        return view('dashboard.ProfitRatio', compact('profit','date1','date2'));
    } //end of index

    
 
}//end of controller
