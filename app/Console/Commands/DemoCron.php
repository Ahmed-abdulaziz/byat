<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use App\Advertisments;
use App\Models\Advimages;
use App\updateadvimage;
use App\updateadv;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class DemoCron extends Command
{
    use GeneralTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('cornjob_table_test')->insert([
            'name' => 'Ahmed Abdulaziz test corn job Advertisments',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);



         $current = Carbon::today()->toDateString();
         
        //  ------------------------Adv------------------------------------------------------------------------------------------------
         $data = Advertisments::withTrashed()->where('end_date_in_profile','<',$current)->get(); 
        foreach($data as $item){
                if(file_exists('public/uploads/advexamination_certificate/'.$item->examination_certificate)){
                     File::delete('public/uploads/advexamination_certificate/'.$item->examination_certificate);
                }
               
                $dataim = Advimages::where('adv_id',$item->id)->get();          // images 
                foreach($dataim as $itemim){
                         File::delete('public/uploads/advimage/'.$itemim->img);
                          $itemim->delete();
                 }
                     
                $dataupdateadvimage = updateadvimage::where('adv_id',$item->id)->get();          // images 
                foreach($dataupdateadvimage  as $itemim){
                     File::delete('public/uploads/advimage/'.$itemim->img);
                      $itemim->delete();
                 }
                $item->forceDelete();
                
        }
        
              
    
    // -----------------------------------------------------------------------------------------------------------------------------------------------
    
        
        
        
    }
}
