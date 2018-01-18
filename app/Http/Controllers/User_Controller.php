<?php
/**
 * Created by PhpStorm.
 * User: wfreiberger
 * Date: 30.10.17
 * Time: 14:38
 */

namespace App\Http\Controllers;

use App\User_;
use App\Counter;
use Illuminate\Http\Request;

class User_Controller extends Controller {

    // https://medium.com/@paulredmond/how-to-submit-json-post-requests-to-lumen-666257fe8280 +++
    // https://laravel.com/docs/5.5/eloquent +++
    // https://laravel.com/api/5.5/Illuminate/Http/Request.html +++

    const COUNTER_NAME = "com.liferay.counter.model.Counter";

    public function createUser_(Request $request){

        $user_  = array();

        // Retrieve the user by the attributes, or create it if it doesn't exist...
        // $user_ = User_::firstOrCreate(array('name' => 'John'));

        $aRequest = $request->json()->all();

       if(User_::find($aRequest["emailAddress"]) == NULL) {

           $aRequest["uuid_"] = $this->makeUuid($this->generateUId());

           $counter = Counter::where('name', self::COUNTER_NAME)->get();
           foreach ($counter as $item) {
               $item->name = self::COUNTER_NAME;
               $newValue = intval($item->currentId)+1;
               $item->currentId = $newValue;
               $item->save();
               $aRequest["userId"] = $newValue;
           }

           try {

               $user_ = User_::firstOrCreate($aRequest);
               $user_["SUCCESS"] = "true";

           } catch (\Exception $e) {

               $user_["SUCCESS"] = "false";
               $user_["ERROR-MSG"] = $e;
           }

       } else {
           $user_["SUCCESS"] = "false";
           $user_["ERROR-MSG"] = "user is already existing";
       }

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

    public function getUser_ByUserId($userId){
        $intUserId = intval($userId);
        $user_ = User_::where('userId', $intUserId)->get();
        return response()->json($user_);
    }

    public function getUser_BySearchString($searchString) {
        $user_ = User_::where('lastName','LIKE',"%{$searchString}%")->orWhere('firstName','LIKE',"%{$searchString}%")->orWhere('emailAddress','LIKE',"%{$searchString}%")->get();
        return response()->json($user_);
    }

    /**
     * Returns generated unique ID.
     *
     * @return string
     */
    private function generateUId() {
        return substr( md5( uniqid( '', true ).'|'.microtime() ), 0, 32 );
    }
    /**
     * @param $id
     * @return mixed
     */
    private function makeUuid($id) {
        $id = substr_replace($id, "-", 8, 0);
        $id = substr_replace($id, "-", 13, 0);
        $id = substr_replace($id, "-", 18, 0);
        $id = substr_replace($id, "-", 23, 0);
        return $id;
    }

}
