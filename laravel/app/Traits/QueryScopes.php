<?php

namespace App\Traits;

trait QueryScopes
{

    public function scopeSearch($query, $keyword, $fieldSearch = [], $whereHas = [])
    {
        if (!empty($keyword)) {

            if (!empty($fieldSearch)) {
                foreach ($fieldSearch as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $keyword . '%');
                }
            } else {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            }
        }

        if (!empty($whereHas)) {
            $field = $whereHas['field'];
            $query->orWhereHas($whereHas['relation'], function ($q) use ($field, $keyword) {
                $q->where($field, 'LIKE', '%' . $keyword . '%');
            });
        }


        return $query;
    }

    public function scopePublish($query, $publish)
    {
        if ((!empty($publish)) && $publish != '0') {
            $query->where('publish', $publish);
        }
        return $query;
    }

    public function scopeCustomWhere($query, $where = [])
    {
        // 'column' => ['<>', 100]
        if (!empty($where) && is_array($where)) {
            foreach ($where as $column => $value) {
                // dd($column, ...$value);
                $query->where($column, ...$value);
            }
        }
        return $query;
    }

    public function scopeCustomWhereRaw($query, $whereRaw = [])

    {
        // $value[0] là câu truy vấn $value[1] là tham số truy vấn
        if (!empty($whereRaw) && is_array($whereRaw)) {
            foreach ($whereRaw as $key => $value) {
                $query->whereRaw($value[0], $value[1]);
            }
        }
        return $query;
    }

    public function scopeRelation($query, $relations = [])
    {
        // ['user_catalogue', '...']
        if (!empty($relations) && is_array($relations)) {
            foreach ($relations as $relation) {
                $query->with($relation);
            }
        }
        return $query;
    }

    public function scopeRelationCount($query, $relations = [])
    {
        // ['user_catalogue', '...']
        if (!empty($relations) && is_array($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
            }
        }
        return $query;
    }
    public function scopeCustomJoin($query, $join = [])
    {
        // 'table_name_1' => ['constraint1', 'constraint2'],
        if (!empty($join) && is_array($join)) {
            foreach ($join as $table => $constraints) {
                $query->join($table, ...$constraints);
            }
        }
        return $query;
    }

    public function scopeCustomGroupBy($query, $groupBy = [])
    {
        // 'column1' or
        // ['column1', 'column2']
        if (!empty($groupBy)) {
            if (is_array($groupBy)) {
                foreach ($groupBy as $group) {
                    $query->groupBy($group);
                }
            } else {
                $query->groupBy($groupBy);
            }
        }

        return $query;
    }

    public function scopeCustomOrderBy($query, $orderBy = [])
    {

        // OrderBy
        // [
        //  'name' => 'ASC',
        //  'created_at' => 'DESC'
        // ]
        if (!empty($orderBy) && is_array($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy('id', 'DESC');
        }

        return $query;
    }

    public function scopeFilterDropdown($query, $condition = [])
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $column => $value) {
                if ($value != '') {
                    $query->where($column, $value);
                }
            }
        }
        return $query;
    }

    public function scopeCreatedAt($query, $condition = '')
    {
        if (!empty($condition) && $condition != '') {
            $date = explode(' - ', $condition);
            $startAt = convertDateTime($date[0], 'Y-m-d H:i:s');
            $endAt = convertDateTime($date[1], 'Y-m-d H:i:s');
            $query->whereBetween('created_at', [$startAt, $endAt]);
        }
        return $query;
    }
}
