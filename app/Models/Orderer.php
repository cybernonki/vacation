<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderer extends Model
{
    use HasFactory;

    /** @var string テーブル名 */
    protected $table = 'orderer_orderer';

    // AutoIncrement無効
    public $incrementing = false;

    // タイムスタンプ設定無効
    public $timestamps = false;

    /** @var array 代入可能な属性 */
    protected $fillable = [
        'name',
        'sort',
    ];
}