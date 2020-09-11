<?php
namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;

class GlobalRenderService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function courseCatalog()
    {
        return $this->categoryRepository->findAll();
    }
}
