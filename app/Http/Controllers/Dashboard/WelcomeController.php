<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Cards;
use Illuminate\Support\Carbon;

use App\Order;
use App\cards_anais;
use App\Client;
use App\Currency;
use Illuminate\Support\Str;
use App\currancylocal;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function index()
    {
        $orders = Order::count();
        $companies = Company::where('enable',0)->count();
        $cards = Cards::where(array('avaliable' => 0, 'purchase' => 0,'enable'=>0))->count();
        $clients = Client::count();
       

        $curl = curl_init();
        $refrenceid = "Merchant_" . rand();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://taxes.like4app.com/online/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'deviceId' => 'cd63173e952e3076462733a26c71bbd0b236291db71656ec65ee1552478402ef',
                'email' => 'info@bn-plus.ly',
                'password' => 'db7d8028631f3351731cf7ca0302651d',
                'securityCode' => 'cd63173e952e3076462733a26c71bbd077d972e07e1d416cb9ab7f87bfc0c014',
                'langId' => '1',

            ),

        ));

        $dubiorder = curl_exec($curl);
        curl_close($curl);
        $dubiordersjson = json_decode($dubiorder, true);


       // dd($dubiorder );
if(isset($dubiordersjson['response'] )){


      
if($dubiordersjson['response'] ==1){
    $dubiorders= count( $dubiordersjson['data']) ;
  //  dd($dubiorders );
}else{
    $dubiorders= '';
}
}else{
    $dubiorders= ''; 
}


$uri = 'https://identity.anis.ly/connect/token';
$params = array(
    'grant_type' => 'user_credentials',
    'client_id' => 'bn-plus',
                                 //  'client_secret' => '3U8F3U9C9IM39VJ39FUCLWLC872MMXOW8K2STWI28ZJD3ERF',
          //  'password' => 'P@ssw0rd1988',
          'client_secret'=>'VKOW0OR2wd893RFPQDM92i0q233HRFB8C2W87RGEetghkl9238',
            'password' => 'Mahdibnplus1988',
            'email' => 'info@bn-plus.ly',
);
$response = Http::asForm()->withHeaders([])->post($uri, $params);   
$token=$response->json()['access_token'];
$token_type=$response->json()['token_type'];
$alltoken=$response->json()['token_type'] .' '.$response->json()['access_token'];



$swaggercompanies = Http::withHeaders([
    'Accept' => 'application/json',
    'Authorization' => $alltoken,
])->get('https://gateway.anis.ly/api/consumers/v1/transactions?pinNumber=1988');

//dd($swaggercompanies->json()['data']);
$alldata=$swaggercompanies->json()['data'];




$profit=0;

//$allorders=Order::where(array('paid'=>'true','updated_at')->get();
$mytime =\Carbon\Carbon::now();
//$times= $mytime->toDateTimeString();
/*$times= date('Y-m-d');
//dd($times);
$currentdate=date('Y-m').'-01';

$allorders=DB::select("select * FROM `orders` WHERE  paid ='true' and updated_at BETWEEN '$currentdate' and '$times'");
*/


 $currentDateTime = Carbon::now();
        $datetime = Carbon::now()->addDay();
          
$currentdate=date('Y-m').'-01'.' 00:00:00';
$curr = Currency::where('id', 1)->first();
//$currancylocal = currancylocal::where('id', 1)->first();



$allorders=DB::select("select * FROM `orders` WHERE  paid ='true' and updated_at BETWEEN '$currentdate' and '$datetime'");

foreach($allorders as $roworder ){
    $allcardss=Cards::where('id',$roworder->card_id)->get();
   
foreach($allcardss as $allcarda){
  

    if($allcarda->api !=1 &&  $allcarda->api2 !=1){
        $profit +=round($allcarda->card_price - $allcarda->purchaseprice,1)  ;

    }

}
}

$allorderapi=DB::select("select * FROM `orders` WHERE  paid ='true' and card_id in (select id from cards where api !=1 and api2 !=1)  and updated_at BETWEEN '$currentdate' and '$datetime' order by updated_at asc"  );







$allorderapi1=DB::select("select * FROM `orders` WHERE  paid ='true' and card_id in (select id from cards where api=1)  and updated_at BETWEEN '$currentdate' and '$datetime' order by updated_at asc"  );


foreach($allorderapi1 as $allcardapi1){
     $profit +=round($allcardapi1->card_price / $curr->amount,1);

}

   



$currancylocal=DB::select("select * FROM `currancylocals` WHERE   created_at > '$currentdate' or created_at < '$datetime' ");


  
  
$allordersanais=DB::select("select * FROM `orders` WHERE  paid ='true' and card_id in(select id from cards where api2=1)  and updated_at BETWEEN '$currentdate' and '$datetime' order by updated_at asc"  );



$allcardssanais=DB::select("select * FROM `cards` WHERE   api2=1 and id !=90138  and  id in(select card_id from orders where paid ='true' and updated_at BETWEEN '$currentdate' and '$datetime' order by id)
"  );


$anisprices=0;
$acardsprssices=0;

     foreach($allcardssanais as $cardddds ){
         
         $allordersanais2=DB::select("select * FROM `orders` WHERE  paid ='true' and card_id =$cardddds->id  and updated_at BETWEEN '$currentdate' and '$datetime' order by card_id"  );
         
         foreach($allordersanais2 as $ddd){
             $anisprices += $ddd->card_price;
             
         }
            $acardsprssices+=$cardddds->old_price;
        }


//dd($currancylocal);
foreach($allordersanais as $allcardanis){
   //$profist2 +=$allcardanis->card_price ;
  $profit +=round($allcardanis->card_price*($currancylocal[0]->amount/100),1);

}


    


    
        return view('dashboard.welcome', compact('profit','companies','orders','cards','clients','dubiorders','alldata'));

    }//end of index

}//end of controller
