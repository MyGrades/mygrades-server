<?php

namespace App\Http\Controllers;

use App\Wish;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

/**
 * Class WishController
 * @package App\Http\Controllers
 *
 * Handles everything regarding Resource Wishes.
 */
class WishController extends Controller
{
    /**
     * Create a new resource.
     *
     * @return Response
     */
    public function create()
    {
        DB::table('wishes')->insert([
            'university_name' => Input::get("university_name"),
            'name' => Input::get("name"),
            'message' => Input::get("message"),
            'email' => Input::get("email"),
            'app_version' => Input::get("app_version"),
            'created_at' => Carbon::now()
        ]);

        return response(null, 200);
    }

    /**
     * Shows all wishes to be processed by admins.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAdmin()
    {
        $openWishes = Wish::where('done', 0)->orderBy('wish_id', 'desc')->get();
        $doneWishes = Wish::where('done', 1)->orderBy('wish_id', 'desc')->get();
        return view('admin.wishes', ['openWishes' => $openWishes, 'doneWishes' => $doneWishes]);
    }

    /**
     * Saves the editing of wishes. An admin can select a wish as done and/or written.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAdmin()
    {
        foreach(Input::all() as $key => $value) {
            // done checked for specific wish
            if (starts_with($key, 'done') && intval($value) === 1) {
                $wish_id = intval(str_replace('done', '', $key));
                $wish = Wish::find($wish_id);

                // update wish
                $wish->done = true;
                $wish->save();
            } elseif (starts_with($key, 'written') && intval($value) === 1) {
                // written checked for specifc wish
                $wish_id = intval(str_replace('written', '', $key));
                $wish = Wish::find($wish_id);

                // update wish
                $wish->written = true;
                $wish->save();
            }
        }

        // back to form
        return redirect()->route('adminWishes');
    }
}
