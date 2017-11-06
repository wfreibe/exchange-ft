<?php
/**
 * Created by PhpStorm.
 * User: wfreiberger
 * Date: 30.10.17
 * Time: 14:38
 */

namespace App\Http\Controllers;

use App\User_;

class User_Controller extends Controller {

    // https://laravel.com/docs/5.5/eloquent

    public function createUser_(Request $request){
        $user_ = User_::create($request->all());
        return response()->json($user_);
    }

    public function updateUser_(Request $request, $id){
        $user_  = User_::find($id);
        $user_->emailAddress = $request->input('emailAddress');
        $user_->firstName = $request->input('firstName');
        $user_->lastName = $request->input('lastName');
        $user_->save();
        return response()->json($user_);
    }

    public function deleteUser_($id){
        $user_  = User_::find($id);
        $user_->delete();

        return response()->json('Removed successfully.');
    }

    public function index(){
        $user_  = User_::all();
        return response()->json($user_);
    }

    public function getUser_ByEmail($email){
        $user_ = User_::where('emailAddress', $email)->get();
        return response()->json($user_);
    }

}
