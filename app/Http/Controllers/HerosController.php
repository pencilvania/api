<?php

namespace App\Http\Controllers;

use App\Repositories\SuperHeros\SuperHerosInterface;
use App\Superheros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class HerosController extends Controller
{

    private $shRepository;
    public function __construct(SuperHerosInterface $shRepository)
    {
        $this->shRepository = $shRepository;
    }

    /**
     * @OA\Get(
     *         path="/api/heros/{id}/realname",
     *         tags={"Heros"},
     *         summary="Get Real name",
     *     @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function getRealname($id)
    {
        return $this->shRepository->getRealNameById($id);
    }

    /**
     * @OA\Get(
     *         path="/api/heros/{id}/heroname",
     *         tags={"Heros"},
     *         summary="Get Hero name",
     *  @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function getHeroname($id)
    {
        return $this->shRepository->getHeroNameById($id);
    }

    /**
     * @OA\Get(
     *         path="/api/heros/{id}/publisher",
     *         tags={"Heros"},
     *         summary="Get publisher name by id",
     *     @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function getPublishername($id)
    {
        return $this->shRepository->getPublisherById($id);
    }


    /**
     * @OA\Get(
     *         path="/api/heros/{id}/affiliations",
     *         tags={"Heros"},
     *         summary="Get affiliations list of hero by id",
     *     @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function getAffiliations($id)
    {
        return $this->shRepository->getAffiliationsById($id);
    }


    /**
     * @OA\Get(
     *         path="/api/heros/search/{name}",
     *         tags={"Heros"},
     *         summary="search hero by name",
     *       @OA\Parameter(name="name",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function searchByName($name)
    {

        return $this->shRepository->getByName($name);
    }

    /**
     * @OA\Get(
     *         path="/api/heros/findall",
     *         tags={"Heros"},
     *         summary="find all Heros",
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function findAll()
    {
        return $this->shRepository->getAll();
    }


    /**
     * @OA\Get(
     *         path="/api/heros/{id}",
     *         tags={"Heros"},
     *         summary="find hero by id",
     *     @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function findById($id)
    {
        return $this->shRepository->getById($id);
    }



    /**
     * @OA\Post(
     *       path="/api/heros/create",
     *         tags={"Heros"},
     *         summary="add new hero",
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *
     *       @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *
     *                 example={ "heroname":  "qeqwer",    "realname":  "ewrewr",      "publisher":  "sssss",      "fadate":"2017/03/22",      "affiliations": "[ { ""name"": ""name1"" }, { ""name"": ""name2"" }, { ""name"": ""name3"" }]"  }
     *             )
     *         )
     *     ),
     * )
     */
    public function create(Request $request)
    {
        return $this->shRepository->create($request->all());
    }



    /**
     * @OA\Put(
     *       path="/api/heros/{id}/update",
     *         tags={"Heros"},
     *         summary="edit  hero by id",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *
     *                 example={ "realname":  "milad","heroname":  "superman","publisher": "dc","fadate": "2019/03/24"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     * )
     */
    public function update(Request $request, $id)
    {
        $model = new Superheros();
        return $this->shRepository->update($request->only($model->getFillable()), $id);

    }



    /**
     * @OA\Delete(
     *         path="/api/heros/{id}/remove",
     *        tags={"Heros"},
     *         summary="remove one heros with id",
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     *       @OA\Parameter(name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     * )
     */
    public function remove($id)
    {

        return   $this->shRepository->remove($id);
    }



}
