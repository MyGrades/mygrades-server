<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Rule
 *
 * @property integer $rule_id
 * @property string $type
 * @property integer $university_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\University $university
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Action[] $actions
 * @method static \Illuminate\Database\Query\Builder|\App\Rule whereRuleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rule whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rule whereUniversityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rule whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TransformerMapping[] $transformerMappings
 */
class Rule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rules';

    /**
     * Column of the key used by the Model.
     *
     * @var string
     */
    protected $primaryKey = "rule_id";

    /**
     * Black-list of attributes to show not in Array or JSON.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'overview' => 'boolean',
    ];

    /**
     * Get the university that owns the rule.
     */
    public function university()
    {
        return $this->belongsTo('App\University');
    }

    /**
     * Get the actions for the rule.
     */
    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    /**
     * Get the transformer mappings for the rule.
     */
    public function transformerMappings()
    {
        return $this->hasMany('App\TransformerMapping');
    }
}
