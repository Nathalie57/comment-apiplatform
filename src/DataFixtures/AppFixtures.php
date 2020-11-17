<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * Password encoder
     * 
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($u = 0; $u < 20; $u++) {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, "password");

            $user->setUsername($faker->firstName() . $u)
                 ->setPassword($hash);

            $manager->persist($user);

            for ($s = 0; $s < mt_rand(0, 5); $s++) {
                $comment = new Comment();
                $comment->setContent($faker->paragraph($nbSentences = 3, $variableNbSentences = true))
                        ->setReported($faker->boolean($chanceOfGettingTrue = 20))
                        ->setDisplayed($faker->boolean($chanceOfGettingTrue = 90))
                        ->setSentAt($faker->dateTimeBetween('-6 months'))
                        ->setUser($user);
                
                $manager->persist($comment);
            }
        }

        

        $manager->flush();
    }
}
