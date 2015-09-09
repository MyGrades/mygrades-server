<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'universities';

    /**
     * Column of the key used by the Model.
     *
     * @var string
     */
    protected $primaryKey = "university_id";

    /**
     * Get the rules for the university.
     */
    public function rules()
    {
        return $this->hasMany('App\Rule');
    }


    // TODO: create Query Scope for active universities
    // http://laravel.com/docs/5.1/eloquent#query-scopes

    // TODO: mutator for date? ISO8601 ?
}
