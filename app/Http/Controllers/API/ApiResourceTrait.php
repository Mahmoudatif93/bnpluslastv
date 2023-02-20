<?php
namespace App\Http\Controllers\API;

    trait ApiResourceTrait{



  public function apiResponsewebtaw($error=null,$code=200){
            $array=[
                'error'=>$error,
                'code' =>$code,
            ];
            return response($array,$code);
        }
        
        

        public function apiResponseweb($webview=null,$error=null,$code=200){
            $array=[
                '$webview'=>$webview,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }
        

        public function apiResponse($data=null,$error=null,$code=200){
            $array=[
                'data'=>$data,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }

        public function apiResponse2($count=null,$error=null,$code=200){
            $array=[
                'count'=>$count,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }
        public function apiResponse3($orderid=null,$error=null,$code=200){
            $array=[
                'order ID'=>$orderid,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }

        public function apiResponse4($success=false,$error=null,$code=null){
            $array=[
                'success'=>$success,
                'code'=>$code,
                'message' =>$error,
            ];
            return response($array,$code);
        }

        public function apiResponse5($success=false,$error=null,$code=null,$result=null,$orderid=null){
            $array=[
                'success'=>$success,
                'code'=>$code,
                'message' =>$error,
                'result'=>$result,
                'orderid'=>$orderid,
            ];
            return response($array,$code);
        }


        public function apiResponse6($count=null,$orderid=null,$error=null,$code=200){
            $array=[
                'count'=>$count,
                'order ID'=>$orderid,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }
        
        
             public function apiResponse88w($price=null,$error=null,$code=200){
            $array=[
                'price'=>$price,
               
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }




    public function apiResponsesales($data=null,$total=0,$error=null,$code=200){
            $array=[
                'data'=>$data,
                'total'=>$total,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }




    }


    

?>
