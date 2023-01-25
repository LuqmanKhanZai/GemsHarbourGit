<?php



namespace App\Http\Controllers;

use App\Models\User;
use Mail;
use App\Mail\DemoMail;
use App\Models\UserVerify;
use Illuminate\Http\Request;



class MailController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index()

    {



        Mail::raw('Hi, Crown Jobs Running...!', function ($message) {

            $message->to('luqmankhanzai800@gmail.com')

              ->subject('Testing');

          });

        // $mailData = [

        //     'title' => 'Mail from ItSolutionStuff.com',

        //     'body' => 'This is for testing email using smtp.'

        // ];



        // Mail::to('luqmankhanzai800@gmail.com')->send(new DemoMail($mailData));



        // dd("Email is sent successfully.");

    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->email_verified_at = now();
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
                return view('email.email_return');
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
        // return "000";

      return redirect()->route('login')->with('message', $message);
    }

}

