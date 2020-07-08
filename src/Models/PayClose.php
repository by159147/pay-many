<?php

namespace Faed\Pay\Models;

use Illuminate\Database\Eloquent\Model;

class PayClose extends Model
{
    protected $guarded = [];

    protected $casts = ['content_response'=>'array','content_request'=>'array'];
}
