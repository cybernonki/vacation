<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /** @var string テーブル名 */
    protected $table = 'vacation_employee';

    // AutoIncrement無効
    public $incrementing = false;

    // タイムスタンプ設定無効
    public $timestamps = false;

    /** @var array 代入可能な属性 */
    protected $fillable = [
        'name',
        'usecount',
        'memo',
        'sort',
    ];

    public static function getList()
    {
        return self::with([]);
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
        $query->where('vacation_employee.id', $value);
    }

    public function scopeOrder($query, $order)
    {
        if (strlen($order['sort_column']) && strlen($order['sort_order'])) {
            $scope = 'Order' . Str::studly($order['sort_column']);
            $query->$scope($order['sort_order']);
        } else {
            $query->OrderId('asc');
        }
    }

    public function scopeOrderId($query, $value) {
        return $query->orderBy('id', $value);
    }
}
