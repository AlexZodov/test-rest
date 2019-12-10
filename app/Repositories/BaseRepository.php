<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract  class BaseRepository
{

    public $instance = null;

    public function parametrizedResult(array $whereConditions = [], array $orderConditions = [], $start = null, $length = null){
        $fillable = $this->model->getFillable();

        $query = $this->model->select($fillable);

        if(isset($start,$length)){
            $query->skip($start)->take($length);
        }

        if(isset($whereConditions)) {

            foreach ($whereConditions as $column => $search) {
                if (in_array($column, $fillable)) {
                    $operatorAndValue = $this->resolveOperatorAndValue($search);
                    $query->where($column, $operatorAndValue['operator'], $operatorAndValue['value']);
                }

            }
        }

        if(!blank($orderConditions)){
            $column = $orderConditions['column'];
            $direction = $orderConditions['dir'];

            if (in_array($column, $fillable)) {
                if($direction==='desc'||$direction==='DESC'){
                    $query->orderByDesc($column);
                }elseif($direction==='asc'||$direction==='ASC'){
                    $query->orderBy($column);
                }else{
                    $query->orderBy($column);
                }
            }

        }

        return $query->get();
    }

    public function create($input)
    {
        $model = $this->model;
        $model->fill($input);
        $model->save();

        return $model;
    }

    public function find($id = 0)
    {
        return $this->instance ?? $this->model->where('id', $id)->first();
    }

    public function destroy($id = 0)
    {
        $model = $this->instance ?? $this->find($id);


        return $model->delete();
    }

    public function update($id = 0, array $input = [])
    {
        $model = $this->instance ?? $this->find($id);
        $model->fill($input);
        $model->save();

        return $model;
    }

    public function getCount(){
        return $this->model->count();
    }

    public function setInstance(Model $instance){
        $this->instance = $instance;
    }

    protected function resolveOperatorAndValue($value):array {
        $result = [
            'operator' => '',
            'value' => ''
        ];

        if(is_string($value)){
            $result['operator'] = 'LIKE';
            $result['value'] = '%' . $value . '%';
        }else{
            $result['operator'] = '=';
            $result['value'] = $value;
        }

        return $result;
    }
}
