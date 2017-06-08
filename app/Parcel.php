<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcel extends Model
{
    use SoftDeletes;

    // Relation with users
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }
}
