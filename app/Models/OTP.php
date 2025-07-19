<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasUuids, HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'O_T_Ps';

    protected $fillable = [
        "phone_number",
        "otp",
        "expired_at",
        "is_used"
    ];
}
