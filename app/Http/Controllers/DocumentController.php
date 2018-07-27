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
use App\Users_groups;
use App\Group;
use App\Dlfileentry;
use Log;

class DocumentController extends Controller {

    /**
     * @param $email
     * @param $friendlyURL
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserOrganizationProjectDocumentsByEmailAndFriendlyUrl($email, $friendlyURL) {

            $user_ = User_::where('emailAddress', $email)->get();
            $userId = null;
            foreach ($user_ as $user) {
                $userId = $user->userId;
            }
            // TODO check also if the user is in the organization


            // string(12) "53154-122342"
            $groupId = substr( $friendlyURL, strrpos( $friendlyURL, '-' )+1 );
            $dlfileentry = Dlfileentry::where('groupId', $groupId)->get();

            

            /*
            $users_orgs = Users_orgs::where('userId', $userId)->get();
            $aUsers_org = array();
            foreach ($users_orgs as $users_org) {
                $users_org = $users_org->organizationId;
                array_push($aUsers_org, $users_org);
            }

            $organizations = Organization::find($aUsers_org);

            $organizationId = null;
            foreach ($organizations as $organization) {
                $treePath = $organization->treePath;
                if ($treePath == "/".$frdlurl."/") {
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

            // add projects from user_groups table
            $users_groups = Users_groups::where('userId', $userId)->get();
            $aUsersGroups = array();
            foreach ($users_groups as $users_group) {
                array_push($aUsersGroups, $users_group->groupId);
            }

            $aGroupsOfUserId = array();
            foreach ($groups as $group) {
                if($group->creatorUserId == $userId || in_array($group->groupId, $aUsersGroups)) {
                    array_push($aGroupsOfUserId, $group);
                }
            }*/

            return response()->json($dlfileentry);

    }




}