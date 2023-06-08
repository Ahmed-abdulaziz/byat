<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
use App\Traits\imageTrait;
use App\Auctions;
use App\AuctionImages;
use App\auction_users;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\depoist_payment_users;
class CornAuctions extends Command{
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
            'name' => 'Ahmed Abdulaziz test corn job Auctions',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);



         $current = Carbon::today()->toDateString();
         
        //  ------------------------Adv------------------------------------------------------------------------------------------------
         $data = Auctions::withTrashed()->where('end_date_in_profile','<',$current)->get(); 
        foreach($data as $item){
               
                $dataim = AuctionImages::where('auction_id',$item->id)->get();          // images 
                foreach($dataim as $itemim){
                         File::delete('public/uploads/auctions/'.$itemim->img);
                           $itemim->delete();
                 }
                     
               
                $item->forceDelete();
                
        }

    // -----------------------------------------------------------------------------------------------------------------------------------------------
    
       
    }
}
