<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneNumber;

class PhoneNumberController extends Controller
{
    // phone number 
    public function savePhoneNumber($phoneNumber)
    {
        PhoneNumber::create(['number' => $phoneNumber]);
        
        return response()->json([
            'message' => 'phone number saved successfully'
        ], 200);
    
    }



    public function hello()
    {
        return response()->json([
            'message' => 'hello world'
        ], 200);
    }
}
