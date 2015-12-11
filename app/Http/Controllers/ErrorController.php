<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

/**
 * Class ErrorController
 * @package App\Http\Controllers
 *
 * Handles everything regarding Resource Error.
 */
class ErrorController extends Controller
{
    /**
     * Create a new resource.
     *
     * @return Response
     */
    public function create()
    {
        DB::table('errors')->insert([
            'university_id' => Input::get("university_id"),
            'name' => Input::get("name"),
            'message' => Input::get("message"),
            'email' => Input::get("email"),
            'app_version' => Input::get("app_version"),
            'created_at' => Carbon::now()
        ]);

        return response(null, 200);
    }

}
