<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;

class Project extends Model
{
    use HasFactory;

    /** @var string テーブル名 */
    protected $table = 'project_project';

    // AutoIncrement無効
    public $incrementing = false;

    // タイムスタンプ設定無効
    public $timestamps = false;

    /** @var array 代入可能な属性 */
    protected $fillable = [
        'orderer_id',
        'name',
        'sort',
    ];

    public function Orderer()
    {
        return $this->hasOne(Orderer::class, 'id', 'orderer_id');
    }

    public static function getList()
    {
        return self::with(['Orderer']);
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
        $query->where('project_project.id', $value);
    }

    public function scopeOrder($query, $order)
    {
        if (strlen($order['sort_column']) && strlen($order['sort_order'])) {
            $scope = 'Order' . Str::studly($order['sort_column']);
            $query->$scope($order['sort_order']);
        } else {
            $query->OrderSort('asc');
        }
    }

    public function scopeOrderId($query, $value) {
        return $query->orderBy('id', $value);
    }

    public function scopeOrderOrdererId($query, $value) {
        return $query->orderBy('orderer_id', $value);
    }

    public function scopeOrderName($query, $value) {
        return $query->orderBy('name', $value);
    }

    public function scopeOrderSort($query, $value) {
        return $query->orderBy('sort', $value);
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
