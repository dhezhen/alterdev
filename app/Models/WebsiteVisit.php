<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVisit extends Model
{
    public $timestamps = false;

    protected $fillable = ['visit_date', 'visitor_hash'];
}
