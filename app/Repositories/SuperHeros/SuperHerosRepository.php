<?php


namespace App\Repositories\SuperHeros;


use App\Abilities;
use App\Affiliations;
use App\Enums\Error;
use App\Superheros;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Validator;

class SuperHerosRepository implements SuperHerosInterface
{
    private $model;
    public function __construct(Superheros $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
       return $this->model::with('affiliations')
           ->whereIn('id',[$id])->first();
    }


    public function getRealNameById($id)
    {
        try
        {
        return $this->model::find($id)->realname;
        }catch (\Exception $e)
        {
        return response()->error('Not found exception',$e->getMessage());
    }

}

    public function getAll()
    {
        return $this->model::orderby('id','desc')->paginate();
    }

    public function getByName($name)
    {
        return $this->model::where('realname', 'LIKE', '%'.$name.'%')->orwhere('heroname', 'LIKE', '%'.$name.'%')->get();
    }

    public function getHeroNameById($id)
    {
        try
        {
        return $this->model::find($id)->heroname;
        }catch (\Exception $e)
        {
            return response()->error('Not found exception',$e->getMessage());
        }

    }

    public function getPublisherById($id)
    {
        try
        {
            return $this->model::find($id)->publisher;
        }catch (\Exception $e)
        {
            return response()->error('Not found exception',$e->getMessage());
        }


    }


    public function getAffiliationsById($id)
    {
        return Affiliations::where('hero_id',$id)->orderby('id','desc')->get();
    }


    public function remove($id)
    {
        $result= $this->model::destroy($id);
        if( $result)
        {
            return response()->success('record removed',$result);
        }else {
            return response()->error('problem in process',$result);
        }
    }


    public function create(array $data)
    {
       /* $validator = Validator::make($data, [
            'heroname' => 'required|string',
            'realname' => 'required|string',
            'publisher' => 'required|string',
            'affiliations' => 'present'
        ]);*/
        $validator= Validator::make($data, Superheros::$createRules);
        if ($validator->fails()) {

            return response()->validation('problem in process', $validator->errors());
        }


        $hero =  $this->model->create($data);
        if($hero){

            if(count($data['affiliations']))
            {
                $affiliations = [];
                foreach ($data['affiliations'] as $key => $val)
                {
                    $affiliations[] = new Affiliations($val);

                }
                $hero->affiliations()->saveMany($affiliations );
            }

            return response()->success('record added successfully',$hero);
        }else{
            return response()->error('problem in add record');

        }

    }

    public function update(array $data, $id)
    {

        $validator = Validator::make($data,Superheros::$updateRules);
        if ($validator->fails()) {
            return response()->validation('problem in process', $validator->errors());
        }

        $record = $this->model->find($id);
        if($record){
         $record->update($data);
        return $this->getById($id);
        }else
        {
            return response()->error('Not found exception');
        }
    }
}
