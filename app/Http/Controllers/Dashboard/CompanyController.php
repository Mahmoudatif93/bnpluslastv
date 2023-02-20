<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Cards;
use App\Anaiscodes;
use App\cards_anais;
use App\Order;
use App\Client;
use App\Order_anais;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use PDF2;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
/*use\Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Firebase;
use Kreait\Firebase\Query;
use Google\Cloud\Firestore\FirestoreClient;
use Google\ApiCore\Serializer;*/
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Contract\Firestore;
use Google\Cloud\Firestore\FirestoreClient;


//use Voh\LaravelFirestore\Facades\Firestore;

use DB;

use App\currancylocal;

class CompanyController extends Controller
{
  

    
    
 
    
    /* function generateHash($time){
        $email = strtolower('merchant-email@domain.com');
        $phone = '966577753100';
        $key = '******';
        return hash('sha256',$time.$email.$phone.$key);
      }*/






    public function index(Request $request)
    {

        ini_set("prce.backtrack_limit", "100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000");






        $Companies = Company::where('enable', 0)->when($request->search, function ($q) use ($request) {

            return $q->where('name', 'like', '%' .  $request->search . '%')
                ->orWhere('kind', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);

        return view('dashboard.Companies.index', compact('Companies'));
    } //end of index

    public function create()
    {
        return view('dashboard.Companies.create');
    } //end of create

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'kind' => 'required',
        ];

        $request->validate($rules);
        $request_data = $request->all();
       if ($request->company_image) {
//dd(public_path('uploads/company/' . $nassme));

          $dd= /*  Image::make($request->file('company_image'))
               /* ->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                })*/
              
               // $request->file('company_image')->save(public_path('uploads/company/' . $nassme));
 
           // $request_data['company_image'] = 'https://bn-plus.ly/BNplus/public/uploads/company/' . $nassme;
            
               Image::make($request->company_image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/company/' . $request->company_image->hashName()));
    
             $request_data['company_image'] = 'https://bn-plus.ly/BNplus/public/uploads/company/'.$request->company_image->hashName();
             
             
        } //end of if

        Company::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.Companies.index');
    } //end of store

    public function edit($id)
    {
        $category = Company::where('id', $id)->first();
        return view('dashboard.Companies.edit', compact('category'));
    } //end of edit

    public function update(Request $request, $id)
    {
        $category = Company::where('id', $id)->first();


        $request_data = $request->except(['_token', '_method']);
        if ($request->company_image) {

            if ($category->company_image != '') {

                Storage::disk('public_uploads')->delete('/company/' . $category->company_image);
            } //end of if

            Image::make($request->company_image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/company/' . $request->company_image->hashName()));

            $request_data['company_image'] = 'https://bn-plus.ly/BNplus/public/uploads/company/' . $request->company_image->hashName();
        } //end of if



        Company::where('id', $id)->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.Companies.index');
    } //end of update

    public function destroy($id)
    {
        $category = Company::where('id', $id)->first();
        if ($category->company_image != '') {

            Storage::disk('public_uploads')->delete('/company/' . $category->company_image);
        } //end of if

        Company::where('id', $id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.Companies.index');
    } //end of destroy


    function generate_pdf()
    {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF2::loadView('dashboard.Companies.pdf', $data);
        return $pdf->stream('document.pdf');
    }

    public function sendResetEmail($user, $content, $subject)
    {

        $send =   Mail::send(
            'dashboard.Contacts.content',
            ['user' => $user, 'content' => $content, 'subject' => $subject],
            function ($message) use ($user, $subject) {
                $message->to($user);
                $message->subject("$subject");
            }
        );
    }
}//end of controller
