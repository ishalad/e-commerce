<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Mail;
use App\Mail\EmailManager;

class ProductApprovedReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product approved reminder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $shopData = Shop::where('product_status', 0)->where('verification_status', 1)->get();
        foreach ($shopData as $key => $value) {
            $start = new Carbon($value->updated_at);
            $end = now();
            $diff = $start->diffInHours($end);

            if($diff == 48) {
                $sellerEmail = User::where('id',$value->user_id)->get(['email']);
                $array['subject'] = translate('Test');
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['view'] = 'backend.sellers.verificationmail';

                try {
                    Mail::to($sellerEmail)->queue(new EmailManager($array));
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
        }

    }
}
