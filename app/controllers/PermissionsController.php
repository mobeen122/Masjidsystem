<?php
namespace App\Controllers;

use App\Models\Faculty\Profiles;
use App\Models\Faculty\Permissions;

/**
 * View and define permissions for the various profile levels.
 */
class PermissionsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->pagetitle = 'Permissions';
        parent::initialize();
    }
    /**
     * View the permissions for a profile level, and change them if we have a POST.
     */
    public function indexAction()
    {
        //$this->view->setTemplateBefore('private');

        if ($this->request->isPost()) {
   
            $pid = $this->request->getPost('profileId');
            // Validate the profile
            $profile = Profiles::findFirst("id = $pid");

            if ($profile) {

                if ($this->request->hasPost('permissions')) {

                    // Deletes the current permissions
                    $profile->getPermissions()->delete();

                    // Save the new permissions
                    foreach ($this->request->getPost('permissions') as $permission) {

                        $parts = explode('.', $permission);

                        $permission = new Permissions();
                        $permission->profilesId = $profile->id;
                        $permission->resource = $parts[0];
                        $permission->action = $parts[1];

                        $permission->save();
                    }

                    $this->flash->success('Permissions were updated with success');
                }

                // Rebuild the ACL with
                $this->acl->rebuild();

                // Pass the current permissions to the view
                $this->view->permissions = $this->acl->getPermissions($profile);
            }

            $this->view->profile = $profile;
        }

        // Pass all the active profiles
        $this->view->profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y'
            ]
        ]);
    }
}
