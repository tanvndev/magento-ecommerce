<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all($column = ['*'], $relation = [], $orderBy = null);

    public function findById($modelId, $column = ['*'], $relation = []);

    public function findByWhere(
        $conditions = [],
        $column = ['*'],
        $relation = [],
        $all = false,
        $orderBy = null,
        $whereInParams = [],
        $withCount = []
    );

    public function findByWhereHas($condition = [], $column = ['*'], $relation = [], $alias = '', $all = false);

    public function findByWhereIn(
        array $values,
        string $field = 'id',
        array $columns = ['*'],
        array $relations = [],
        array $relationConditions = []
    );

    public function create($payload = []);

    public function firstOrCreate(array $condition, array $payload = []);

    public function createBatch($payload = []);

    public function createPivot($model, $payload = [], $relation = '');

    public function update($modelId, $payload = []);

    public function save($modelId, $payload = []);

    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = []);

    public function updateByWhere($condition = [], $payload = []);

    public function lockForUpdate(array $condition, array $payload);

    public function delete($modelId);

    public function updateOrCreate($payload = [], $conditions = []);

    public function deleteByWhere($conditions = []);

    public function deleteByWhereIn($whereInField = '', $whereIn = []);

    public function forceDelete($modelId);

    public function forceDeleteByWhere($conditions);

    public function pagination(
        $column = ['*'],
        $condition = [],
        $perPage = 10,
        $orderBy = ['id' => 'DESC'],
        $join = [],
        $relations = [],
        $groupBy = [],
        $withWhereHas = [],
        $rawQuery = [],
    );
}
