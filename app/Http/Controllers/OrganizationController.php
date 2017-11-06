<?php
/**
 * Created by PhpStorm.
 * User: wfreiberger
 * Date: 06.11.17
 * Time: 16:15
 */

namespace App\Http\Controllers;

use App\Organization;
use App\User_;
use App\Users_orgs;

class OrganizationController extends Controller {

    public function getUserOrganizationsByEmail($email){

        $user_ = User_::where('emailAddress', $email)->get();
        $userId = null;
        foreach ($user_ as $user) {
            $userId = $user->userId;
        }

        $users_orgs = Users_orgs::where('userId', $userId)->get();
        $aUsers_org = array();
        foreach ($users_orgs as $users_org) {
            $users_org = $users_org->organizationId;
            array_push($aUsers_org, $users_org);
        }

        $organization = Organization::find($aUsers_org);

        return response()->json($organization);

    }

}