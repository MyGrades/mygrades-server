<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\University
 *
 * @property integer $university_id
 * @property boolean $published
 * @property string $short_name
 * @property string $name
 * @property string $sponsorship
 * @property string $state
 * @property integer $student_count
 * @property integer $year_established
 * @property string $street
 * @property string $plz
 * @property string $city
 * @property string $website
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rule[] $rules
 * @method static \Illuminate\Database\Query\Builder|\App\University whereUniversityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University wherePublished($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereShortName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereSponsorship($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereStudentCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereYearEstablished($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University wherePlz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\University whereUpdatedAt($value)
 */
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
    protected $visible = ['university_id', 'published', 'name', 'updated_at_server', 'rules'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['updated_at_server'];

    /**
     * Get the rules for the university.
     */
    public function rules()
    {
        return $this->hasMany('App\Rule', 'university_id');
    }

    /**
     * Custom attribute for updated_at_server column.
     *
     * @return string
     */
    public function getUpdatedAtServerAttribute()
    {
        return $this->updated_at->toDateTimeString();
    }

    /**
     * Scope to test whether this university is newer, compared to the given updatedAtServer timestamp.
     *
     * @param $query
     * @param $updatedAtServer
     * @return mixed
     */
    public function scopeNewerThan($query, $updatedAtServer)
    {
        if ($updatedAtServer === null) {
            return $query;
        }

        return $query->where('updated_at', '>', $updatedAtServer);
    }

    /**
     * Scope to test whether this university is published.
     *
     * @param $query
     * @param published
     * @return mixed
     */
    public function scopePublished($query, $published)
    {
        return $query->where('published', $published);
    }
}
