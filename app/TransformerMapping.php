<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TransformerMapping
 *
 * @property integer $transformer_mapping_id
 * @property string $name
 * @property string $parse_expression
 * @property string $parse_type
 * @property integer $rule_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Rule $rule
 * @method static \Illuminate\Database\Query\Builder|\App\TransformerMapping whereTransformerMappingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransformerMapping whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransformerMapping whereParseExpression($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransformerMapping whereParseType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransformerMapping whereRuleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransformerMapping whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TransformerMapping whereUpdatedAt($value)
 */
class TransformerMapping extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transformer_mappings';

    /**
     * Column of the key used by the Model.
     *
     * @var string
     */
    protected $primaryKey = "transformer_mapping_id";

    /**
     * Black-list of attributes to show not in Array or JSON.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];

    /**
     * Get the rule that owns the transformer mapping.
     */
    public function rule()
    {
        return $this->belongsTo('App\Rule', 'rule_id');
    }
}
