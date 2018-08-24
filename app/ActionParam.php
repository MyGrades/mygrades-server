<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ActionParam
 *
 * @property integer $action_param_id
 * @property string $key
 * @property string $value
 * @property string $type
 * @property integer $action_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Action $action
 * @method static \Illuminate\Database\Query\Builder|\App\ActionParam whereActionParamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ActionParam whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ActionParam whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ActionParam whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ActionParam whereActionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ActionParam whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ActionParam whereUpdatedAt($value)
 */
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
     * Black-list of attributes to show not in Array or JSON.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];

    /**
     * Get the action that owns the action param.
     */
    public function action()
    {
        return $this->belongsTo('App\Action', 'action_id');
    }
}
