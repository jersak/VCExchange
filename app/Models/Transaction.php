<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * dates attribute.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    /**
     * Attributes that are assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user',
        'to_user',
        'amount',
        'note'
    ];

    /**
     * Attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
}
