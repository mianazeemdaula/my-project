<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use MatanYadaev\EloquentSpatial\Objects\Point;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyApiEmail;
// Models
use App\Models\User;
use App\Models\PasswordReset;
use App\Models\Review;
use App\Models\Address;

class UserController extends Controller
{
    public function profile()
    {
        $user = User::find(auth()->id());
        $data['user'] = $user;
        $data['addresses'] = $user->addresses;
        return response()->json($data, 200);
    }

    public function updateUser(Request $request)
    {
        try {
            $user= $request->user();
            $this->validate($request, [
                'mobile'=> "sometimes|unique:users,mobile,".$user->id,
                'email'=> "sometimes|unique:users,email,".$user->id,
            ]);
            if($request->has('fcm_token')){
                $user->fcm_token = $request->fcm_token;
            }
            if($request->has('email')){
                $user->email = $request->email;
                $user->email_verified_at = null;
            }if($request->has('mobile')){
                $user->mobile = $request->mobile;
                $user->mobile_verified_at = null;
            }
            if($request->has('mobile_verified_at')){
                $user->mobile_verified_at = now();
            }
            if($request->has('cnic')){
                $user->cnic = $request->cnic;
                $user->cnic_verified_at = null;
            }
            if($request->has('whatsapp')){
                $user->whatsapp = $request->whatsapp;
                $user->whatsapp_verified_at = null;
            }
            if($request->has('lat') && $request->has('lng')){
                if(count($user->addresses) == 0){
                    $address = new Address();
                    $address->user_id = $user->id;
                    $address->name = 'Default';
                    $address->address = $request->address;
                    $address->location = new Point($request->lat, $request->lng);
                    $address->save();
                }
            }
            if($request->has('name')){
                $user->name = $request->name;
            }

            if($request->has('type')){
                $user->type = $request->type;
            }
            if($request->has('image')){
                $file = $request->image;
                $ext = $file->getClientOriginalExtension();
                $fileName = time().'.'.$ext;
                $path = "profile/".$fileName;
                $image = Image::make($file->getRealPath());
                $image->save($path);
                $user->image = $path;
            }
            $user->save();
            $data['user'] = $user;
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAccount(Request $request)
    {
        $user = $request->user();
        $user->delete();
        return response()->json(['message'=>'Account deleted successfully'], 200);
    }

    public function reviews(Request $request)
    {
        $user = User::find($request->user_id);
        $query =  Review::with(['reviewer', 'user']);
        if($request->type && $request->type == 1){
            $query->where('review_by', $user->id);
        }else{
            $query->where('user_id', $user->id);
        }
        $data = $query->paginate();
        return response()->json($data, 200);
    }

    public function sendResetPasswordPin(Request $request)
    {
        $code = rand(100000,999999);
        $user =  User::where('email', $request->email)->first();
        if(!$user){
            return  response()->json(['message' => 'Email not exists'], 204);
        }
        $data = PasswordReset::where('email', $request->email)->first();
        if($data){
            PasswordReset::where('email', $request->email)->delete();
        }
        PasswordReset::insert([
            'email' => $request->email,
            'token' => $code,
            'created_at' => now(),
        ]);
        Mail::to($request->email)->send(new VerifyApiEmail($code));
        return response()->json(['message' => 'Email sent successfully'], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:password_resets',
            'password' => 'required',
            'email' => 'required',
        ]);
        $data = PasswordReset::where('email', $request->email)->first();
        if($data){
            if ($data->created_at->addMinutes(15) < now()) {
                PasswordReset::where('email', $request->email)->delete();
                return response(['message' => trans('passwords.code_is_expire')], 422);
            }
            $user = User::where('email', $request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            PasswordReset::where('email', $user->email)->delete();
            return response()->json(['message'=> 'Password reset successfully'], 200);
        }
        return response()->json(['message'=> 'email verification not in process'], 409);
    }

    public function verifyPhone(Request $request)
    {
        $user= $request->user();
        $user->mobile_verified_at = now();
        $user->save();
        return response()->json($user, 200);
    }

    public function riderLive(Request $request)
    {
        $user= $request->user();
        $user->rider()->update(['live' => $request->live]);
        return response()->json($user, 200);
    }

    public function riderLiveGeo(Request $request)
    {
        $user = $request->user();
        $rider =  $user->rider;
        $rider->live_geo = new Point($request->lat, $request->lng);
        $rider->save();
        // $user->rider()->update(['live_geo' => new Point($request->lat, $request->lng)]);
        return response()->json($user, 200);
    }
    
}
