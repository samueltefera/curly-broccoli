<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PhoneNumber;
use App\Mail\DeleteAccountOtpMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // add user check if the phone number exists
    public function addUser(Request $request)
    {
        $phoneNumber = PhoneNumber::where('number', $request->phoneNumber)->first();

        if (!$phoneNumber) {
            return response()->json([
                'message' => 'phone number does not exist'
            ], 400);
        }
        $userr = User::where('email', $request->email)->first();
        if ($userr) {
            return response()->json([
                'message' => 'user already exists'
            ], 400);
        }
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return response()->json([
            'message' => 'user created successfully'
        ], 200);
    }

    public function deleteUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'user does not exist'
            ], 400);
        }
        $user->delete();
        return response()->json([
            'message' => 'user deleted successfully'
        ], 200);
    }


    public function sendOtpForDeletion(Request $request)
    {
        // generate otp
        $otp = rand(100000, 999999);
        // save otp in database
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'user does not exist'
            ], 400);
        }
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();
        // send otp to user
        try{
            Mail::to($user->email)->send(new DeleteAccountOtpMail($otp));
            return response()->json([
                'message' => 'otp sent successfully'
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }



    }


    public function verifyOtpForDeletion(Request $request)
    {
        // check if otp exists and is not expired
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'user does not exist'
            ], 400);
        }
        if ($user->otp != $request->otp) {
            return response()->json([
                'message' => 'otp is incorrect'
            ], 400);
        }
        if ($user->otp_expires_at < now()) {
            return response()->json([
                'message' => 'otp is expired'
            ], 400);
        }
        // delete user
        $user->delete();
        return response()->json([
            'message' => 'user deleted successfully'
        ], 200);
    }



}




