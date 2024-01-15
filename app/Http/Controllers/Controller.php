<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * セッション処理(セッションにController名を付け、keyが重複しないようにする)
     */
    public function customSession($key, $value = null)
    {
        $key = 'Controller.' . $this->getControllerName() . '.' . $key;

        if (is_null($value)) {
            // $value引数がnullの場合取得
            return Session::get($key, array());
        } elseif (empty($value)) {
            // $value引数が空の場合セッション削除
            Session::forget($key);
        } else {
            // $value引数が入っている場合セッション保存
            Session::put($key, $value);
        }
    }

    /**
    * コントローラー名取得
    *
    */
    function getControllerName()
    {
        $action = Route::currentRouteAction();
        $controller = class_basename($action);
        list($controller, $action) = explode('@', $controller);
        return $controller;
    }
}
