<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\AddProjectRequest;
use App\Http\Requests\Project\DeleteProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;

class ProjectController extends Controller
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
            return redirect()->route('project.list',$param);
        }

        $search = $param['search'] ?? [];
        $order['sort_column'] = $param['sort_column'] ?? '';
        $order['sort_order'] = $param['sort_order'] ?? '';


        $lists = Project::getList()->search($search)->order($order)->paginate(Config::get('const.PAGINATE_PAGES'));

        return view('project.list', compact('lists', 'param'));
    }

    /**
     * 登録画面を表示する
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * 登録をする
     */
    public function store(AddProjectRequest $request)
    {
        $params = $request->all();
        $id = (new Project)->setInsert($params);

        \Session::flash('flash_message', config('const.MESSAGES.CREATED'));
        return redirect()->route('project.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 編集画面を表示する
     *
     * @param  Request  $request
     * @param  Project  $Project
     * @return Application|Factory|View
     */
    public function edit(Request $request, Project $project)
    {
        return view('project.edit', compact('project'));
    }

    /**
     * 更新する
     *
     * @param  UpdateProjectRequest  $request
     * @param  Project  $Project
     * @return Application|Factory|View
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        // 入力した値を取得
        $params = $request->all();

        // 更新処理
        (new Project)->setUpdate($id, $params);

        \Session::flash('flash_message', config('const.MESSAGES.UPDATED'));
        return redirect()->route('project.list', ['reload' => config('const.RELOAD_ON')]);
    }

    /**
     * 削除する
     *
     * @param  DeleteProjectRequest  $request
     * @return RedirectResponse
     */
    public function delete(DeleteProjectRequest $request, $id)
    {
        // 削除処理
        (new Project)->setDestroy($id);
        \Session::flash('flash_message', config('const.MESSAGES.DELETED'));
        return redirect()->route('project.list', ['reload' => config('const.RELOAD_ON')]);
    }
}
