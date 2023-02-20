<?php

namespace App\Http\Controllers\Dashboard;

use App\Paymentcommissionsmodel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Order;
use App\Cards;
use App\Anaiscodes;
use App\cards_anais;
use App\Order_anais;

class Paymentcommissions extends Controller
{
    public function index(Request $request)
    {
        //dd('d');
        $tadawal =Paymentcommissionsmodel::where('companyname','تداول')->get();
        $sdaad =Paymentcommissionsmodel::where('companyname','سداد')->get();
        $moamalt=Paymentcommissionsmodel::where('companyname','معاملات')->get();


        return view('dashboard.Paymentcommissions.index', compact('tadawal','sdaad','moamalt'));

    }//end of index



public function Paymentcommissionscreate($type){
   
        return view('dashboard.Paymentcommissions.create', compact('type'));
}




    public function store(Request $request)
    {
        $rules = [
            'commissions' => 'required',
           
        ];

        $request->validate($rules);
        $request_data = $request->all();
    
    if($request->type==1){
        $request_data['companyname']='تداول';
    }
    
      if($request->type==2){
        $request_data['companyname']='سداد';
    }
    
      if($request->type==3){
        $request_data['companyname']='معاملات';
    }
    
    $request_data['commissions']=$request->commissions;

        Paymentcommissionsmodel::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.Paymentcommissions.index');
    } //end of store

    public function edit($id)
    {
        $category = Paymentcommissionsmodel::where('id', $id)->first();
        return view('dashboard.Paymentcommissions.edit', compact('category'));
    } //end of edit

    public function update(Request $request, $id)
    {

            $newprice2['commissions']= $request->commissions;
           // echo $newprice2['card_price'];echo "<br>";
            Paymentcommissionsmodel::where(array('id'=>$id))->update($newprice2);
        
     

      
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.Paymentcommissions.index');
    } //end of update

    public function destroy($id)
    {
        $category = Paymentcommissionsmodel::where('id', $id)->first();
     
     if($category->status==0){
         $newprice2['status']=1;
     }else{
                  $newprice2['status']=0;
     }
      
            Paymentcommissionsmodel::where(array('id'=>$id))->update($newprice2);
            
            
      
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.Paymentcommissions.index');
    } //end of destroy
























}//end of controller
