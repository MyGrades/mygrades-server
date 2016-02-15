<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'errors';

    /**
     * Column of the key used by the Model.
     *
     * @var string
     */
    protected $primaryKey = "error_id";

    public $timestamps = false;

    protected $dates = ['created_at', 'cron_seen'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'written' => 'boolean',
        'fixed' => 'boolean'
    ];

    /**
     * Scope to get the unseen errors.
     *
     * @param $query
     * @return mixed
     */
    public function scopeCronUnseen($query)
    {
        return $query->whereNull('cron_seen');
    }

    /**
     * Get the university that owns the error.
     */
    public function university()
    {
        return $this->belongsTo('App\University');
    }
}
