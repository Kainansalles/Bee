<?php

namespace App\Repositories;

interface BaseRepositoryContract
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @param string $field
     * @param string $attribute
     * @return mixed
     */
    public function getByAttribute(string $field, string $attribute);

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateById(array $data, int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id) ;
}
