<?php


namespace App\Services;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class CategoryService
{
    /**
     * @var CategoryRepository $repository
     */
    private $repository;
    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    public function __construct(CategoryRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @return Category[] if Category.lenght > 0
     * @throws \Exception if Category.lenght <= 0
     */
    public function getCategories()
    {
        $categories = $this->repository->findAll();
        if($categories)
        {
            return $categories;
        }
        else
        {
            throw new \Exception('Categories not found',404);
        }
    }

    /**
     * @param $categoryName
     * @return Category if Category != null
     * @throws Exception if Category == null
     */
    public function getCategory($categoryName)
    {
        $category = $this->repository->findOneBy(['name' => $categoryName]);
        if ($category)
        {
            return $category;
        }
        else
        {
            throw new Exception('No category found',404);
        }
    }
}
