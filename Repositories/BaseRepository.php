<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     *
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     *
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     *
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all(
        $columns = ['*'],
        string $orderBy = 'id',
        string $sortBy = 'asc'
    ) {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param  $id
     * @return  mixed
     * @throws  ModelNotFoundException
     */
    public function findOneOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param  array  $data
     * @return
     */
    public function findBy(array $data)
    {
        return $this->model->where($data)->get();
    }

    /**
     * @param  array  $data
     * @return  mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    /**
     *
     */
    public function getGroupModelsByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     *
     */
    public function groupFieldUpdateByIds($keyValuePair, $ids)
    {
        return $this->model->whereIn('id', $ids)->update($keyValuePair);
    }

    /**
     * @param  array
     *
     * @return  mixed
     */
    public function groupDeleteByIds(array $ids)
    {
        $class = get_class($this->model);

        return $class::destroy($ids);
    }

    /**
     * @param  array  $ids
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function findByIds(array $ids) : Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
   

    /**
     * @param int  $limit
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getRandomModels(int $limit = 10)
    {
        return $this->model
            ->inRandomOrder()
            ->limit($limit);
    }

    /**
     * @param  array  $parameters
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    protected function initQuery(array $parameters = [])
    {
        $class = get_class($this->model);

        return $this->getFillables(
            new $class,
            $this->model->query(),
            $parameters
        );
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param array $parameters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getFillables($model, $query, $parameters)
    {
        if ($parameters) {
            foreach ($model->getFillable() as $field) {
                if (isset($parameters[$field])) {
                    $query->where($field, $parameters[$field]);
                }
            }
        }

        return $query;
    }

    /**
     * @param  mixed  $query
     * @param  int  $pagination
     *
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    protected function getResults($query, int $pagination = 0)
    {
        if ($pagination) {
            return $query->paginate($pagination);
        }

        return $query->get();
    }

    /**
     * Adds the standard where clauses for search queries.
     *
     * For any additional where clauses, add it to the query object
     * before providing the query as the first parameter of
     * this method.
     * 
     * @param  mixed  $query
     * @param  array  $parameters
     * @param  int  $pagination
     * @param  string  $sortField
     * @param  string  $sortOrder
     * 
     * @return  mixed
     */
    protected function searchFromQuery(
        $query,
        array $parameters = [],
        int $pagination = 0,
        string $sortField = 'created_at',
        string $sortOrder = 'DESC'
    ) {
        $query->basicKeywordSearch($parameters)
            ->orderBy($sortField, $sortOrder);

        return $this->getResults($query, $pagination);
    }

    /*
     * @param iterable $ids
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchByIds(iterable $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}