<?php

namespace App\Controller;

use App\Entity\EmailUpdate;
use App\Entity\PasswordUpdate;
use DateTime;
use App\Entity\Profile;
use App\Form\UserSettingsEmailType;
use App\Form\UserSettingsPasswordType;
use App\Repository\WorldCountriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/dashbord", name="user_dashbord")
     */
    public function dashbord()
    {
        return $this->render('user/dashbord.html.twig', [

        ]);
    }

    /**
     * @Route("/profile", name="user_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile(EntityManagerInterface $manager, WorldCountriesRepository $worldCountriesRepository)
    {
        if (isset($_POST['data'])) {
            extract($_POST['data']);
            
            $birthday = $birthday ? new DateTime($birthday) : null;
            $location = $worldCountriesRepository->findOneByAlpha3($location);
            $shareProfile = $shareProfile === "true" ? true : false;
            if ($firstName && $lastName) {
                $user = $this->getUser();
                $profile = $this->getUser()->getProfile() ? $this->getUser()->getProfile() : new Profile();
                $profile->setGender($gender)
                        ->setJob($job)
                        ->setLocation($location)
                        ->setUser($user)
                        ->setDateOfBirth($birthday)
                        ->setShareProfile($shareProfile)
                ;

                $manager->persist($profile);
                
                $user->setFirstName($firstName)
                     ->setLastName($lastName)
                     ->setProfile($profile)
                     ;
                
                $manager->persist($user);
                $manager->flush();
                return $this->json(1);
            }
            else{
                return $this->json(0);

            }
        }
        $countries = $worldCountriesRepository->findAll();
        // dd($this->getUser()->getProfile());
        return $this->render('user/profile.html.twig', [
            'countries' => $countries
        ]);
    }

    /**
     * @Route("/settings/email", name="user_settings_email")
     * @IsGranted("ROLE_USER")
     */
    public function settingsEmail(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $emailUpdate = new EmailUpdate();
        
        $form = $this->createForm(UserSettingsEmailType::class, $emailUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted())
         {
            if($user->getEmail() !== $emailUpdate->getOldEmail()) 
            {
                $form->get('oldEmail')->addError(new FormError("Adresse email actuelle incorrect"));
            }
        }
        
        if ($form->isSubmitted() && $form->isValid())
         {
            $user->setEmail($emailUpdate->getNewEmail());
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success", "Adresse email modifié avec succès");
            
        }
        
        return $this->render('user/settings/email.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * change current password
     * 
     * @Route("settings/password", name="user_settings_security")
     * @IsGranted("ROLE_USER")
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function settingsSecurity(EntityManagerInterface $manager,  Request $request, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        
        $form = $this->createForm(UserSettingsPasswordType::class, $passwordUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $uppercase = preg_match('@[A-Z]@', $passwordUpdate->getNewPass());
            $lowercase = preg_match('@[a-z]@', $passwordUpdate->getNewPass());
            $number    = preg_match('@[0-9]@', $passwordUpdate->getNewPass());

            if(!$uppercase || !$lowercase || !$number || strlen($passwordUpdate->getNewPass()) < 8) {
                $form->get('newPass')->addError(new FormError("le mot de passe doit contenir au moins 8 charachtères, 1 majuscule, 1 miniscule et 1 chiffre"));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
                $hash = $encoder->encodePassword($user, $passwordUpdate->getNewPass());
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash("success", "Mot de passe modifié avec succès");
            }
            
        return $this->render("user/settings/password.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * settings notifications
     * 
     * @Route("/settings/notifications", name="user_settings_notifications")
     *
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function settingsNotifications(EntityManagerInterface $manager)
    {
        return $this->render('user/settings/notification.html.twig', [

        ]);
    }
    
    
    /**
     * settings notifications
     * 
     * @Route("/settings/account-delete", name="user_settings_account_delete")
     *
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function settingsDeleteAccount(EntityManagerInterface $manager)
    {
        return $this->render('user/settings/deleteAccount.html.twig', [

        ]);
    }
}
