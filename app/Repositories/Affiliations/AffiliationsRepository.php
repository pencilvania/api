<?php


namespace App\Repositories\Affiliations;


use App\Abilities;
use App\Affiliations;
use App\HerosAbilities;
use Validator;
use App\Superheros;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
class AffiliationsRepository implements AffiliationsInterface
{
    private $model;
    public function __construct(Affiliations $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function remove($id)
    {
        $result=  $this->model::destroy($id);
        if( $result)
        {
            return response()->success('record removed',$result);
        }else {
            return response()->error('problem in process',$result);
        }
    }

    public function create(array $data)
    {

        $validatedData= Validator::make($data,Affiliations::$createRules);
        if ($validatedData->fails()) {
            return response()->validation('problem in process', $validatedData->errors());
        }

        $result= $this->model->create($data);
            if( $result)
            {
              return response()->success('record added successfully',$result);
                }else {
                return response()->error('problem in process',$result);
                }
    }
}
