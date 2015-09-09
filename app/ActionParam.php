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
     * Column of the key used by the Model.
     *
     * @var string
     */
    protected $primaryKey = "action_param_id";

    /**
     * Get the action that owns the action param.
     */
    public function action()
    {
        return $this->belongsTo('App\Action');
    }
}
