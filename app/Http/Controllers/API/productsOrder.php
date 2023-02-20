<?php

namespace App\Http\Controllers\API;
use App\Paymentcommissionsmodel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Order;
use App\Cards;
use App\Client;
use App\Anaiscodes;
use App\cards_anais;
use App\tdawalDetails;
use App\Order_anais;
use App\productorders;
use App\products_order;

use App\orderdetails_products;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use PDF2;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class productsOrder extends Controller
{

    use ApiResourceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    /////////////////Tlyncapi/////////////////


    public function productpayment(Request $request)
    {
       
       $price=0;
    $quantity=0;
    $product_id=0;
       
  $data = json_decode($request->getContent(), true);

$userid=$data['userId'];
$createDate=$data['createDate'];
$total=$data['total'];
$arrivalDate=$data['arrivalDate'];
$discount=$data['discount'];
$promoCodeId=$data['promoCodeId'];
$addressId=$data['addressId'];
$cartJsons=$data['cartJsons'];




        $custom_ref = rand();

        $amount = $total;
   

$phones=$data['client_number'];
$client_name=$data['client_name'];
$email=$data['client_email'];
  $client_id=$data['client_id'];   
//dd($client_name);


        if ($amount < 5) {

            $message = " القيمة أقل من الحد الأدنى  5 دينار ";
            return $this->apiResponse6(null, null, $message, 404);
        }


        $fronturl = url('api/fronturl');

        $backendurl = url('api/backendurl2');


        if (substr($phones, 0, 6) == '+218 9') {

            $phone =  str_replace('+218 ', '', $phones);
        } else  if (substr($phones, 0, 6) == '+218 0') {
            $phone =  str_replace('+218 0', '', $phones);
        } else  if (substr($phones, 0, 5) == '+2189') {
            $phone =  str_replace('+218', '', $phones);
        } else  if (substr($phones, 0, 5) == '+2180') {
            $phone =  str_replace('+2180', '', $phones);
        } else  if (substr($phones, 0, 1) == '0') {
            $phone =  str_replace('0', '', $phones);
        } else {
            $phone =  $phones;
        }
        // return $phones;
        //return substr($phones, 0, 1);

        if (
            preg_match("~^2189\d+$~", $phone) || preg_match("~^9\d+$~", $phone) || preg_match("~^002189\d+$~", $phone)
            || preg_match("~^0021809\d+$~", $phone)   || preg_match("~^21809\d+$~", $phone)
        ) {




 $allpricecomm=Paymentcommissionsmodel::where('companyname','تداول')->first();

  if($allpricecomm->status==0){
    $amountprice=$amount +   (($allpricecomm->commissions * $amount) /100);
}else{
        $amountprice=$amount;
}



            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://wla3xiw497.execute-api.eu-central-1.amazonaws.com/payment/initiate',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'id=pLAkv8XEQemV7wDM6ElodG24RnzXAKZVE49PjrN5Y8OgLBJ01xyqabvkpbo5Vq02&amount=' . $amountprice . '&phone=' . $phone . '&email=' . $email . '&backend_url=' . $backendurl . '
 &custom_ref=' . $custom_ref .
                    '&frontend_url=' . $fronturl . '',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Accept: application/json',
                    'Authorization: Bearer 1eoT4IqACu7X0iZvvUeoCbfF0PFlBSuNHVdF6Dzn'
                ),
            ));

            //  1eoT4IqACu7X0iZvvUeoCbfF0PFlBSuNHVdF6Dzn
            // 'Authorization: Bearer 0r14CIjDO0MDErCakVQsoohAvvyklGUvbxUAXpXg'
            //'id=MBQKYkEgg27WdwDV6O49QnERrLJNqY8AYx8a5KMyXej1GzoAb3kBl0xmPz23mV0o
            //https://c7drkx2ege.execute-api.eu-west-2.amazonaws.com/payment/initiate
            $response = curl_exec($curl);


            $json = json_decode($response, true);
           // dd($json);
if(!empty($cartJsons)){
    

foreach($cartJsons as $owe){
    $price=$owe['price'];
    $quantity=$owe['quantity'];
    $product_id=$owe['product_id'];


            $request_data['result'] = $json['result'];
            $request_data['custom_ref'] =  $json['custom_ref'];
            $request_data['url'] = $json['url'];
            $request_data['product_id'] = $product_id;
            $request_data['quantity'] = $quantity;
            $request_data['price'] = $price;
                $request_data['addressId'] = $addressId;
            $request_data['userId'] = $userid;
            $request_data['total'] = $total;
             $request_data['arrivalDate'] = $arrivalDate;
            $request_data['promoCodeId'] = $promoCodeId;
              $request_data['discount'] = $discount;
            $request_data['createDate'] = $createDate;
            
            $request_data['client_name'] = $client_name;
            $request_data['client_id'] = $client_id;
            $request_data['customer_phone'] = $phones;
            $request_data['client_email'] =$email;

            $order = products_order::create($request_data);
            
            
              $request_data2['address_id'] = $addressId;
            $request_data2['arrival_date'] = $arrivalDate;
            $request_data2['create_date'] = $createDate;
            $request_data2['discount'] =$discount;
            
             $request_data2['order_number'] = $custom_ref;
            $request_data2['promocodeid'] =$promoCodeId;
             $request_data2['total'] =$total;
             $request_data2['userid'] =$userid;
             
             //dd($request_data2);
             $order2 = productorders::create($request_data2);
            
            
             $request_dsata3['orderid'] = $order2->id;
            $request_dsata3['price'] =$price;
             $request_dsata3['productid'] =$product_id;
             $request_dsata3['quantity'] =$quantity;
                 $request_dsata3['userid'] =$userid;
           
             
     $order3 = orderdetails_products::create($request_dsata3);




            
}}

            curl_close($curl);
            //$webview="https://bn-plus.ly/BNplus/public/api/reservewebview/".$order->id;
            $webview = $json['url'];

            $message = "Product reserved ";

            return $this->apiResponseweb($webview, $message, 200);
        } else {
            return $this->apiResponse6(null, null, 'Enter Valid number', 404);
        }
    }


 public function backendurl2(Request $request)
    {
        
    }

    
}
