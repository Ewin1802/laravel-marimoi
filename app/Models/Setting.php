<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'store_name',
        'store_tagline',
        'store_description',

        'logo',
        'favicon',

        'hero_title',
        'hero_subtitle',
        'hero_button',

        'phone',
        'whatsapp',
        'email',
        'address',
        'google_maps',

        'facebook',
        'instagram',
        'youtube',
        'tiktok',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'copyright',

        'maintenance_mode',

    ];
}
