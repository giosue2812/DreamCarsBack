<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $date = new \DateTime();
        $user1 = new User();
        $user2 = new User();
        $user3 = new User();
        $role1 = new Role();
        $role2 = new Role();
        $role3 = new Role();
        $groupe1 = new Groupe();
        $groupe2 = new Groupe();
        $groupe3 = new Groupe();
        $userRole = new UserRole();

        $groupe1->setGroupe('GROUPE_VENTE');
        $manager->persist($groupe1);
        $groupe2->setGroupe('GROUPE_MECANIQUE');
        $manager->persist($groupe2);
        $groupe3->setGroupe('GROUPE_DIRECTION');
        $manager->persist($groupe3);

        $role1->setRole('ROLE_VENTE');
        $manager->persist($role1);
        $role2->setRole('ROLE_MECANIQUE');
        $manager->persist($role2);
        $role3->setRole('ROLE_ADMIN');
        $manager->persist($role3);

        $userRole->setUsers($user1);
        $userRole->setRoles($role1);
        $userRole->setStartDate($date->setDate('2020','04','14'));
        $manager->persist($userRole);

        $groupe1->addRole($role1);
        $groupe2->addRole($role2);
        $groupe3->addRole($role3);

        $user1->setFirstName('Giosue');
        $user1->setLastName('Liuzzo');
        $user1->setPassword($this->encoder->encodePassword($user1,'elisa2812'));
        $user1->setEmail('giosue_liuzzo@hotmail.be');
        $user1->setStreet('Residence Julles Trullemans');
        $user1->setNumber('11');
        $user1->setPostalCode('1480');
        $user1->setCountry('Belgique');
        $user1->setPhone('0495905955');
        $user1->setCity('Saintes');
        $user1->addGroup($groupe2);
        $manager->persist($user1);

        $user2->setFirstName('Elisa');
        $user2->setLastName('Natale');
        $user2->setPassword($this->encoder->encodePassword($user2,'goku1306'));
        $user2->setEmail('elisa.n@hotmail.be');
        $user2->setStreet('Residence Julles Trullemans');
        $user2->setNumber('11');
        $user2->setPostalCode('1480');
        $user2->setCountry('Belgique');
        $user2->setPhone('0498661703');
        $user2->setCity('Saintes');
        $user2->addGroup($groupe1);
        $manager->persist($user2);

        $user3
            ->setFirstName('Admin')
            ->setLastName('Admin')
            ->setPassword($this->encoder->encodePassword($user3,'admin'))
            ->setEmail('admin@admin.com')
            ->setStreet('Admin')
            ->setNumber('10')
            ->setPostalCode('1245')
            ->setCountry('Belgique')
            ->setPhone('04454454')
            ->setCity('Saintes')
            ->addGroup($groupe3);
        $manager->persist($user3);

        $manager->flush();
    }
}
