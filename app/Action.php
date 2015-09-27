<?php
/**
 * App\Action
 *
 * @property integer $action_id
 * @property integer $position
 * @property string $method
 * @property string $url
 * @property string $parse_expression
 * @property string $parse_type
 * @property integer $rule_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Rule $rule
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ActionParam[] $actionParams
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereActionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereParseExpression($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereParseType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereRuleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Action whereUpdatedAt($value)
 */
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
     * Black-list of attributes to show not in Array or JSON.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];

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
