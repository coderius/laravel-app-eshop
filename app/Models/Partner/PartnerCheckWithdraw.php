<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use App\Models\Partner\PartnerRequestWithdraw;

class PartnerCheckWithdraw extends Model
{
    protected $table = 'partner_check_withdraw';

    public function requestWithdraw()
    {
        return $this->belongsTo(PartnerRequestWithdraw::class, 'request_withdraw_id', 'id');
    }
}
