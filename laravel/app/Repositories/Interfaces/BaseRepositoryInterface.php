<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * Get all records.
     *
     * @param array|string $column
     * @param array $relation
     * @param string|null $orderBy
     * @return mixed
     */
    public function all($column = ['*'], array $relation = [], ?string $orderBy = null);

    /**
     * Find a record by its ID.
     *
     * @param mixed $modelId
     * @param array|string $column
     * @param array $relation
     * @return mixed
     */
    public function findById($modelId, $column = ['*'], array $relation = []);

    /**
     * Find records by specified conditions.
     *
     * @param array $conditions
     * @param array|string $column
     * @param array $relation
     * @param bool $all
     * @param string|null $orderBy
     * @param array $whereInParams
     * @param array $withWhereHas
     * @param array $withCount
     * @return mixed
     */
    public function findByWhere(
        array $conditions = [],
        $column = ['*'],
        array $relation = [],
        bool $all = false,
        ?string $orderBy = null,
        array $whereInParams = [],
        array $withWhereHas = [],
        array $withCount = []
    );

    /**
     * Find records by conditions with relationships.
     *
     * @param array $condition
     * @param array|string $column
     * @param array $relation
     * @param string $alias
     * @param bool $all
     * @return mixed
     */
    public function findByWhereHas(array $condition = [], $column = ['*'], array $relation = [], string $alias = '', bool $all = false);

    /**
     * Find records where the specified field is in a given array of values.
     *
     * @param array $values
     * @param string $field
     * @param array $columns
     * @param array $relations
     * @param array $relationConditions
     * @return mixed
     */
    public function findByWhereIn(
        array $values,
        string $field = 'id',
        array $columns = ['*'],
        array $relations = [],
        array $relationConditions = []
    );

    /**
     * Create a new record.
     *
     * @param array $payload
     * @return mixed
     */
    public function create(array $payload = []);

    /**
     * Create a new record or return the first record matching the given conditions.
     *
     * @param array $condition
     * @param array $payload
     * @return mixed
     */
    public function firstOrCreate(array $condition, array $payload = []);

    /**
     * Create multiple records in batch.
     *
     * @param array $payload
     * @return mixed
     */
    public function createBatch(array $payload = []);

    /**
     * Create a pivot table record.
     *
     * @param mixed $model
     * @param array $payload
     * @param string $relation
     * @return mixed
     */
    public function createPivot($model, array $payload = [], string $relation = '');

    /**
     * Update an existing record.
     *
     * @param mixed $modelId
     * @param array $payload
     * @return mixed
     */
    public function update($modelId, array $payload = []);

    /**
     * Save an existing record with the given ID.
     *
     * @param mixed $modelId
     * @param array $payload
     * @return mixed
     */
    public function save($modelId, array $payload = []);

    /**
     * Update records by the specified field where values are in a given array.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @param array $payload
     * @return mixed
     */
    public function updateByWhereIn(string $whereInField = '', array $whereIn = [], array $payload = []);

    /**
     * Update records based on specified conditions.
     *
     * @param array $condition
     * @param array $payload
     * @return mixed
     */
    public function updateByWhere(array $conditions = [], array $payload = []);

    /**
     * Lock records for update.
     *
     * @param array $condition
     * @param array $payload
     * @return mixed
     */
    public function lockForUpdate(array $conditions, array $payload);

    /**
     * Delete a record by its ID.
     *
     * @param mixed $modelId
     * @return mixed
     */
    public function delete($modelId);

    /**
     * Update or create a record based on specified conditions.
     *
     * @param array $payload
     * @param array $conditions
     * @return mixed
     */
    public function updateOrCreate(array $payload = [], array $conditions = []);

    /**
     * Delete records based on specified conditions.
     *
     * @param array $conditions
     * @return mixed
     */
    public function deleteByWhere(array $conditions = []);

    /**
     * Delete records where the specified field is in a given array of values.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @return mixed
     */
    public function deleteByWhereIn(string $whereInField = '', array $whereIn = []);

    /**
     * Permanently delete a record by its ID.
     *
     * @param mixed $modelId
     * @return mixed
     */
    public function forceDelete($modelId);

    /**
     * Permanently delete records based on specified conditions.
     *
     * @param array $conditions
     * @return mixed
     */
    public function forceDeleteByWhere(array $conditions);

    /**
     * Permanently delete records where the specified field is in a given array of values.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @return mixed
     */
    public function forceDeleteByWhereIn(string $whereInField = '', array $whereIn = []);

    /**
     * Restore records where the specified field is in a given array of values.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @return mixed
     */
    public function restoreByWhereIn(string $whereInField = '', array $whereIn = []);

    /**
     * Paginate records based on specified conditions.
     *
     * @param array|string $column
     * @param array $condition
     * @param int $perPage
     * @param array $orderBy
     * @param array $join
     * @param array $relations
     * @param array $groupBy
     * @param array $withWhereHas
     * @param array $rawQuery
     * @return mixed
     */
    public function pagination(
        array $column = ['*'],
        array $condition = [],
        int $perPage = 10,
        array $orderBy = ['id' => 'DESC'],
        array $join = [],
        array $relations = [],
        array $groupBy = [],
        array $withWhereHas = [],
        array $rawQuery = []
    );
}
