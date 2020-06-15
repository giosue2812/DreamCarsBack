<?php


namespace App\Services;


use App\Entity\Category;
use App\Models\Forms\CategoryForm;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Driver\PDOException;
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
    public function getCategoriesList()
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

    /**
     * @param $categoryId
     * @return array if Array.lenght > 0
     * @throws Exception if Array.lenght <= 0
     */
    public function getCategoryId($categoryId)
    {
        $arrayCategory = [];
        $category = $this->repository->find($categoryId);
        if($category)
        {
            $arrayCategory[] =  $category;
            return $arrayCategory;
        }
        else
        {
            throw new Exception('No category found',404);
        }
    }

    /**
     * @param CategoryForm $categoryForm
     * @param  integer $categoryId
     * @return Category[] if Category.lenght > 0 and category != null
     * @throws \Exception if Category.lenght <= 0 or PDOException is rise or category == null
     */
    public function editCategory(CategoryForm $categoryForm, $categoryId)
    {
        $date = new \DateTime();
        $category = $this->getCategoryById($categoryId);
        if($category)
        {
            $category
                ->setName($categoryForm->getName())
                ->setUpdateAt($date);
            $categoryCheck = $this->repository->findOneBy(['name'=>$category->getName()]);
            if(!$categoryCheck)
            {
                try {
                    $this->manager->flush();
                    return $this->getCategoriesList();
                }
                catch (PDOException $exception)
                {
                    throw new Exception('Unexpected Error',500);
                }
            }
            else
            {
                throw new Exception('Category already exist',404);
            }
        }
        else
        {
            throw new Exception('No found category',404);
        }
    }

    /**
     * @param $categoryId
     * @return Category[] if Category.lenght > 0 and category != null
     * @throws \Exception if PDOException is rise or Category.lenght <=0 or category == null
     */
    public function removeCategory($categoryId)
    {
        $date = new \DateTime();
        $category = $this->getCategoryById($categoryId);
        if($category)
        {
            try {
                $category
                    ->setDeleteAt($date)
                    ->setUpdateAt($date)
                    ->setIsActive(false);
                $this->manager->flush();
                return $this->getCategoriesList();
            }
            catch (PDOException $exception)
            {
                throw new Exception('Unexpected Error',500);
            }
        }
        else
        {
            throw new Exception('Category not found',404);
        }
    }

    /**
     * @param CategoryForm $categoryForm
     * @return array array.lenght > 0 if PDOException is not rise
     * @throws \Exception if $categoryCheck == null or PDOException is rise
     */
    public function newCategory(CategoryForm $categoryForm)
    {
        $categoryCheck = $this->repository->findOneBy(['name'=>$categoryForm->getName()]);
        if($categoryCheck)
        {
            throw new Exception('Category already exist in the database',404);
        }
        else
        {
            $category = new Category();
            $category->setName($categoryForm->getName());
            try {
                $this->manager->persist($category);
                $this->manager->flush();
                return $this->getCategoriesList();
            }
            catch (PDOException $exception)
            {
                throw new Exception('Unexpected Error',500);
            }
        }
    }
    /**
     * @param integer $categoryId
     * @return Category|null
     */
    private function getCategoryById($categoryId)
    {
        return $this->repository->find($categoryId);
    }
}
