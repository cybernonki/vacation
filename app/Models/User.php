<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use DB;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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
        $query->where('user.id', $value);
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
}
