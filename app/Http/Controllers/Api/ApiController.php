<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Support;
use App\Models\Category;
use App\Models\UserToCard;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ForgotPassword;
use App\Models\ProductToOffer;
use App\Models\ProductToWishlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
        // sign up api for users
        // sign up api for users
        public function signup(Request $request)
        {
            $rule = $request->validate([
                'name'     => 'required|min:1',
                'username' => 'required|min:1',
                'email'    => 'required|unique:users',
                'password' => 'required|confirmed|min:8',
            ]);

            try {
                $data = array(
                    'name'     => $request->name,
                    'username' => $request->username,
                    'email'    => $request->email,
                    'password' => bcrypt($request->password),
                    'p_text'   => $request->password,
                );

                $run = User::create($data);

                $token = Str::random(64);

                UserVerify::create([
                    'user_id' => $run->id,
                    'token' => $token
                ]);

                Mail::send('email.emailVerificationEmail', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Email Verification Mail');
                });

                $token         = $run->createToken('access-token');
                if($run){

                    return response()->json([
                        'data'        => $run,
                        'status'      => 200,
                        'accessToken' => $token->plainTextToken,
                        'message'     => 'Account Created Successfully',
                    ]);
                }

            } catch (\Exception $e) {
                return response()->json([
                    'status'       => 500,
                    'message'      => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }
        }

        // this function is used for login app users
        public function login(Request $request)
        {
            $this->validate($request, [
                'email'    => 'required',
                'password' => 'required',
            ]);

            try{

                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials,true)) {

                    $user = Auth::user()->load('store','card');
                    $product   = Product::where('user_id',$user->id)->count();
                    $product_id = ProductToWishlist::where('user_id',$user->id)->pluck('product_id');
                    $wishlist = Product::whereIn('id',$product_id)->get();
                    $token         = $user->createToken('access-token');
                    return response()->json([
                        'data'        => $user,
                        'product'     => $product,
                        'wishlist'     => $wishlist,
                        'status'      => 200,
                        'accessToken' => $token->plainTextToken,
                        'message'     => 'Account Login Successfully',
                    ]);

                }else{
                    $data = [
                        "username"  => $request->email,
                        "password" => $request->password
                    ];
                    if (Auth::attempt($data,true)) {

                        $user = Auth::user()->load('store','card');
                        $product   = Product::where('user_id',$user->id)->count();
                        $product_id = ProductToWishlist::where('user_id',$user->id)->pluck('product_id');
                        $wishlist = Product::whereIn('id',$product_id)->get();
                        $token         = $user->createToken('access-token');
                        return response()->json([
                            'data'        => $user,
                            'product'     => $product,
                            'wishlist'     => $wishlist,
                            'status'      => 200,
                            'accessToken' => $token->plainTextToken,
                            'message'     => 'Account Login Successfully',
                        ]);
                    }else{
                         return response()->json([
                            'status'      => 403,
                            'message'     => 'Invalid Username Or Password',
                        ]);
                    }
                }

            }catch (\Exception $e) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }

        }

        // this function is used for social login app user (Facebook and Google )
        public function social_login(Request $request) {
            try{
                // return $request->all();
                $user = User::where('social_id',$request->social_id)->first();
                if ($user) {
                    $response['data']        = $user;
                    $token                   = $user->createToken('access-token');
                    $response['accessToken'] = $token->plainTextToken;
                    $response['status']      = 200;
                    $response['message']     = 'login successfully';
                    $response['type']        = $user->type;
                    return response($response, 200)->header('Content-Type', 'application/json');

                }else{
                    $newPass = str::random(8);
                    $data = array(
                        'name'      => $request->name,
                        'username'      => $request->username,
                        'email'     => $request->email,
                        'password'  => Hash::make($newPass),
                        'p_text'    => $newPass,
                        'social_id' => $request->social_id,
                    );

                    if($request->hasFile('image')) {
                        $image       = $request->file('image');
                        $filename    = $image->getClientOriginalName();
                        $image_resize = Image::make($image->getRealPath());
                        $image_resize->resize(427 ,320);
                        $image_resize->save(public_path('images/user/' .$filename));
                        $url = 'images/user/'.$filename;
                        $data['image'] = $filename;
                        $data['url'] = $url;
                    }
                    $run = User::create($data);
                        $response['data']        = $run;
                        $token         = $run->createToken('access-token');
                        $response['accessToken'] = $token->plainTextToken;
                        $response['status']      = 200;
                        $response['message']     = 'login successfully';
                        return response($response,200) ->header('Content-Type', 'application/json');
                }
            }catch (\Exception $e) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }
        }

        // this function return current user info
         // this function return current user info
         public function user(Request $request)
         {
             try{
                 $user         = Auth::user();
                 $store = Store::where('user_id',$user->id)->first();
                 return response()->json([
                     'data'        => $user,
                     'store_status'        => $store ? true : false,
                     'status'      => 200,
                     'message'     => 'User Profile',
                 ]);
             }catch (\Exception $e) {
                 return response()->json([
                     'status'  => 500,
                     'message' => 'Request Failed',
                     'server_error' => $e->getMessage(),
                 ]);
             }
         }

       // Update modify user data
       public function Update_Profile(Request $request)
       {
           try {
               $user = Auth::user()->load('store','card');
               if($request->name){
                   $user->name = $request->name;
               }
               if($request->username){
                   $user->username = $request->username;
               }
               if($request->contact){
                   $user->contact = $request->contact;
               }
               $user->address        = $request->address;
               $user->city           = $request->city;
               $user->country        = $request->country;
               $user->state          = $request->state;
               $user->zipcode        = $request->zipcode;
               $user->profile_status = "5";

               if($request->image){
                   $image        = $request->file('image');
                   $extension    = $image->getClientOriginalExtension();
                   $filename     = time() . '.'.$extension;
                   $image_resize = \Image::make($image->getRealPath());
                   $image_resize->resize(427 ,320);
                   $image_resize->save(public_path('images/user/'.$filename));
                   $url = '/images/user/'.$filename;
                   $user->image = $filename;
                   $user->url   = $url;
               }

               $card = UserToCard::where('user_id',$user->id)->first();

               if($card){
                   $card->card_type    = $request->card_type;
                   $card->card_name    = $request->card_name;
                   $card->card_number    = $request->card_number;
                   $card->expire_date    = $request->expire_date;
                   $card->cvc    = $request->cvc;
                   $card->update();
               }else{
                   UserToCard::create([
                        'user_id' => Auth::user()->id,
                       'card_type' => $request->card_type,
                       'card_name' => $request->card_name,
                       'card_number' => $request->card_number,
                       'expire_date' => $request->expire_date,
                       'cvc' => $request->cvc
                   ]);
               }

               $run = $user->update();
               $users             = Auth::user()->load('store','card');
               if($run){
                   return response()->json([
                       'data'    => $users,
                       'status'  => 200,
                       'message' => 'Record Update Successfully'
                   ]);
               }
           } catch (\Exception $e) {
               return response()->json([
                   'status'       => 500,
                   'message'      => 'Request Failed',
                   'server_error' => $e->getMessage(),
               ]);
           }

       }

        // OTP SEND TO EMAIL
        public function ForgotPassword(Request $request)
        {
            try{
                $user = User::where('email',$request->email)->first();
                if($user){
                    $code         = mt_rand(1000, 9999);
                    $row          = new ForgotPassword();
                    $row->user_id = $user->id;
                    $row->email   = $user->email;
                    $row->code    = $code;
                    $run          = $row->save();

                    $dataMail = array(
                        'name'    => $user->name,
                        'contact' => $user->contact,
                        'email'   => $user->email,
                        'address' => $user->address,
                        'code'    => $code,
                    );

                    $email = $request->email;
                    $message    =  "Thanks For Using My App Your Varification Code is This " . $code;
                    Mail::raw($message, function($message) use ($email)
                    {
                        $message->from('hello@hello.com', 'Forgot Password')->subject('Welcome!');

                        $message->to($email)->cc('gemshorbour@gmail.com');
                    });
                    // Mail::raw('Thanks For Using My App Your Varification Code is This'.$code, function ($message) {
                    //     $message->to("$mail")
                    //     ->subject('Testing');
                    // });
                    // Mail::to($user->email)->send(new ForgotPasswordMail($dataMail));
                    return response()->json([
                        'status'  => 200,
                        'message' => 'OTP Sent To User Email Successfully',
                    ]);

                }else{
                    return response()->json([
                        'status'  => '204',
                        'message' => 'invalid email',
                    ]);
                }
            }catch (\Exception $e) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }

        }

         // OTP CHECK
        public function OtpChecking(Request $request)
        {
            try{
                $user = ForgotPassword::where([
                        'email' => $request->email,
                        'code' => $request->code,
                        'status' => "Sended"
                ])->first();
                //  $user = ForgotPassword::where('email',$request->email)
                //  ->where('code',$request->code)
                //  ->orwhere('status','=','Sended')->first();

                if($user){
                    // DB::table('personal_access_tokens')->where('tokenable_id',$user->id)->delete();
                    $user->status = 'Checked';
                    $user->update();

                    $run = User::where('email',$request->email)->update(['status' => 'Active']);

                    return response()->json([
                        'status'  => 200,
                        'message' => 'OTP Verified Successfully',
                    ]);
                }else{
                    return response()->json([
                        'status'  => '204',
                        'message' => 'invalid OTP',
                    ]);
                }
            }catch (\Exception $e) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }

        }

        // Password Rest
        public function ResetPassword(Request $request)
        {
            try{
                $rule = $request->validate([
                    'password' => 'required|confirmed|min:8',
                ]);

                $users                = User::where('email',$request->email)->first();
                if($users){
                    $users->password      = Hash::make($request->password);
                    $users->p_text = $request->password;
                    $users->update();
                    $dataMail = array(
                        'name'     => $users->name,
                        'contact'  => $users->contact,
                        'email'    => $users->email,
                        'address'  => $users->address,
                        'password' => $request->password,
                    );

                    $email = $request->email;
                    $message    =  'Thanks For Using My App Your New Password is This'.$request->password;
                    Mail::raw($message, function($message) use ($email)
                    {
                        $message->from('hello@hello.com', 'Update Password')->subject('Welcome!');

                        $message->to($email)->cc('gemshorbour@gmail.com');
                    });
                    // Mail::raw('Thanks For Using My App Your New Password is This'.$request->password, function ($message) {
                    //     $message->to($users->email)
                    //     ->subject('Testing');
                    // });

                    // Mail::to($users->email)->send(new ResetPasswordMail($dataMail));
                    return response()->json([
                        'status'  => 200,
                        'message' => 'Password Updated Successfully',
                    ]);
                }else{
                    return response()->json([
                        'status'  => '204',
                        'message' => 'invalid email',
                    ]);
                }
            }catch (\Exception $e) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }
        }


        // Switch Account modify user data
        public function SwitchAccount (Request $request)
        {
            try {
                $user = Auth::user()->load('store','card');
                if($user->type == "Buyer"){
                    $user->type = "Seller";
                }elseif($user->type == "Seller")
                {
                    $user->type = "Buyer";
                }
                $run = $user->update();
                if($run){
                    return response()->json([
                        'data'    => $user,
                        'status'  => 200,
                        'message' => 'Acount Switch Successfully'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status'       => 500,
                    'message'      => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }

        }

        // Support Message data
        public function SupportMessage(Request $request)
        {
            $rule = $request->validate([
                'question'     => 'required',
                'category' => 'required',
                'auction'    => 'required'
            ]);
            try {
                $request['user_id'] = $user = Auth::user()->id;
                Support::create($request->all());
                return response()->json([
                    'status'      => 200,
                    'message'     => 'Ticket Support Added Successfuly',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'       => 500,
                    'message'      => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }

        }

        // Get Support Message data
        public function GetSupportMessage(Request $request)
        {
            try{
                $support         = Support::where('user_id',Auth::user()->id)->get();
                return response()->json([
                    'data'        => $support,
                    'status'      => 200,
                    'message'     => 'All support List',
                ]);
            }catch (\Exception $e) {
                return response()->json([
                    'status'  => 500,
                    'message' => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }
        }

        public function UserOffer()
        {
            try {
                $offer = ProductToOffer::where('user_id',Auth::user()->id)->with('product')->get();
                if(!$offer){
                    return response()->json([
                        'status'      => 200,
                        'message'     => 'NO Offer On Product',
                    ]);
                }else{
                    return response()->json([
                        'data'      => $offer,
                        'status'      => 200,
                        'message'     => 'Offer On Product',
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status'       => 500,
                    'message'      => 'Request Failed',
                    'server_error' => $e->getMessage(),
                ]);
            }
        }

}
