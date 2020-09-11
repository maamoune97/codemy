<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CourseRepository $courseRepository)
    {
        $lastCourses = $courseRepository->getLastForCardPresentation();
        return $this->render('home/home.html.twig', [
            'lastCourses' => $lastCourses,
        ]);
    }
}
