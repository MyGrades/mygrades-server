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
     * Get the rules for the university.
     */
    public function rules()
    {
        return $this->hasMany('App\Rule');
    }
}
