<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;

class UserController extends Controller
{
    /**
     * 一覧画面を表示する
     *
     * @return Application|Factory|View
     */
    public function list(Request $request, int $reload=0)
    {

        $param = $request->all();
        // リロード処理追加
        if ($reload == 0) {
            // 検索条件をセッションに保存
            $this->customSession('param', $param);
        } else {
            // 検索条件をセッションから復元
            $param = $this->customSession('param');
            // フラッシュメッセージが出なくなるため対応
            $msg = session('flash_message');
            if ($msg) \Session::flash('flash_message', $msg);
            // 復元したリクエストを付けてリダイレクト
            return redirect()->route('employee.list',$param);
        }

        $search = $param['search'] ?? [];
        $order['sort_column'] = $param['sort_column'] ?? '';
        $order['sort_order'] = $param['sort_order'] ?? '';


        $lists = Employee::getList()->search($search)->order($order)->paginate(Config::get('const.PAGINATE_PAGES'));

        return view('employee.list', compact('lists', 'param'));
    }

    /**
     * 削除する
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        // 削除処理
        (new Employee)->setDestroy($id);
        \Session::flash('flash_message', config('const.MESSAGES.DELETED'));
        return redirect()->route('employee.list', ['reload' => config('const.RELOAD_ON')]);
    }
}
