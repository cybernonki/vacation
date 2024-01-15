<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\AddEmployeeRequest;
use App\Http\Requests\Employee\DeleteEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;

class EmployeeController extends Controller
{
    /**
     * 社員一覧画面を表示する
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
     * 新規顧客マスタ登録画面を表示する
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * 新規顧客マスタの登録をする
     */
    public function store(AddEmployeeRequest $request)
    {
        $params = $request->all();
        $id = (new Employee)->setInsert($params);

        \Session::flash('flash_message', config('const.MESSAGES.CREATED'));
        return redirect()->route('employee.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 顧客マスタ編集詳細画面を表示する
     *
     * @param  Request  $request
     * @param  Employee  $Employee
     * @return Application|Factory|View
     */
    public function edit(Request $request, Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    /**
     * 顧客マスタ情報を更新する
     *
     * @param  UpdateEmployeeRequest  $request
     * @param  Employee  $Employee
     * @return Application|Factory|View
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        // 入力した値を取得
        $params = $request->all();

        // 更新処理
        (new Employee)->setUpdate($id, $params);

        \Session::flash('flash_message', config('const.MESSAGES.UPDATED'));
        return redirect()->route('employee.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 顧客マスタ情報を削除する
     *
     * @param  DeleteEmployeeRequest  $request
     * @return RedirectResponse
     */
    public function delete(DeleteEmployeeRequest $request, $id)
    {
        // 削除処理
        (new Employee)->setDestroy($id);
        \Session::flash('flash_message', config('const.MESSAGES.DELETED'));
        return redirect()->route('employee.list', ['reload' => config('const.RELOAD_ON')]);
    }
}
