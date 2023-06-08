<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\aboutappResource;
use App\Http\Resources\commenctionResource;
use App\Http\Resources\usingPlicyCotoller;
use App\Models\appSettings;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class appSettingsApiController extends Controller
{
 use GeneralTrait;
    public function index()
    {
              $appsetings=DB::table('app_settings')->select('usingplicy_ar','usingplicy_en','aboutapp_ar','aboutapp_en','facebook','twwiter','instgram','youtube','whatsapp','email','phone')->first();
              $appsetingsa=new usingPlicyCotoller($appsetings);
              return $this->returnData('app_settings',$appsetingsa);
    }
    public function deposit_amount()
    {
              $appsetings=DB::table('app_settings')->select('deposit_amount')->first();
              return $this->returnData('amount',$appsetings->deposit_amount);
    }


    public function sendsms()
    {
        
        // $client = new Client;
        // $request = $client->get('https://www.kwtsms.com/API/send/?username=lay6fk&password=aqaq12ws&sender=LAY6Fk&mobile=96599555043&lang=2&message=test sms message from technical Laytofk');
        // $response = $request->getBody();
        // $pieces = explode(":", $response);
        // return $pieces[0];
              
    }
    
    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show(appSettings $appSettings)
    {

    }


    public function edit(appSettings $appSettings)
    {

    }


    public function update(Request $request, appSettings $appSettings)
    {

    }

    public function destroy(appSettings $appSettings)
    {

    }
}
