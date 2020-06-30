<?php

namespace App\Controller;

use App\DTO\GroupeDetailsDTO;
use App\Entity\Groupe;
use App\Form\GroupeType;
use App\Models\Forms\GroupeForm;
use App\Services\GroupeService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;

/**
 * Class GroupeController
 * @package App\Controller
 */

class GroupeController extends AbstractFOSRestController
{
    /**
     * @var GroupeService $groupeService
     */
    private GroupeService $groupeService;

    /**
     * GroupeController constructor.
     * @param GroupeService $groupeService
     */
    public function __construct(GroupeService $groupeService)
    {
        $this->groupeService = $groupeService;
    }

    /**
     * @Rest\Get(path="/api/groupe")
     * @IsGranted("ROLE_ADMIN")
     * @Rest\View()
     *
     * @OA\Get(
     *     tags={"Groupes"},
     *     summary="Array of Groupes",
     *     path="/groupe",
     *     security={{"bearerAuth":{}}},
     *  @OA\Response(
     *      response="404",
     *      description="Groupes no found in data-base",
     *      @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *  ),
     * @OA\Response(
     *      response="200",
     *      description="Return an array groupe",
     *      @OA\JsonContent(ref="#/components/schemas/GroupeDetailsDTO")
     *  )
     * )
     * @return array
     * @throws \Exception
     */
    public function getGroupeAllAction()
    {
        try
        {
            $groupes = $this->groupeService->getGroupeAll();
            return DataManipulation::arrayMap(GroupeDetailsDTO::class,$groupes);
        }
        catch (Exception $exception)
        {
            throw  new HttpException(404, $exception->getMessage());
        }
    }

    /**
     * @Rest\Post(path="api/groupe/addGroupe")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     *
     * @OA\Post(
     *     tags={"Groupes"},
     *     path="/groupe/addGroupe",
     *     security={{"bearerAuth":{}}},
     *     summary="Add new groupe",
     *     @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="groupe",
     *                  type="string"
     *              )
     *          )
     *      )
     *     ),
     *
     *     @OA\Response(
     *      response="400",
     *      description="Form is invalid",
     *      @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *      ),
     *     @OA\Response(
     *      response="404",
     *      description="Groupe exist in the database",
     *      @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *      ),
     *     @OA\Response(
     *      response="500",
     *      description="Unexpected Error",
     *      @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Return an array groupe",
     *      @OA\JsonContent(ref="#/components/schemas/GroupeDetailsDTO")
     *      )
     * )
     * @param Request $request
     * @return array
     */
    public function addGroupeAction(Request $request)
    {
        try
        {
            $groupeForm = new GroupeForm();
            $data = json_decode($request->getContent(),true);
            $form = $this->createForm(GroupeType::class,$groupeForm,[
                'csrf_protection' => false
            ]);
            $form->submit($data);

            if($form->isSubmitted() && $form->isValid())
            {
                $groupe = $this->groupeService->addNewGroupe($form->getData());
                return DataManipulation::arrayMap(GroupeDetailsDTO::class,$groupe);
            }

            else
            {
                throw new \Exception("Form is Invalid",400);
            }

        }
        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Put(path="api/groupe/updateGroupe/{idGroupe}")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     * @OA\Put(
     *     tags={"Groupes"},
     *     path="/groupe/updateGroupe/{idGroupe}",
     *     security={{"bearerAuth":{}}},
     *     summary="Update groupe",
     *     operationId="updateGroupe",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update groupe name",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="groupe",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *      parameter="idGroupe",
     *      name="idGroupe",
     *      in="path",
     *      description="Id of groupe to be update",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *     ),
     *     @OA\Response(
     *      response=400,
     *      description="Form is invalid",
     *      @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Groupe Not found",
     *      @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *      response=500,
     *      description="Unexpected Error",
     *      @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *      response=200,
     *      description="Groupe is updated",
     *      @OA\JsonContent(ref="#/components/schemas/GroupeDetailsDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function updateGroupeAction(Request $request)
    {
        try
        {
            $groupeForm = new GroupeForm();
            $data = json_decode($request->getContent(),true);
            $form = $this->createForm(GroupeType::class,$groupeForm,[
                'csrf_protection' => false
            ]);
            $form->submit($data);

            if($form->isSubmitted() && $form->isValid())
            {
                $groupe = $this->groupeService->updateGroupe($request->get('idGroupe'),$form->getData());
                return DataManipulation::arrayMap(GroupeDetailsDTO::class,$groupe);
            }

            else
            {
                throw new \Exception('Form is invalid',400);
            }

        }

        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Delete(path="api/groupe/removeGroupe/{idGroupe}")
     * @Rest\View()
     * @OA\Delete(
     *     tags={"Groupes"},
     *     path="/groupe/removeGroupe/{idGroupe}",
     *     security={{"bearerAuth":{}}},
     *     summary="Delete one groupe",
     *     operationId="removeGroupe",
     *     @OA\Parameter(
     *          name="idGroupe",
     *          in="path",
     *          description="Id of groupe to delete",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *           )
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Groupe not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Unexpected error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Groupe is removed",
     *          @OA\JsonContent(ref="#/components/schemas/GroupeDetailsDTO")
     *      ),
     * )
     * @param Request $request
     * @return Groupe[]
     * @throws \Exception
     */
    public function removeGroupeAction(Request $request)
    {
        try
        {
            $groupes = $this->groupeService->removeGroupe($request->get('idGroupe'));
            return DataManipulation::arrayMap(GroupeDetailsDTO::class,$groupes);
        }
        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }

    }
}
