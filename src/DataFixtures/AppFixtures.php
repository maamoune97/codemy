<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Chapter;
use App\Entity\Course;
use App\Entity\Part;
use App\Entity\Prerequisite;
use App\Entity\SubCategory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
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

    public function createRandomParagraphs(int $parag = 3, int $quantityOfLine = 3){
        $faker = Factory::create();
        $about = null;
        for ($i=0; $i < $parag; $i++) { 
            $about.='<p>'.$faker->paragraphs($quantityOfLine, true).'</p>';
        }
        return $about;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        $categories = [ 
            'Informatique' => ['Développement', 'Réseaux', 'Intelligence Artificielle', 'Data Science', 'Audio-Visuel'],
            'Science Physique' => ['Mécanique', 'Electronique', 'Optique', 'Thérmodinamique', 'Physique Quantique'],
            'Mathématique' => ['Probalité & Statistique', 'Algebre', 'Analyse', 'Géometrie', 'Arithemetique'],
            'Business' => ['Marketing', 'Entrepreneuriat', 'Finance', 'Management'],
            'Science Sociale' => ['Science Juridique', 'Science Politique', 'Science Economique', 'Psychologie'],
            'Science de la vie' => ['Biologie Cellulaire', 'Biologie Animale', 'Biologie Végetale', 'Anatomie'],
            'Langue Etrangeres' => ['Anglais', 'Français', 'Arabe', 'Espagnole']
         ];

         $subCategories = [];
         $categoriesKeys = array_keys($categories);
        for ($i=0; $i < count($categories); $i++) { 
            $category = new Category();
            $category->setTitle($categoriesKeys[$i]);
            $manager->persist($category);
            $currentCategory = $categoriesKeys[$i];

            for ($j=0; $j < count($categories[$currentCategory]) ; $j++) { 
                $subCategory = new SubCategory();
                $subCategory->setTitle($categories[$currentCategory][$j]);
                $subCategory->setCategory($category);
                $manager->persist($subCategory);
                $subCategories[] = $subCategory;
            }
        }

        $users = [];
        $user = new User();
        $passwordHash = $this->encoder->encodePassword($user, 'password');
        $user->setFirstName('Maamoune')
             ->setLastName('Hassane')
             ->setEmail('maamoune97@codemy.com')
             ->setPassword($passwordHash)
             ->setRegistrationDate($faker->dateTimeBetween('-1 years'));

             $manager->persist($user);
            $users[] = $user;
             
        for ($i=0; $i < 20; $i++) { 
            $user = new User();
            $user->setFirstName($faker->firstName())
             ->setLastName($faker->lastName())
             ->setEmail($faker->email())
             ->setPassword($passwordHash)
             ->setRegistrationDate($faker->dateTimeBetween('-6 months'));

             $manager->persist($user);
            $users[] = $user;

        }


        for ($i=0; $i < 30 ; $i++) { 
            $date = $faker->dateTimeBetween('-6 months');
            $course = new Course();
            $course->setTitle($faker->sentence(5))
                   ->setDescription($this->createRandomParagraphs(mt_rand(3,5)))
                   ->setLanguage($faker->randomElement(['Fr', 'Ang', 'Es']))
                   ->setLevel($faker->randomElement(['starter', 'middle', 'high', 'expert' ]))
                   ->setOnline(false)
                   ->setCreatedAt($date)
                   ->setUpdatedAt($date)
                   ->setFormator($faker->randomElement($users))
                   ->setSubCategory($faker->randomElement($subCategories));

                   //creation des prérequis d'un cours
                   for ($p=0; $p < mt_rand(0, 6); $p++)
                   { 
                        $prerequisite = new Prerequisite();

                        $prerequisite->setTitle($faker->sentence())
                                    ->setCourse($course);
                        
                        $manager->persist($prerequisite);
                   }
            
            $manager->persist($course);

            for ($p=0; $p < mt_rand(2,5); $p++) { 
                $part = new Part();
                $part->setTitle($faker->sentence(4))
                     ->setCourse($course);
                $manager->persist($part);

                for ($c=0; $c < mt_rand(3,7); $c++) { 
                    $chapter = new Chapter();
                    $chapter->setTitle($faker->sentence(4))
                            ->setContent($this->createRandomParagraphs(mt_rand(5,10)))
                            ->setPart($part);
                    $manager->persist($chapter);
                }
            }
        }

        $manager->flush();
    }
}
