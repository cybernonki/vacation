<?php

namespace App\Http\Controllers;

use App\Models\Times;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use Carbon\Carbon;

class DaysController extends Controller
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
            return redirect()->route('days.list',$param);
        }

        $search = $param['search'] ?? ['work_date' => Carbon::now()->format('Y/m/d')];
        $param['search'] = $param['search'] ?? ['work_date' => Carbon::now()->format('Y/m/d')];
        $order['sort_column'] = $param['sort_column'] ?? '';
        $order['sort_order'] = $param['sort_order'] ?? '';


        $lists = Times::getList()->selectRaw('employee_id, work_date, SUM(work_time) AS total_work_time')->groupBy('employee_id', 'work_date')->search($search)->paginate(Config::get('const.PAGINATE_PAGES'));

        return view('days.list', compact('lists', 'param'));
    }

    /**
     * 明細画面を表示する
     *
     * @return Application|Factory|View
     */
    public function detail(Request $request, $employee_id, $date)
    {

        $search = ['work_date' => $date, 'employee_id' => $employee_id];

        $lists = Times::getList()->search($search)->paginate(Config::get('const.PAGINATE_PAGES'));

        $param = [
            'employee_id' => $employee_id,
            'date' => $date,
        ];

        return view('days.detail', compact('lists', 'param'));
    }
}
