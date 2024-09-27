<?php

// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }

    /**
     * Get all records.
     *
     * @param array|string $column
     * @param array $relation
     * @param string|null $orderBy
     * @return mixed
     */
    public function all($column = ['*'], array $relation = [], ?string $orderBy = null)
    {
        $query = $this->model->select($column);

        if (! is_null($orderBy)) {
            $query->customOrderBy($orderBy);
        }

        if (! empty($relation)) {
            return $query->relation($relation)->get();
        }

        return $query->get();
    }

    /**
     * Find a record by its ID.
     *
     * @param mixed $modelId
     * @param array|string $column
     * @param array $relation
     * @return mixed
     */
    public function findById($modelId, $column = ['*'], array $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

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
    ) {
        $query = $this->model->select($column);

        if (! empty($relation)) {
            $query->relation($relation);
        }

        $query->customWhere($conditions);

        if (! empty($whereInParams)) {
            $query->whereIn($whereInParams['field'], $whereInParams['value']);
        }

        if (! is_null($orderBy)) {
            $query->customOrderBy($orderBy);
        }

        if (! empty($withCount)) {
            $query->withCount($withCount);
        }

        if (! empty($withWhereHas)) {
            // 'relation_name' => [
            //     ['field', 'operator', 'value'],
            // ]
            $query->whereHasRelations($withWhereHas);
        }

        return $all ? $query->get() : $query->first();
    }

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
    ) {
        $query = $this->model->newQuery()->whereIn($field, $values);

        if (! empty($columns)) {
            $query->select($columns);
        }

        if (! empty($relations)) {
            $query->with($relations);
        }

        if (! empty($relationConditions)) {
            // 'relation_name' => [
            //     ['field', 'operator', 'value'],
            // ]
            $query->whereHasRelations($relationConditions);
        }

        return $query->get();
    }

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
    public function findByWhereHas(array $condition = [], $column = ['*'], array $relation = [], string $alias = '', bool $all = false)
    {

        $query = $this->model->select($column);
        $query->whereHas($relation, function ($query) use ($condition, $alias) {
            foreach ($condition as $key => $value) {
                $query->where($alias . '.' . $key, $value);
            }
        });

        return $all ? $query->get() : $query->first();
    }

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
    ) {
        $query = $this->model->select($column);
        $query->search($condition['search'] ?? null, $condition['searchFields'] ?? null)
            ->publish($condition['publish'] ?? null)
            ->customWhere($condition['where'] ?? null)
            ->customWhereRaw($rawQuery['whereRaw'] ?? null)
            ->relation($relations ?? null)
            ->relationCount($relations ?? null)
            ->customJoin($join ?? null)
            ->customGroupBy($groupBy ?? null)
            ->customOrderBy($orderBy ?? null);

        if (! empty($withWhereHas)) {
            // Apply constraints to eager-loaded relationships
            foreach ($withWhereHas as $relation => $callback) {
                $query->whereHas($relation, $callback);
            }
        }

        if (! empty($condition['archive'] ?? null) && $condition['archive'] == true) {
            $query->onlyTrashed();
        }

        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new record.
     *
     * @param array $payload
     * @return mixed
     */
    public function create(array $payload = [])
    {
        $create = $this->model->create($payload);

        return $create->fresh();
    }

    /**
     * Create a new record or return the first record matching the given conditions.
     *
     * @param array $condition
     * @param array $payload
     * @return mixed
     */
    public function firstOrCreate(array $condition, array $payload = [])
    {
        $create = $this->model->firstOrCreate($condition, $payload);

        return $create;
    }

    /**
     * Create multiple records in batch.
     *
     * @param array $payload
     * @return mixed
     */
    public function createBatch(array $payload = [])
    {
        return $this->model->insert($payload);
    }

    /**
     * Create a pivot table record.
     *
     * @param mixed $model
     * @param array $payload
     * @param string $relation
     * @return mixed
     */
    public function createPivot($model, array $payload = [], string $relation = '')
    {
        // attach($model->id, $payload) là phương thức được gọi để thêm một bản ghi mới vào bảng pivot.
        return $model->{$relation}()->attach($model->id, $payload);
    }

    /**
     * Update an existing record.
     *
     * @param mixed $modelId
     * @param array $payload
     * @return mixed
     */
    public function update($modelId, array $payload = [])
    {
        $model = $this->findById($modelId);

        return $model->update($payload);
    }

    /**
     * Save an existing record with the given ID.
     *
     * @param mixed $modelId
     * @param array $payload
     * @return mixed
     */
    public function save($modelId, array $payload = [])
    {
        $model = $this->findById($modelId);
        $model->fill($payload);
        $model->save();

        return $model;
    }

    /**
     * Lock records for update.
     *
     * @param array $conditions
     * @param array $payload
     * @return mixed
     */
    public function lockForUpdate(array $conditions, array $payload)
    {
        return $this->model->newQuery()
            ->customWhere($conditions)
            ->lockForUpdate()
            ->firstOrFail()
            ->fill($payload)
            ->save();
    }

    // Truyen vao ham updateByWhereIn (Field name, array field name, va mang data can update)
    /**
     * Update records by the specified field where values are in a given array.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @param array $payload
     * @return mixed
     */
    public function updateByWhereIn(string $whereInField = '', array $whereIn = [], array $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }

    /**
     * Update records based on specified conditions.
     *
     * @param array $conditions
     * @param array $payload
     * @return mixed
     */
    public function updateByWhere(array $conditions = [], array $payload = [])
    {
        $query = $this->model->newQuery();

        return $query->customWhere($conditions)->update($payload);
    }

    /**
     * Update or create a record based on specified conditions.
     *
     * @param array $payload
     * @param array $conditions
     * @return mixed
     */
    public function updateOrCreate(array $payload = [], array $conditions = [])
    {
        $this->model->updateOrCreate($conditions, $payload);
    }

    /**
     * Delete a record by its ID.
     *
     * @param mixed $modelId
     * @return mixed
     */
    public function delete($modelId)
    {
        return $this->model->where('id', $modelId)->delete();
    }

    /**
     * Delete records based on specified conditions.
     *
     * @param array $conditions
     * @return mixed
     */
    public function deleteByWhere(array $conditions = [])
    {
        $query = $this->model->newQuery();

        return $query->customWhere($conditions)->delete();
    }

    /**
     * Delete records where the specified field is in a given array of values.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @return mixed
     */
    public function deleteByWhereIn(string $whereInField = '', array $whereIn = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->delete();
    }

    // Xoá cứng
    /**
     * Permanently delete a record by its ID.
     *
     * @param mixed $modelId
     * @return mixed
     */
    public function forceDelete($modelId)
    {
        $delete = $this->findById($modelId);

        return $delete->forceDelete();
    }

    /**
     * Permanently delete records based on specified conditions.
     *
     * @param array $conditions
     * @return mixed
     */
    public function forceDeleteByWhere(array $conditions)
    {
        $query = $this->model->newQuery();

        return $query->customWhere($conditions)->forceDelete();
    }

    /**
     * Permanently delete records where the specified field is in a given array of values.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @return mixed
     */
    public function forceDeleteByWhereIn(string $whereInField = '', array $whereIn = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->forceDelete();
    }

    /**
     * Restore records where the specified field is in a given array of values.
     *
     * @param string $whereInField
     * @param array $whereIn
     * @return mixed
     */
    public function restoreByWhereIn(string $whereInField = '', array $whereIn = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->restore();
    }
}
