<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
