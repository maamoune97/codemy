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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{

    /**
     * Undocumented function
     *@Route("/register", name="account_register", methods={"POST"})
     * @param ObjectManager $manager
     * @param Request $request
     * @return json
     */
    public function register(EntityManagerInterface $manager, Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($_POST) {
            return $this->json(['fullName' => $_POST['firstName']. ' '.$_POST['lastName']]);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRegistrationDate(new DateTime());

            $manager->persist($user);
            $manager->flush();

            return $this->json('success');
        }

        // dd($form->createView());
        $postData = json_decode($request->getContent());
        $fullName = $postData->firstName.' '.$postData->lastName;
        return $this->json([
            'failure', 'dataContent' => $fullName,
        ]);

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
