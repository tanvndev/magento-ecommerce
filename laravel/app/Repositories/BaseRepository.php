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

    public function all($column = ['*'], $relation = [], $orderBy = null)
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

    public function findById($modelId, $column = ['*'], $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

    public function findByWhere($conditions = [], $column = ['*'], $relation = [], $all = false, $orderBy = null, $whereInParams = [], $withCount = [])
    {
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

        return $all ? $query->get() : $query->first();
    }

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

    public function findByWhereHas($condition = [], $column = ['*'], $relation = [], $alias = '', $all = false)
    {

        $query = $this->model->select($column);
        $query->whereHas($relation, function ($query) use ($condition, $alias) {
            foreach ($condition as $key => $value) {
                $query->where($alias.'.'.$key, $value);
            }
        });

        return $all ? $query->get() : $query->first();
    }

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

        //Phương thức withQueryString() trong Laravel được sử dụng để giữ nguyên các tham số truy vấn
        return $query->paginate($perPage)->withQueryString();
    }

    public function create($payload = [])
    {
        $create = $this->model->create($payload);

        return $create->fresh();
    }

    public function firstOrCreate(array $condition, array $payload = [])
    {
        $create = $this->model->firstOrCreate($condition, $payload);

        return $create;
    }

    public function createBatch($payload = [])
    {
        return $this->model->insert($payload);
    }

    public function createPivot($model, $payload = [], $relation = '')
    {
        // attach($model->id, $payload) là phương thức được gọi để thêm một bản ghi mới vào bảng pivot.
        return $model->{$relation}()->attach($model->id, $payload);
    }

    public function update($modelId, $payload = [])
    {
        $model = $this->findById($modelId);

        return $model->update($payload);
    }

    public function save($modelId, $payload = [])
    {
        $model = $this->findById($modelId);
        $model->fill($payload);
        $model->save();

        return $model;
    }

    public function lockForUpdate(array $condition, array $payload)
    {
        return $this->model->newQuery()
            ->customWhere($condition)
            ->lockForUpdate()
            ->firstOrFail()
            ->fill($payload)
            ->save();
    }

    // Truyen vao ham updateByWhereIn (Field name, array field name, va mang data can update)
    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }

    public function updateByWhere($conditions = [], $payload = [])
    {
        $query = $this->model->newQuery();

        return $query->customWhere($conditions)->update($payload);
    }

    public function updateOrCreate($payload = [], $conditions = [])
    {
        $this->model->updateOrCreate($conditions, $payload);
    }

    public function delete($modelId)
    {
        return $this->model->where('id', $modelId)->delete();
    }

    public function deleteByWhere($conditions = [])
    {
        $query = $this->model->newQuery();

        return $query->customWhere($conditions)->delete();
    }

    public function deleteByWhereIn($whereInField = '', $whereIn = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->delete();
    }

    // Xoá cứng
    public function forceDelete($modelId)
    {
        $delete = $this->findById($modelId);

        return $delete->forceDelete();
    }

    public function forceDeleteByWhere($conditions)
    {
        $query = $this->model->newQuery();

        return $query->customWhere($conditions)->forceDelete();
    }
}
