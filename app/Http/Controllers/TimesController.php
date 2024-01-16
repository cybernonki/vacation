<?php

namespace App\Http\Controllers;

use App\Http\Requests\Times\AddTimesRequest;
use App\Http\Requests\Times\DeleteTimesRequest;
use App\Http\Requests\Times\UpdateTimesRequest;
use App\Models\Times;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;

class TimesController extends Controller
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
            return redirect()->route('times.list',$param);
        }

        $search = $param['search'] ?? [];
        $order['sort_column'] = $param['sort_column'] ?? '';
        $order['sort_order'] = $param['sort_order'] ?? '';


        $lists = Times::getList()->search($search)->order($order)->paginate(Config::get('const.PAGINATE_PAGES'));

        return view('times.list', compact('lists', 'param'));
    }

    /**
     * 登録画面を表示する
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('times.create');
    }

    /**
     * 登録をする
     */
    public function store(AddTimesRequest $request)
    {
        $params = $request->all();
        $id = (new Times)->setInsert($params);

        \Session::flash('flash_message', config('const.MESSAGES.CREATED'));
        return redirect()->route('times.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 編集画面を表示する
     *
     * @param  Request  $request
     * @param  Times  $Times
     * @return Application|Factory|View
     */
    public function edit(Request $request, Times $times)
    {
        return view('times.edit', compact('times'));
    }

    /**
     * 更新する
     *
     * @param  UpdateTimesRequest  $request
     * @param  Times  $Times
     * @return Application|Factory|View
     */
    public function update(UpdateTimesRequest $request, $id)
    {
        // 入力した値を取得
        $params = $request->all();

        // 更新処理
        (new Times)->setUpdate($id, $params);

        \Session::flash('flash_message', config('const.MESSAGES.UPDATED'));
        return redirect()->route('times.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 削除する
     *
     * @param  DeleteTimesRequest  $request
     * @return RedirectResponse
     */
    public function delete(DeleteTimesRequest $request, $id)
    {
        // 削除処理
        (new Times)->setDestroy($id);
        \Session::flash('flash_message', config('const.MESSAGES.DELETED'));
        return redirect()->route('times.list', ['reload' => config('const.RELOAD_ON')]);
    }
}
