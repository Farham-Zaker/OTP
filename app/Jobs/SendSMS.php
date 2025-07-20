<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendSMS implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;
    protected $otp;

    /**
     * Create a new job instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $api_key = env('API_KEY');
        $template = env('SMS_TEMPLATE');
        $phone = $this->otp->phone_number;
        $otpValue = $this->otp->otp;

        Http::get("https://smsyar.linto.ir/api/v1/sendsms?api_key=$api_key&&phone=$phone&&template=$template&value=$otpValue");
    }
}
