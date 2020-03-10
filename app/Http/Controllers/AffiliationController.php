<?php

namespace App\Http\Controllers;

use App\Abilities;
use App\Affiliations;
use App\Repositories\Abilities\AbilitiesInterface;
use App\Repositories\Affiliations\AffiliationsInterface;
use App\Repositories\Affiliations\AffiliationsRepository;
use App\Repositories\SuperHeros\SuperHerosInterface;
use Illuminate\Http\Request;

class AffiliationController extends Controller
{

    private $affiliationsRepo;
    public function __construct(AffiliationsInterface $affiliationsRepo)
    {
        $this->affiliationsRepo = $affiliationsRepo;
    }


    /**
     * @OA\Post(
     *         path="/api/affiliations/create",
     *         tags={"Affiliations"},
     *         summary="create affiliations",
     *         @OA\Response(
     *             response=200,
     *             description="Successful operation"
     *         ),
     *         @OA\Response(
     *             response=500,
     *             description="Server error"
     *         ),
     *       @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *
     *                 example={"hero_id":"2", "name":  "superman"}
     *             )
     *         )
     *     ),
     * )
     */
    public function create(Request $request)
    {

        return $this->affiliationsRepo->create($request->all());

    }

    /**
     * @OA\Delete(
     *         path="/api/affiliations/{id}/remove",
     *         tags={"Affiliations"},
     *         summary="remove one affiliation with id",
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
        return $this->affiliationsRepo->remove($id);
    }







}
