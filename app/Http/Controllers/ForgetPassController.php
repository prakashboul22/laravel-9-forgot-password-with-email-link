<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPassController extends Controller
{
    public function index()
    {
        return view('auth.rest');
    }

    public function forgotpasswordmailSend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $token = Str::uuid();
            $admin = Admin::where('email', $request->email)->first();
            $details = [
                'body' => route('updatepassword', ['email' => $request->email,  'token' => $token])
            ];

            if ($admin) {
                Admin::where('email', $request->email)->update([
                    'token' => $token,
                    'token_exp' => Carbon::now()->addMinutes(10)->toDateTimeString()
                ]);

                Mail::to($request->email)->send(new ForgetPassword($details));

                return response()->json([
                    'status' => 200,
                    'messages' => 'Mail Send'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Email Not Found'
                ]);
            }
        }
    }

    public function updatepassword(Request $request)
    {
        $email = $request->email;
        $ftoken = $request->token;

        return view('auth.forget', ['email' => $email, 'ftoken' => $ftoken]);
    }

    public function passwordreset(Request $request)
    {
        // print_r($_POST);

        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $admin = DB::table('admins')->where('email', $request->email)->whereNotNull('token')->where('token', $request->ftoken)->where('token_exp', '>', Carbon::now())->exists();

            if ($admin) {
                Admin::where('email', $request->email)->update([
                    'password' => $request->password,
                    'token' => null,
                    'token_exp' => null
                ]);

                return response()->json([
                    'status' => 200,
                    'messages' => 'Password Updated'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'messages' => 'Update Fail'
                ]);
            }
        }
    }
}
