<?php

namespace App\Http\Controllers;

use App\University;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return University::all();
    }

    /**
     * Display the specified resource.
     *
     * @param University $university
     * @return Response
     */
    public function show(University $university)
    {
        if (Input::has('detailed') && Input::get('detailed') === "true") {
            $university->load('rules.actions.actionParams');
        }
        return $university;
    }
}
