<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cards;
use App\Order;
use App\Carbon\Carbon;
use DB;
class orders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finalorder:daily';

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
     * @return int
     */
    public function handle()
    {
    
    
   $orderss= DB::select("select id ,paid FROM  orders ");
   
   foreach($orderss as $order){
        $finalorders= DB::delete("delete  FROM  orderallfinal where id='$order->id' and paid != '$order->paid'");
   }
    
    
     DB::insert("insert into orderallfinal( select o.id,o.client_name,o.client_number,o.card_price,c.card_name,
    
     case WHEN o.paid='true' then c.card_code else null end card_code
     ,co.name,
                case WHEN o.paid='true' then 'Completed' ELSE
                'Not Complete'
                end as status,
                o.paid,
                o.paymenttype,o.created_at
                from orders o
                left outer join cards c
                on o.card_id=c.id
                left outer join companies co
                on c.company_id=co.id where o.id not in (select id from orderallfinal ) order by o.created_at desc)");





           $this->info('Order Cummand Run successfully!.');

     //  $this->info('Order Cummand Run successfully!');
    }
}
