<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\SubCategoryRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FormatorController extends AbstractController
{
    /**
     * @Route("/formator", name="formator_index")
     * @return Response
     */
    public function index()
    {
        return $this->render('formator/index.html.twig', [

        ]);
    }

    /**
     * @Route("/formator/create-course/description/{slug}", name="formator_create_course_description")
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     */
    public function CreateCourse(string $slug = null, Request $request, EntityManagerInterface $manager, Course $course = null)
    {
        if ($course)
        {
            if ($course->getFormator() !== $this->getUser()) {
                throw $this->createAccessDeniedException();
            }

            $form = $this->createForm(CourseType::class, $course);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $course->setUpdatedAt(new DateTime())
                    ;
                    $manager->persist($course);
                    $manager->flush();

                return $this->redirectToRoute('formator_create_course_media',[
                    'slug' => $course->getSlug(),
                ]);
            }

            return $this->render('formator/createCourse/description.html.twig',[
                'form' => $form->createView(),
                'course' => $course,
            ]);
        }
        else
        {
            if ($slug)
            {
                throw $this->createNotFoundException();
            }
        }


        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $date = new DateTime();
            $course->setCreatedAt($date)
                   ->setUpdatedAt($date)
                   ->setOnline(false)
                   ->setFormator($this->getUser())
                   ;
                   $manager->persist($course);
                   $manager->flush();

            return $this->redirectToRoute('formator_create_course_media',[
                'slug' => $course->getSlug(),
            ]);
        }

        return $this->render('formator/createCourse/description.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formator/create-course/media-cover/{slug}", name="formator_create_course_media")
     * @Security("is_granted('ROLE_USER') and user == course.getFormator()")
     * @return Response
     */
    public function CreateCourseMedia(EntityManagerInterface $manager, Course $course)
    {
        dump($course);
        return $this->render('formator/createCourse/mediaCover.html.twig', [
            'course' => $course
        ]);
    }

    /**
     *@Route("/formator/create-course/get-sub-categories", name="formator_get_subcategories", methods={"POST"})
     * @return JsonResponse
     */
    public function getSubCategoriesByCategoriy(Request $request, SubCategoryRepository $subCategoryRepository)
    {
        $category = $request->get('category');
        $subCategories = $subCategoryRepository->findByCategory($category);
        if (!$subCategories) {
            return $this->json('error', 500);
        }
        $subCategoriesReduced = [];
        foreach ($subCategories as $subCategory)
        {
            $subCategoriesReduced[$subCategory->getId()]= $subCategory->getTitle();
        }

        return $this->json($subCategoriesReduced);
    }

    /**
     *@Route("/formator/create-course/get-categories", name="formator_get_categories", methods={"POST"})
     * @return JsonResponse
     */
    public function getAllCategories(CategoryRepository $categoryRepository)
    {

        $categoriesReduced = [];
        foreach ($categoryRepository->findAll() as $category)
        {
            $categoriesReduced[$category->getId()]= $category->getTitle();
        }

        return $this->json($categoriesReduced);
    }
}
