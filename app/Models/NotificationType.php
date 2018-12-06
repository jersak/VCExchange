<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationType extends Model
{
    use SoftDeletes;

    /**
     * dates attribute.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'updated_at',
        'deleted_at'
    ];


    /**
     * Attributes that are assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from',
        'to',
        'amount',
        'note'
    ];

    /**
     * Attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /*
    |------------------------------------------------
    | Relationships
    |------------------------------------------------
    */

    public function notifications()
    {
        return $this->hasMany('\App\Models\Notification', 'notification_type_id');
    }
}
