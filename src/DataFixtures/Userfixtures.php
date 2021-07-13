<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

class Userfixtures extends Fixture implements  FixtureGroupInterface
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for($i=0;$i<20;$i++){
            $user= new User();
            $user->setEmail("user$i@gmail.com");
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user,'user')
            );
            $user->setUsername("user$i");
            $user->setMedia(new Media());
            $manager->persist($user);
            $this->addReference("user$i",$user);
        }

        $admin= new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername("admin");
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin,'admin')
        );

        $manager->persist($admin);
        $manager->flush();

    }

    public static function getGroups(): array
    {
        return ['groupUser'];
    }
}
