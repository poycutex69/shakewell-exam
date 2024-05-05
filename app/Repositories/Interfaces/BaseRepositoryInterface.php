<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    public function all(
        $columns = array('*'),
        string $orderBy = 'id',
        string $sortBy = 'asc'
    );

    public function find($id);

    public function findOneOrFail($id);

    public function findBy(array $data);

    public function findOneBy(array $data);

    public function findOneByOrFail(array $data);   
    
    public function getGroupModelsByIds($ids);

    public function groupFieldUpdateByIds($keyValuePair, $ids);

    /**
     * @param array
     *
     * @return mixed
     */
    public function groupDeleteByIds(array $ids);
    
    

}
