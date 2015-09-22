<?php

namespace App\Http\Controllers;

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
        $updatedAtServer = Request::header('Updated-At-Server');

        if ($updatedAtServer === null) {
            if (Input::has('published') && Input::get('published') === "true") {
                return University::published()->get();
            } else {
                return University::all();
            }
        } else {
            if (Input::has('published') && Input::get('published') === "true") {
                return University::published()->newerThan($updatedAtServer)->get();
            } else {
                return University::newerThan($updatedAtServer)->get();
            }
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
