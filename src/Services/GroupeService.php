<?php


namespace App\Services;


use App\DTO\GroupeDetailsDTO;
use App\DTO\JsonResponseDTO;
use App\Entity\Groupe;
use App\Models\Forms\GroupeForm;
use App\Repository\GroupeRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;

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
     * @return JsonResponseDTO
     */
    public function getGroupeAll()
    {
        $groupes = $this->repository->findAll();
        /**
         * Array empty to stock each groupe
         */
        $arrayGroupe = [];
        foreach ($groupes as $groupe)
        {
            /**
             * New DTO to map Groupe
             */
            $DTO = new GroupeDetailsDTO($groupe);
            $arrayGroupe[]=$DTO;
        }
        return new JsonResponseDTO('200','success',$arrayGroupe);
    }

    /**
     * @param GroupeForm $groupeForm
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function addNewGroupe(GroupeForm $groupeForm)
    {
        $date = new \DateTime();
        $groupeExist = $this->repository->findOneBy(['groupe'=>$groupeForm->getGroupe()]);
        if($groupeExist)
        {
            $groupeExist->setUpdateAt($date);
            $groupeExist->setDeleteAt(null);
            $groupeExist->setIsActive(true);
            try{
                $this->manager->flush();
            } catch (PDOException $e)
            {
                dump($e);
            }
        }
        else{
            $groupe = new Groupe();
            $groupe->setGroupe($groupeForm->getGroupe());
            try {
                $this->manager->persist($groupe);
                $this->manager->flush();
            } catch (PDOException $e)
            {
                dump($e);
            }
        }
        return $this->getGroupeAll();
    }
    /**
     * @param $groupe
     * @return Groupe|null
     */
    public function getGroupe($groupe)
    {
        return $this->repository->findOneBy(['groupe'=>$groupe]);
    }
}
