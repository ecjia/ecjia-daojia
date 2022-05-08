<?php


namespace Ecjia\Component\Repository\Traits;


trait RepositoryFindWhereTrait
{

    /**
     * @param array $where
     * @param string[] $columns
     * @param int $page
     * @param int $perPage
     * @param callable|null $callback
     * @return \Illuminate\Support\Collection
     */
    public function findWhereLimit(array $where, $columns = ['*'], $page = 1, $perPage = 15, callable $callback = null)
    {
        $this->newQuery();

        $this->query->select($columns);

        if (is_callable($callback)) {
            $callback($this->query);
        }

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->query->where($field, $condition, $val);
            } else {
                $this->query->where($field, '=', $value);
            }
        }

        if ($page && $perPage) {
            $this->query->forPage($page, $perPage);
        }

        return $this->query->get();
    }

    /**
     * @param array $where
     * @param string[] $columns
     * @param callable|null $callback
     * @return \Illuminate\Support\Collection
     */
    public function findWhereCount(array $where, $columns = ['*'], callable $callback = null)
    {
        $this->newQuery();

        if (is_callable($callback)) {
            $callback($this->query);
        }

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->query->where($field, $condition, $val);
            } else {
                $this->query->where($field, '=', $value);
            }
        }

        return $this->query->count($columns);
    }

}