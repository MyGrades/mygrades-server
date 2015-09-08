<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionParam extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'action_params';

    /**
     * Get the action that owns the action param.
     */
    public function action()
    {
        return $this->belongsTo('App\Action');
    }
}
