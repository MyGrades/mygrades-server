<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'actions';

    /**
     * Column of the key used by the Model.
     *
     * @var string
     */
    protected $primaryKey = "action_id";

    /**
     * Get the rule that owns the action.
     */
    public function rule()
    {
        return $this->belongsTo('App\Rule');
    }

    /**
     * Get the actionParams for the action.
     */
    public function actionParams()
    {
        return $this->hasMany('App\ActionParam');
    }
}