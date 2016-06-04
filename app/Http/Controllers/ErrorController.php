<?php

namespace App\Http\Controllers;

use App\Error;
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
            'created_at' => Carbon::now(),
            'rule_id' => Input::get("rule_id"),
            'device' => Input::get("device"),
            'android_version' => Input::get("android_version")
        ]);

        return response(null, 200);
    }

    /**
     * Shows all errors to be processed by admins.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAdmin()
    {
        $openErrors = Error::where('fixed', 0)->orderBy('error_id', 'desc')->get();
        $fixedErrors = Error::where('fixed', 1)->orderBy('error_id', 'desc')->get();
        return view('admin.errors', ['openErrors' => $openErrors, 'fixedErrors' => $fixedErrors]);
    }

    /**
     * Saves the editing of errors. An admin can select an error as fixed and/or written.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAdmin()
    {
        foreach(Input::all() as $key => $value) {
            // fixed checked for specific error
            if (starts_with($key, 'fixed') && intval($value) === 1) {
                $error_id = intval(str_replace('fixed', '', $key));
                $error = Error::find($error_id);

                // update error
                $error->fixed = true;
                $error->save();
            } elseif (starts_with($key, 'written') && intval($value) === 1) {
                // written checked for specific error
                $error_id = intval(str_replace('written', '', $key));
                $error = Error::find($error_id);

                // update error
                $error->written = true;
                $error->save();
            }
        }

        // back to form
        return redirect()->route('adminErrors');
    }
}
