<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deals\Orders;

class PartnerCheckIncrease extends Model
{
    protected $table = 'partner_check_increase';

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }

}
