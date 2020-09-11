<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{

    /**
     *@Route("/reading/{slugCourse}/{slug}", name="course_reading") 
     *
     * @param CourseRepository $courseRepository
     * @return Response
     */
    public function reading(CourseRepository $courseRepository, string $slugCourse, Chapter $currentChapter)
    {
        $course = $courseRepository->findOneBySlug($slugCourse);
        
        $nextChapter = $lastChapter = null;
        $chapters = [];
        
        foreach ($course->getParts() as $part)
        {
            foreach ($part->getChapters() as $chapter) 
            {
                $chapters[] = $chapter;
            }
        }

        foreach ($chapters as $key => $chapter)
        {
            if ($chapter === $currentChapter)
            {
                $nextChapter = $key < count($chapters) -1 ? $chapters[$key +1] : false;
                $lastChapter = $key > 0 ? $chapters[$key -1] : false;
                unset($chapters);
                break;
            }
        }

        return $this->render('course/reading.html.twig',[
            'course' => $course,
            'currentChapter' => $currentChapter,
            'nextChapter' => $nextChapter,
            'lastChapter' => $lastChapter,
        ]);
    }

    /**
     * @Route("/course/{slugCategory}/{slugSubcategory}/{slugCourse}", name="course_show")
     */
    public function show(CourseRepository $courseRepo, $slugCategory, $slugSubcategory, $slugCourse)
    {
        $course = $courseRepo->findOneBySlug($slugCourse);

        if ($course && ($course->getSubcategory()->getCategory()->getSlug() !== $slugCategory || $course->getSubCategory()->getSlug() !== $slugSubcategory)) 
        {
            return $this->redirectToRoute('course_show', [
               'slugCategory' => $course->getSubCategory()->getCategory()->getSlug(), 
               'slugSubcategory' => $course->getSubCategory()->getSlug(),
               'slugCourse' => $slugCourse 
               ] );
        }
        
        $slugNextChapter = $course->getParts()[0]->getChapters()[0]->getSlug();

        return $this->render('course/show.html.twig', [
         'course' => $course,
         'slugNextChapter' => $slugNextChapter,
        ]);
    }
}
