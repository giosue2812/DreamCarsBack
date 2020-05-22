<?php


namespace App\Services;


use App\DTO\GroupeDetailsDTO;
use App\DTO\JsonResponseDTO;
use App\Entity\Groupe;
use App\Models\Forms\GroupeForm;
use App\Repository\GroupeRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;


/**
 * Class GroupeService
 * @package App\Services
 */
class GroupeService
{
    /**
     * @var GroupeRepository $repository
     */
    private GroupeRepository $repository;
    /**
     * @var EntityManagerInterface $manager
     */
    private EntityManagerInterface $manager;

    /**
     * GroupeService constructor.
     * @param GroupeRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(GroupeRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @return Groupe[] if groupe.lenght > 0 else return array []
     * @throws \Exception if groupe.lenght <=0
     */
    public function getGroupeAll()
    {
        /**
         * Get all Groups
         */
        $groupes = $this->repository->findAll();
        /**
         * Check Groupes is null
         */
        if($groupes == null)
        {
            /**
             * If groupes is null
             */
            throw new \Exception("Not group found in database");
        }
        /**
         * Service return an array of groupes
         */
        return $groupes;
    }

    /**
     * @param GroupeForm $groupeForm
     * @return Groupe[] if groupe.lenght > 0 else return array []
     * @throws \Exception if \PDOException is rise ||
     *  Groupe.getGroupe == $groupeForm.getGroupe
     */
    public function addNewGroupe(GroupeForm $groupeForm)
    {
        /**
         * Instance of object date
         */
        $date = new \DateTime();
        /**
         * Get a new groupe from the form
         */
        $groupeExist = $this->repository->findOneBy(['groupe'=>$groupeForm->getGroupe()]);
        /**
         * If the groupe exist in the database. only if delete_is not null and isActive is = to false
         */
        if($groupeExist && $groupeExist->getDeleteAt()!= null && $groupeExist->getIsActive() == false)
        {
            /**
             * set the updateDate
             */
            $groupeExist->setUpdateAt($date);
            /**
             * set the delete date
             */
            $groupeExist->setDeleteAt(null);
            /**
             * set the isActive to true
             */
            $groupeExist->setIsActive(true);
            /**
             * Update the database
             */
            try{
                $this->manager->flush();
            } catch (PDOException $e)
            {
                throw new Exception('Unexpected error',500);
            }
        }
        /**
         * if groupe exist in the database and is always active. we send a message error
         */
        elseif ($groupeExist && $groupeExist->getDeleteAt()== null && $groupeExist->getIsActive() == true)
        {
            throw new Exception('The groupe exist in the database',404);
        }
        /**
         * Add new groupe in the database
         */
        else{
            /**
             * New instance of groupe
             */
            $groupe = new Groupe();
            /**
             * We set groupe name with groupe from groupe form
             */
            $groupe->setGroupe($groupeForm->getGroupe());
            /**
             * Persist in the database
             */
            try {
                $this->manager->persist($groupe);
                $this->manager->flush();
            } catch (PDOException $e)
            {
                /**
                 * If error
                 */
                throw new Exception('Unexpected error',500);
            }
        }
        /**
         * Service return an array of groupe
         */
        return $this->getGroupeAll();
    }

    /**
     * @param $idGroupe
     * @param GroupeForm $groupeForm
     * @return Groupe[] if groupe.lenght > 0 else return array []
     * @throws \Exception if \PDOException is rise ||
     *  Groupe.lenght <= 0
     */
    public function updateGroupe($idGroupe,GroupeForm $groupeForm)
    {
        $date = new \DateTime();
        $groupe = $this->repository->find($idGroupe);
        if($groupe)
        {
            $groupe->setGroupe($groupeForm->getGroupe());
            $groupe->setUpdateAt($date);
        }
        else
        {
            throw new Exception('Groupe not found',404);
        }
        try {
            $this->manager->flush();
        } catch (PDOException $e)
        {
            throw new Exception('Unexpected error',500);
        }
        return $this->getGroupeAll();
    }

    /**
     * @param $idGroupe
     * @return Groupe[] if groupe.lenght > 0 || return array []
     * @throws \Exception \PDOException is rise ||
     *  Groupe.lenght <= 0
     */
    public function removeGroupe($idGroupe)
    {
        /**
         * New instance of date
         */
        $date = new \DateTime();
        /**
         * Get groupe to be logical remove
         */
        $groupe = $this->repository->find($idGroupe);
        /**
         * Check if groupe exist
         */
        if($groupe)
        {
            $groupe->setDeleteAt($date);
            $groupe->setIsActive(false);
            try{
                $this->manager->flush();
            } catch (PDOException $e)
            {
                throw new Exception('Unexpected error',500);
            }
        }
        else
        {
            throw new Exception('Groupe not found',404);
        }
        return $this->getGroupeAll();
    }
    /**
     * @param $groupe
     * @return Groupe|null If Groupe.lenght > 0 else null
     */
    public function getGroupe($groupe)
    {
        return $this->repository->findOneBy(['groupe'=>$groupe]);
    }
}
