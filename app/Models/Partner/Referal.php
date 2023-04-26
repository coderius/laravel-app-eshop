<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Partner\PartnerCheck;
use App\Models\Partner\PartnerCheckIncrease;
use App\Models\Partner\PartnerCheckWithdraw;

class Referal extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'referal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function partnerCheck()
    {
        return $this->belongsTo(PartnerCheck::class, 'partner_id', 'id');
    }

    public function increases()
    {
        return $this->hasMany(PartnerCheckIncrease::class, 'partner_id', 'id');
    }

    public function withdraws()
    {
        return $this->hasMany(PartnerCheckWithdraw::class, 'partner_id', 'id');
    }

}
