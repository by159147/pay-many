<?php


namespace Faed\Pay\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PayRequest extends Model
{
    protected $guarded= [];

    /**
     * @return HasOne
     */
    public function payInfo()
    {
        return $this->hasOne(PayInfoRequest::class,'pay_request_id','id');
    }


}
