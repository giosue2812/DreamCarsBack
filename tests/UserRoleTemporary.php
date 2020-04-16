<?php
namespace App\Util;

use App\Entity\Groupe;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserRole;
use PHPUnit\Framework\TestCase;

class UserRoleTemporary extends TestCase
{
    public function testUserRoleTemporarySucess()
    {
        $user = new User();
        $role1 = new Role();
        $role2 = new Role();
        $group = new Groupe();
        $userRole = new UserRole();
        /**
         * Creation d'un user
         */
        $user->setFirstName('Giosue');
        /**
         * Creation de deux ROLE
         */
        $role1->setRole('ROLE_VENTE');
        $role2->setRole('ROLE_MECANIQUE');
        /**
         * Creation de d'un groupe qui contiendra le role1
         */
        $group->setGroupe('GROUPE_VENTE');
        $group->addRole($role1);
        /**
         * Le user appartient au groupe "groupe_vente"
         */
        $user->addGroup($group);
        /**
         * Le User "Giosue" va avoir temporairement le "ROLE_MECANIQUE"
         */
        $userRole->setUsers($user);
        $userRole->setRoles($role2);
        $userRole->setStartDate(new \DateTime());
        $user->addUserRole($userRole);

        /**
         * Je teste si les ROLE ci-dessous sont = au role de l'user
         */
        $this->assertEquals(['ROLE_VENTE','ROLE_MECANIQUE','ROLE_USER'],$user->getRoles());
    }
    public function testUserRoleTemporaryFailed()
    {
        $user = new User();
        $role1 = new Role();
        $role2 = new Role();
        $group = new Groupe();
        $userRole = new UserRole();
        /**
         * Creation d'un user
         */
        $user->setFirstName('Giosue');
        /**
         * Creation de deux ROLE
         */
        $role1->setRole('ROLE_VENTE');
        $role2->setRole('ROLE_MECANIQUE');
        /**
         * Creation de d'un groupe qui contiendra le role1
         */
        $group->setGroupe('GROUPE_VENTE');
        $group->addRole($role1);
        /**
         * Le user appartient au groupe "groupe_vente"
         */
        $user->addGroup($group);
        /**
         * Le User "Giosue" va avoir temporairement le "ROLE_MECANIQUE"
         * Je set aussi un endDate. Le result doit être failed car le role qui a été donné a pris fin avec le EndDate
         */
        $userRole->setUsers($user);
        $userRole->setRoles($role2);
        $userRole->setStartDate(new \DateTime());
        $userRole->setEndDate(new \DateTime());
        $user->addUserRole($userRole);

        /**
         * Je teste si les ROLE ci-dessous sont = au role de l'user
         */
        $this->assertNotEquals(['ROLE_VENTE','ROLE_MECANIQUE','ROLE_USER'],$user->getRoles());
    }
}
