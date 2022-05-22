<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    use HasFactory;
    protected $hidden = [
        'id',
    ];
    protected $appends = array('link');

    public function getLinkAttribute() {
        return 'https://iytnet.com/certprofile/' . $this->attributes['user_id'];
    }


}
