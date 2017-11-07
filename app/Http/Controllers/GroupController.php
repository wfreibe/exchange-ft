<?php
/**
 * Created by PhpStorm.
 * User: wfreiberger
 * Date: 06.11.17
 * Time: 17:31
 */

namespace App\Http\Controllers;

use App\Organization;
use App\User_;
use App\Users_orgs;
use App\Groups_orgs;
use App\Group;

class GroupController extends Controller {

    public function getUserOrganizationProjectsByEmailAndOrgName($email, $orgname) {

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

        $organizations = Organization::find($aUsers_org);

        $organizationId = null;
        foreach ($organizations as $organization) {

            $name = $organization->name;
            if ($name == $orgname) {
                $organizationId = $organization->organizationId;
            }
        }

        $groups_orgs = Groups_orgs::where('organizationId', $organizationId)->get();
        $aGroups_org = array();
        foreach ($groups_orgs as $groups_org) {
            $groups_org = $groups_org->groupId;
            array_push($aGroups_org, $groups_org);
        }

        $groups = Group::find($aGroups_org);

        return response()->json($groups);

    }

}