<?php

namespace App\Http\Controllers;

use App\Rule;
use App\University;
use Carbon\Carbon;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

/**
 * Class UniversityController
 * @package App\Http\Controllers
 *
 * Handles everything regarding Resource University.
 */
class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $updatedAtServerPublished = Request::header('Updated-At-Server-Published');
        $updatedAtServerUnpublished = Request::header('Updated-At-Server-Unpublished');

        if (Input::has('published') && Input::get('published') === "true") {
            $universities = University::published(true)->newerThan($updatedAtServerPublished)->with("rules")->get();
            // hide fields which are not needed here
            $hiddenFields = Rule::getDefaultHidden();
            array_push($hiddenFields, "semester_format", "semester_pattern", "semester_start_summer", "semester_start_winter", "grade_factor", "overview");
            Rule::setStaticHidden($hiddenFields);
            return $universities;
        } else {
            // get all universities, but differentiate between published and unpublished
            $published = University::published(true)->newerThan($updatedAtServerPublished)->get();
            $unpublished = University::published(false)->newerThan($updatedAtServerUnpublished)->get();
            return $published->merge($unpublished)->all();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param University $university
     * @return Response
     */
    public function show(University $university)
    {
        $updatedAtServer = Request::header('Updated-At-Server');

        if ($updatedAtServer === null || $university->updated_at->gt(Carbon::parse($updatedAtServer))) {
            if (Input::has('detailed') && Input::get('detailed') === "true") {
                $university->load(['rules.actions.actionParams', 'rules.transformerMappings']);
            }
            return $university;
        }

        return response(null, 304);
    }
}
