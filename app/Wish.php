<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wishes';

    /**
     * Column of the key used by the Model.
     *
     * @var string
     */
    protected $primaryKey = "wish_id";


    protected $dates = ['created_at', 'cron_seen'];

    /**
     * Scope to get the unseen wishes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeCronUnseen($query)
    {
        return $query->whereNull('cron_seen');
    }
}
