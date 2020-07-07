<?php

namespace Faed\Pay\Models;

use Illuminate\Database\Eloquent\Model;

class PayRefund extends Model
{
    protected $guarded = [];
    protected $casts = ['content_response'=>'array','content_request'=>'array'];
}
