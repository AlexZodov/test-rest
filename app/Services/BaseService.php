<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    public $repository;

    public function parametrizedResult(array $whereConditions = [], array $orderConditions = [], $start = null, $length = null){

        return $this->repository->parametrizedResult($whereConditions,$orderConditions, $start, $length);
    }

    public function create(array $input)
    {
        return $this->repository->create($input);
    }
    public function find($id = null)
    {
        return $this->repository->find($id);
    }

    public function update(array $input, $id = 0 )
    {
        return $this->repository->update($id, $input);
    }

    public function destroy($id = 0)
    {
        return $this->repository->destroy($id);
    }

    public function getCount(){
        return $this->repository->getCount();
    }

    public function setInstance(Model $instance){

        if(isset($instance)){
            $this->repository->setInstance($instance);
        }
    }
}
