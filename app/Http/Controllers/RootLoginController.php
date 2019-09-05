<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RootLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rootLogin($username)
    {
        //dd($username);
        
        if ($username ) {
            $email = $username;

            try {
                $select = User::where('email', $email)->first();

                if ($select==null) {
                    echo 'user not found';
                } else {
                    auth()->login($select);
                }
                return redirect('/home');
            } catch (\Exception $e) {
                echo 'internal error or wrong value';

            }

        }
    }


}
