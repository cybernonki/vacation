<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orderer\AddOrdererRequest;
use App\Http\Requests\Orderer\DeleteOrdererRequest;
use App\Http\Requests\Orderer\UpdateOrdererRequest;
use App\Models\Orderer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;

class OrdererController extends Controller
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
            return redirect()->route('orderer.list',$param);
        }

        $search = $param['search'] ?? [];
        $order['sort_column'] = $param['sort_column'] ?? '';
        $order['sort_order'] = $param['sort_order'] ?? '';


        $lists = Orderer::getList()->search($search)->order($order)->paginate(Config::get('const.PAGINATE_PAGES'));

        return view('orderer.list', compact('lists', 'param'));
    }

    /**
     * 登録画面を表示する
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('orderer.create');
    }

    /**
     * 登録をする
     */
    public function store(AddOrdererRequest $request)
    {
        $params = $request->all();
        $id = (new Orderer)->setInsert($params);

        \Session::flash('flash_message', config('const.MESSAGES.CREATED'));
        return redirect()->route('orderer.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 編集画面を表示する
     *
     * @param  Request  $request
     * @param  Orderer  $Orderer
     * @return Application|Factory|View
     */
    public function edit(Request $request, Orderer $orderer)
    {
        return view('orderer.edit', compact('orderer'));
    }

    /**
     * 更新する
     *
     * @param  UpdateOrdererRequest  $request
     * @param  Orderer  $Orderer
     * @return Application|Factory|View
     */
    public function update(UpdateOrdererRequest $request, $id)
    {
        // 入力した値を取得
        $params = $request->all();

        // 更新処理
        (new Orderer)->setUpdate($id, $params);

        \Session::flash('flash_message', config('const.MESSAGES.UPDATED'));
        return redirect()->route('orderer.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 削除する
     *
     * @param  DeleteOrdererRequest  $request
     * @return RedirectResponse
     */
    public function delete(DeleteOrdererRequest $request, $id)
    {
        // 削除処理
        (new Orderer)->setDestroy($id);
        \Session::flash('flash_message', config('const.MESSAGES.DELETED'));
        return redirect()->route('orderer.list', ['reload' => config('const.RELOAD_ON')]);
    }
}
