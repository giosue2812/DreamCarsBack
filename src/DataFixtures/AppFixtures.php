<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserRole;
use App\Repository\UserRoleRepository;
use Cassandra\Date;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $date = new \DateTime();
        $user1 = new User();
        $role1 = new Role();
        $role2 = new Role();
        $group1 = new Groupe();
        $userRole = new UserRole();

        $group1->setGroupe('GROUPE_VENTE');
        $manager->persist($group1);

        $role1->setRole('ROLE_VENTE');
        $manager->persist($role1);

        $role2->setRole('ROLE_MECANIQUE');
        $manager->persist($role2);

        $userRole->setUsers($user1);
        $userRole->setRoles($role2);
        $userRole->setStartDate($date->setDate('2020','04','14'));
        $manager->persist($userRole);

        $group1->addRole($role1);

        $user1->setFirstName('Giosue');
        $user1->setLastName('Liuzzo');
        $user1->setPassword($this->encoder->encodePassword($user1,'elisa2812'));
        $user1->setEmail('giosue_liuzzo@hotmail.be');
        $user1->setStreet('Residence Julles Trullemans');
        $user1->setNumber('11');
        $user1->setPostalCode('1480');
        $user1->setCountry('Belgique');
        $user1->setPhone('0495905955');
        $user1->addGroup($group1);
        $manager->persist($user1);

        $manager->flush();
    }
}
