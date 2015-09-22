<?php

namespace App\Http\Controllers;

use App\University;
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

        if ($updatedAtServer == null) {
            return University::all();
        } else {
            return University::newerThan($updatedAtServer)->get();
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

        if ($university->updated_at > $updatedAtServer) {
            if (Input::has('detailed') && Input::get('detailed') === "true") {
                $university->load(['rules.actions.actionParams', 'rules.transformerMappings']);
            }
            return $university;
        }

        return null;
    }
}
