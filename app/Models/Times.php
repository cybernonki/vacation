<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;

class Times extends Model
{
    use HasFactory;

    /** @var string テーブル名 */
    protected $table = 'times_times';

    // AutoIncrement無効
    public $incrementing = false;

    // タイムスタンプ設定無効
    public $timestamps = false;

    /** @var array 代入可能な属性 */
    protected $fillable = [
        'work_date',
        'work_time',
        'employee_id',
        'project_id',
    ];

    protected $casts = [
        'work_date' => 'date',
    ];

    public function Employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function Project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public static function getList()
    {
        return self::with(['Employee','Project']);
    }

    public function scopeSearch($query, $search) {
        foreach ($search as $key => $value) {
            // 配列か確認する
            if (!is_array($value) && !strlen($value)) {
                continue;
            }
            $scope = Str::studly($key);
            $query->$scope($value);
        }
        return $query;
    }

    public function scopeId($query, $value) {
        $query->where('times_times.id', $value);
    }

    public function scopeWorkDate($query, $value) {
        $query->where('times_times.work_date', $value);
    }

    public function scopeEmployeeId($query, $value) {
        $query->where('times_times.employee_id', $value);
    }

    public function scopeOrder($query, $order)
    {
        if (strlen($order['sort_column']) && strlen($order['sort_order'])) {
            $scope = 'Order' . Str::studly($order['sort_column']);
            $query->$scope($order['sort_order']);
        } else {
            $query->OrderWorkDate('desc');
            $query->OrderEmployeeId('asc');
            $query->OrderProjectId('asc');
        }
    }

    public function scopeOrderId($query, $value) {
        return $query->orderBy('id', $value);
    }

    public function scopeOrderEmployeeId($query, $value) {
        return $query->join('vacation_employee', 'vacation_employee.id', '=', 'times_times.employee_id')
                    ->orderBy('vacation_employee.sort', $value)
                    ->select('times_times.*');
    }

    public function scopeOrderProjectId($query, $value) {
        return $query->join('project_project', 'project_project.id', '=', 'times_times.project_id')
                    ->orderBy('project_project.sort', $value)
                    ->select('times_times.*');
    }

    public function scopeOrderWorkDate($query, $value) {
        return $query->orderBy('work_date', $value);
    }

    public function scopeOrderWorkTime($query, $value) {
        return $query->orderBy('work_time', $value);
    }

    // 登録
    public function setInsert($params)
    {
        DB::beginTransaction();
        try {

            $this->fill($params)->save();

            $id = DB::getPdo()->lastInsertId();

            DB::commit();

            return $id;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // 更新
    public function setUpdate($id, $params)
    {
        DB::beginTransaction();

        try {
            $model = $this->where('id', $id)->lockForUpdate()->first();

            if (empty($model)) {
                throw new \Exception(config('const.EXCEPTION_MESSAGES.NOT_FOUND'));
            } else {
                $model->fill($params)->save();
            }

            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    // 削除
    public function setDestroy($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->where('id', '=', $id)->lockForUpdate()->first();

            if (empty($model)) {
                throw new \Exception(config('const.EXCEPTION_MESSAGES.NOT_FOUND'));
            } else {
                $model->delete();
            }

            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
