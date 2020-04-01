<?php

namespace App\Listeners;

use App\Events\UserRegistredEvent;
use App\Verification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationCodeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserRegistredEvent $event
     * @return JsonResponse
     * @throws \Exception
     */
    public function handle(UserRegistredEvent $event)
    {
        try {
            $code = random_int(10000, 99999);
            $verification = new Verification;
            $verification->code = $code;
            $verification->user_id = $event->user['id'];
            $verification->created_at = Carbon::now();
            $verification->save();
            $receptor = $event->user['phone'];
            $client = new \GuzzleHttp\Client();
            $send = $client->request('GET' , 'https://api.kavenegar.com/v1/657349706A6542536E544A5742677546465835587471624335793368316C6D6A/verify/lookup.json?receptor='.$receptor.'&token='.$code.'&template=verfyPhone');
            if ($send->getStatusCode() >= 200 && $send->getStatusCode() < 300) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'کد فعالسازی با موفقیت ارسال شد'
                ]);
            }
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            return response()->json([
                'status' => 'error',
                'message' => 'کد فعالسازی ارسال نشد , دوباره تلاش کنید!'
            ]);
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            return response()->json([
                'status' => 'error',
                'message' => 'خطلا در برقراری با سرور , دوباره تلاش کنید!'
            ]);
        }
    }
}
