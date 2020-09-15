<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Undocumented function
     *@Route("/register", name="account_register", methods={"POST"})
     * @param ObjectManager $manager
     * @param Request $request
     * @return json
     */
    public function register(EntityManagerInterface $manager, Request $request)
    {
        //get data from request
        $postData = json_decode($request->getContent());
        
        if ($postData && filter_var($postData->email,FILTER_VALIDATE_EMAIL)) {
            // extract data and transform it as a simple variables to simplify access 
            //exemple: $postData->email become just $email
            extract((array) $postData);
            
            $user = new User();

            $user->setFirstName(htmlspecialchars($firstName))
                 ->setLastName(htmlspecialchars($lastName))
                 ->setEmail($email)
                 ->setPassword($this->encoder->encodePassword($user, $password))
                 ->setRegistrationDate(new DateTime());
            
            $manager->persist($user);
            $manager->flush();

            $this->authenticateUser($user);

            return new Response('1');
            
        }
        return new Response('empty data', 500);

    }

    private function authenticateUser(User $user, ?string $providerKey = 'main')
    {
        $token = new UsernamePasswordToken(
            $user,
            $user->getPassword(),
            $providerKey,
            $user->getRoles()
        );
        
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }

       /**
     * @Route("/login", name="account_login", methods={"POST"})
     */
    public function login()
    {
        
        $user = $this->getUser();
        return $this->json('success');
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {
        
    }

    /**
     * Delete Account
     *
     * @Route("account-delete", name="account_delete")
     * 
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function deleteAccount(EntityManagerInterface $manager, CourseRepository $courseRepository, UserRepository $userRepository)
    {
        $user = $this->getUser();
        $admin = $userRepository->findOneByEmail("admin@codemy.com");

        $courses = $courseRepository->findByFormator($user);
        
        if ($courses) {
            foreach ($courses as $course) {
                $course->setFormator($admin);
                $manager->persist($course);
            }
        }
        $session = $this->get('session');
        $session = new Session();
        $session->invalidate();
        $manager->remove($user);
        $manager->flush();
        
        return $this->redirectToRoute('home');
    }
}
