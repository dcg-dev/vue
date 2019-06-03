<?php
namespace App\Repositories;

use App\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository {

    /**
     * @var \Illuminate\Container\Container
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @param \Illuminate\Container\Container $app
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * @return Model
     * @throws \App\Exceptions\RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->find($id, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function update(array $data) {
        return $this->model->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        return $this->model->destroy($id);
    }

    /**
     * Retrieve all trashed.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function trashed()
    {
        return $this->model->onlyTrashed();
    }

    /**
     *  Retrieve a single record by id.
     *
     *  @param $id
     *  @return \Illuminate\Database\Eloquent\Model
     */
    public function findTrashed($id)
    {
        return $this->trashed()->find($id);
    }

    /**
     * Force delete a record.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function forceDelete($id)
    {
        $model = $this->findTrashed($id);

        if ($model) {
            $model->forceDelete();
        }

        return $model;
    }
}