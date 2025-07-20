<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOTPRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Jobs\SendSMS;
use App\Models\OTP;
use Barryvdh\Reflection\DocBlock\Tag\ReturnTag;
use Carbon\Carbon;
use Exception;
use Log;

use function PHPUnit\Framework\returnSelf;

class OTPController extends Controller
{
    public function send(SendOTPRequest $reqeust)
    {
        try {
            [
                'phone_number' => $phone_number
            ] = $reqeust->validated();

            // Find all OTPs sent to this phone number in the last 10 minutes
            $otps = Otp::where('phone_number', $phone_number)
                ->where('created_at', '>', Carbon::now()->subMinute(10))
                ->get();

            // Check if any OTPs are used or if the count exceeds 3
            foreach ($otps as $otp) {
                if ($otp->is_used) return response()->json([
                    'statusCode' => 400,
                    'message' => 'Invalid OTP.'
                ], 400);
            }

            // If there are already 3 OTPs sent in the last 10
            if ($otps->count() >= 3) {
                return response()->json([
                    'statusCode' => 429,
                    'message' => 'Too many requests. Please try again 10 minutes later.'
                ], 429);
            }

            // Create a new OTP
            $otp = OTP::create([
                'phone_number' => $phone_number,
                'otp' => rand(100000, 999999),
                'expired_at' => Carbon::now()->addMinutes(5),
                'is_used' => false,
            ]);

            SendSMS::dispatch($otp);

            return response()->json([
                'statusCode' => 201,
                'message' => 'The otp sent to desired phone number. So send it to {api/otp/verify} endpoint.',
            ], 201);
        } catch (Exception $err) {
            Log::error('OTP send error: ' . $err->getMessage());

            return response()->json([
                'statusCode' => 500,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }
    public function verify(VerifyOtpRequest $request)
    {
        try {
            [
                'phone_number' => $phone_number,
                'otp' => $otpValue
            ] = $request->validated();

            $otp = OTP::where('phone_number', $phone_number)->latest()->first();

            // return $otp->otp != $otpValue;
            if (
                $otp->is_used // Check if the OTP is already used
                ||
                $otp->otp !== $otpValue // Check if the OTP is not equal to the provided value
            ) return response()->json([
                'statusCode' => 400,
                'message' => 'Invalid OTP.'
            ], 400);

            // Check if the OTP is expired
            if ($otp->expired_at < Carbon::now()) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'OTP expired.'
                ], 400);
            }

            // Mark the OTP as used
            $otp->is_used = true;
            $otp->save();

            return response()->json([
                'statusCode' => 200,
                'message' => 'OTP verified successfully.',
                'token' => 'xxxxxxxxxxxxx'
            ], 200);
        } catch (Exception $err) {
            Log::error('OTP send error: ' . $err->getMessage());

            return response()->json([
                'statusCode' => 500,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }
}
