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
     * White-list of attributes to show in Array or JSON.
     *
     * @var array
     */
    protected $visible = ['university_id', 'published', 'name', 'updated_at', 'rules'];

    /**
     * Get the rules for the university.
     */
    public function rules()
    {
        return $this->hasMany('App\Rule');
    }
}
