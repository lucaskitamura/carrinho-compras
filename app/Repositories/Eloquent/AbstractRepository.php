<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\AbstractRepositoryContract;

abstract class AbstractRepository implements AbstractRepositoryContract
{
    /**
     * get all records in db
     * @return
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * find a record in db
     * @param int $id
     * @return
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * store a record in db
     * @param array $data
     * @return
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * update a record in db
     * @param int $id
     * @param array $data
     * @return
     */
    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * delete a record in db
     * @param int $id
     * @return
     */
    public function delete(int $id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
