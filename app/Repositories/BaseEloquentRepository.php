<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;

/**
 * Class BaseEloquentRepository
 * @package App\Repositories\ContractsRepository
 */
abstract class BaseEloquentRepository implements RepositoryInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @return mixed
     */
    abstract public function model();

    /**
     * BaseEloquentRepository constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
        $this->boot();
    }

    /**
     *
     */
    public function boot()
    {
    }

    /**
     * @return Model|mixed
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     *
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = array('*'))
    {
        if ($this->model instanceof Builder) {
            $results = $this->model->orderBy('created_at', 'ASC')->get($columns);
        } else {
            $results = $this->model->orderBy('created_at', 'DESC')->get($columns);
        }

        $this->resetModel();

        return $results;
    }

    /**
     * @para null $where
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function whereLimit(array $where, $orderField, $orderType, $limit = null, $columns = array('*'))
    {
        $limit = is_null($limit) ? 10 : $limit;
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
        $results = $this->model->orderBy($orderField, $orderType)
            ->limit($limit)
            ->get( $columns);

        $this->resetModel();
        return $results;
    }

    /**
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginate($limit = null, $columns = array('*'))
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 20) : $limit;
        $results = $this->model->paginate($limit, $columns);
        $this->resetModel();

        return $results;
    }

    /**
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginateOrderBy($limit = null, $columns = array('*'))
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 20) : $limit;
        $results = $this->model->orderBy('created_at', 'DESC')->paginate($limit, $columns);
        $this->resetModel();

        return $results;
    }

    /**
     * @param array $where
     * @param null $current_page
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginateWhereLikeOrderBy(array $where, array $whereLike, $order_by = 'updated_at', $order = 'DESC', $current_page = null, $limit = null, $columns = array('*'))
    {

        $i = 0;
        $limit = is_null($limit) ? config('repository.pagination.limit', 10) : $limit;
        $current_page = is_null($current_page) ? config('repository.pagination.limit', 1) : $current_page;

        if (!empty($whereLike)) {
            $this->model = $this->model->where(function ($q) use ($whereLike, $i) {
                foreach ($whereLike as $fd => $val) {
                    if($i == 0){
                        $q->where($fd, 'LIKE', "%$val%");
                    }else{
                        $q->orWhere($fd, 'LIKE', "%$val%");
                    }
                    $i ++;
                }
            });
        }

        if (!empty($where)){
            $this->applyConditions($where);
        }
        $results = $this->model->orderBy($order_by, $order)->paginate($limit, $columns, 'page', $current_page);
        $this->resetModel();
        return $results;
    }

    public function findWhereLikeOrderBy(array $where, array $whereLike, $order_by = 'updated_at', $order = 'DESC', $columns = array('*'))
    {
        $i = 0;
        if (!empty($whereLike)) {
            $this->model = $this->model->where(function ($q) use ($whereLike, $i) {
                foreach ($whereLike as $fd => $val) {
                    if($i == 0){
                        $q->where($fd, 'LIKE', "%$val%");
                    }else{
                        $q->orWhere($fd, 'LIKE', "%$val%");
                    }
                    $i ++;
                }
            });
        }

        if (!empty($where)){
            $this->applyConditions($where);
        }
        $results = $this->model->orderBy($order_by, $order)->get($columns);
        $this->resetModel();
        return $results;
    }
    /**
     * @param array $where
     * @param null $current_page
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginateWhere(array $where, $current_page = null, $limit = null, $columns = array('*'))
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 10) : $limit;
        $current_page = is_null($current_page) ? config('repository.pagination.limit', 1) : $current_page;

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
        $results = $this->model->orderBy('updated_at', 'DESC')->paginate($limit, $columns, 'page', $current_page);

        $this->resetModel();

        return $results;
    }

    public function paginateWhereOrderBy(array $where, $order_by = 'updated_at', $order = 'DESC', $current_page = null, $limit = null, $columns = array('*'))
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 10) : $limit;
        $current_page = is_null($current_page) ? config('repository.pagination.limit', 1) : $current_page;

        $this->applyConditions($where);

        $results = $this->model->orderBy($order_by, $order)->paginate($limit, $columns, 'page', $current_page);

        $this->resetModel();

        return $results;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findById($id, $columns = array('*'))
    {
        $results = $this->model->where('id', '=', $id)->first($columns);
        $this->resetModel();

        return $results;
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, $columns = array('*'))
    {
        $results = $this->model->where($field, '=', $value)->first($columns);
        $this->resetModel();

        return $results;
    }

    /**
     * Find a resource by an array of attributes
     * @param  array  $attributes
     * @return object
     */
    public function findByAttributes(array $attributes, $columns = array('*'))
    {
        $this->applyConditions($attributes);
        $result = $this->model->first($columns);
        $this->resetModel();
        return $result;
    }

    /**
     * @param array $attributes
     * @param null $orderBy
     * @param string $sortOrder
     * @param array $relations
     * @return mixed
     * @throws \Exception
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc', $relations = [], $columns = array('*'))
    {
        $this->applyConditions($attributes);
        if (!empty($orderBy)) {
            $this->orderBy($orderBy, $sortOrder);
        }
        if (!empty($relations)) {
            $this->with($relations);
        }
        $result = $this->model->get($columns);
        $this->resetModel();
        return $result;
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = array('*'))
    {
        $this->applyConditions($where);

        $results = $this->model->orderBy('id', 'DESC')->get($columns);
        $this->resetModel();

        return $results;
    }

    public function findWhereOrderBy(array $where, $columns = array('*'), $orderWhere, $orderBy)
    {
        $this->applyConditions($where);

        $results = $this->model->orderBy($orderWhere, $orderBy)->get($columns);
        $this->resetModel();

        return $results;
    }

    public function findWhereOrderByLimit(array $where, $columns = array('*'), $orderWhere, $orderBy, $limit)
    {
        $this->applyConditions($where);

        $results = $this->model->orderBy($orderWhere, $orderBy)->limit($limit)->get($columns);
        $this->resetModel();

        return $results;
    }

    /**
     * @param array $where
     * @param array $columns
     * @param $limit
     * @return mixed
     */
    public function findWhereLimit(array $where, $limit = null, $columns = array('*'))
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }

        $results = $this->model->inRandomOrder()->limit($limit)->get($columns);
        $this->resetModel();

        return $results;
    }

    public function findWhereFirst(array $where, $columns = array('*'))
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }

        $results = $this->model->orderBy('updated_at', 'DESC')->first($columns);
        $this->resetModel();

        return $results;
    }

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = array('*'))
    {
        $results = $this->model->whereIn($field, $values)->orderBy('created_at', 'DESC')->get($columns);
        $this->resetModel();

        return $results;
    }

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = array('*'))
    {
        $results = $this->model->whereNotIn($field, $values)->get($columns);
        $this->resetModel();

        return $results;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance($attributes);
        $model->save();
        return $model;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        $this->resetModel();
        return $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->model->find($id);
        $originalModel = clone $model;

        $this->resetModel();
        $deleted = $model->delete();
        return $deleted;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteData($id)
    {
        $model = $this->model->find($id);
        $deleted = $model->delete();
        $this->resetModel();
        return $deleted;
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param $field
     * @param  $condition
     * @param  $val
     * @param array $columns
     * @return mixed
     */

    public function joinFindId($field, $condition, $val, $tablejoin, $fieldjoin, $columns = array('*'))
    {
        $tableName = $this->model->getTable();
        $select = ["$tableName.*"];
        for($i = 0; $i < count($columns); $i ++){
            $itemPush = 'b.'.$columns[$i] . ' as ' . strtoupper($columns[$i]);
            array_push($select, $itemPush);
        }
        $results = $this->model
            ->where("$tableName.".$field, $condition, $val)
            ->leftjoin("$tablejoin as b", "b.id", '=', "$tableName.$fieldjoin")
            ->get($select);
        $this->resetModel();
        return $results;
    }

    public function joinOne( $fieldjoin, $tablejoin, $columns = array('*'), $columjoin = array('*'))
    {
        $tableName = $this->model->getTable();
        $select = [];
        for($i = 0; $i < count($columns); $i ++){
            $item = $tableName.'.'.$columns[$i] . ' as f_' . $columns[$i];
            array_push($select, $item);
        }

        for($j = 0; $j < count($columjoin); $j ++){
            $itemPush = 'b.'.$columjoin[$j] . ' as ' . strtoupper($columjoin[$j]);
            array_push($select, $itemPush);
        }

        $results = $this->model
            ->where("$tableName.deleted_at", '=', null)
            ->leftjoin("$tablejoin as b", "b.id", '=', "$tableName.$fieldjoin")
            ->orderBy("$tableName.created_at", 'DESC')
            ->get($select);
        $this->resetModel();
        return $results;
    }

    /**
     * @param $field
     * @param array $values
     * @param array $columns
     * @return mixed
     */
    public function countByField($field, $values, $columns = array('*'))
    {
        $results = $this->model->where($field, '=', $values)
            ->get($columns)->count();
        $this->resetModel();

        return $results;
    }

    public function countWhere(array $where, $columns = array('*'))
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }

        $results = $this->model->select($columns)->count();
        $this->resetModel();

        return $results;
    }

    public function countData($columns = array('*'))
    {
        $results = $this->model->get($columns)->count();
        $this->resetModel();

        return $results;
    }

    public function whereNotNull($field,$columns = array('*'))
    {
        $results = $this->model->whereNotNull($field)
            ->get($columns);
        $this->resetModel();
        return $results;
    }

    public function deleteWhere(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
        $results = $this->model->delete();
        $this->resetModel();
        return $results;
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     *
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                if (count($value) == 2) {
                    $condition = '=';
                    list($field, $val) = $value;
                } elseif (count($value) == 1) {
                    $field = $value[0];
                    $condition = null;
                    $val = null;
                } else {
                    list($field, $condition, $val) = $value;
                }
                //smooth input
                $condition = preg_replace('/\s\s+/', ' ', trim($condition));

                //split to get operator, syntax: "DATE >", "DATE =", "DAY <"
                $operator = explode(' ', $condition);
                if (count($operator) > 1) {
                    $condition = $operator[0];
                    $operator = $operator[1];
                } else $operator = null;
                switch (strtoupper($condition)) {
                    case 'IN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereIn($field, $val);
                        break;
                    case 'NOTIN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotIn($field, $val);
                        break;
                    case 'DATE':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDate($field, $operator, $val);
                        break;
                    case 'DAY':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDay($field, $operator, $val);
                        break;
                    case 'MONTH':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereMonth($field, $operator, $val);
                        break;
                    case 'YEAR':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereYear($field, $operator, $val);
                        break;
                    case 'EXISTS':
                        if (!($val instanceof \Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereExists($val);
                        break;
                    case 'HAS':
                        if (!($val instanceof \Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereHas($field, $val);
                        break;
                    case 'HASMORPH':
                        if (!($val instanceof \Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereHasMorph($field, $val);
                        break;
                    case 'DOESNTHAVE':
                        if (!($val instanceof \Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHave($field, $val);
                        break;
                    case 'DOESNTHAVEMORPH':
                        if (!($val instanceof \Closure)) throw new \Exception("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHaveMorph($field, $val);
                        break;
                    case 'BETWEEN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetween($field, $val);
                        break;
                    case 'BETWEENCOLUMNS':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetweenColumns($field, $val);
                        break;
                    case 'NOTBETWEEN':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetween($field, $val);
                        break;
                    case 'NOTBETWEENCOLUMNS':
                        if (!is_array($val)) throw new \Exception("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetweenColumns($field, $val);
                        break;
                    case 'RAW':
                        $this->model = $this->model->whereRaw($val);
                        break;
                    default:
                        if (empty($condition)) {
                            $this->model = $this->model->where($field);
                        } else {
                            $this->model = $this->model->where($field, $condition, $val);
                        }
                }
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

}
