<?php

use App\Models\Orderer;
use App\Models\Project;
use App\Models\Employee;

use Carbon\Carbon;

/**
* エラークラス
*/
function errClass($key)
{
    if (session()->has('errors')) {
        $errors = session('errors');

        if ($errors->has($key)) {
            return ' is-invalid';
        }
    }
}

/**
* エラーメッセージ（すべて）
*/
function errors()
{
    if (session()->has('errors')) {
        $errors = session('errors');
        echo '<div class="alert alert-danger">';
        echo '<ul>';
        foreach (array_unique($errors->all()) as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}

/**
* massageを表示
*/
function flashMessage()
{
    $msg = session('flash_message');
    echo PHP_EOL;
    if ($msg) {
        echo PHP_EOL;
        echo '<div class="alert alert-success alert-dismissible alert-header">' . PHP_EOL;
        if (empty(session('lock'))) {
            echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . PHP_EOL;
        } else {
            session()->forget('lock');
        }
        echo '<h4><i class="icon fa fa-check"></i>' . $msg . '</h4>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        session()->forget('flash_message');
    }
}

/**
* bladeのソート拡張
*/
function costom_sorting($sort)
{
    $sort_obj = '';
    if ($sort == "asc") {
        $sort_obj = '<i class="fas fa-sort-amount-down-alt"></i>';
    } else if ($sort == "desc") {
        $sort_obj = '<i class="fas fa-sort-amount-down"></i>';
    } else {
        $sort_obj = '<i class="fas fa-sort"></i>';
    }

    return $sort_obj;
}

/**
 * テーブルのヘッド部分を作成する
 * $param= [{ソート名} => ['name' => {表示名}, 'class' => {追加クラス(任意), 'not_sort' => {true(非ソート化)(任意)}})]]
 */
function setTableHeader($search, $param) {
    $class = '';
    $table_header = '';
    // ソートされている場合
    if (isset($search['sort_column']) && isset($search['sort_order'])) {
        foreach ($param as $key => $value) {
            $class = isset($value['class']) ? $value['class'] : '';
            if (isset($value['not_sort'])) {
                $table_header = $table_header . '<th class="' . $class .'">' . $value['name'] . '</th>';
            } elseif ($search['sort_column'] == $key) {
                $table_header = $table_header . '<th style="cursor : pointer;" class="sort submit_button ' . $class .'" data-action="search" data-column="' . $key . '">' . $value['name'] . costom_sorting($search['sort_order']) . '</th>';
            } else {
                $table_header = $table_header . '<th style="cursor : pointer;" class="sort submit_button ' . $class .'" data-action="search" data-column="' . $key . '">' . $value['name'] . costom_sorting('none') . '</th>';
            }
        }
        $table_header = $table_header . '<input type="hidden" id="sort_column" name="sort_column" value="' . $search['sort_column'] .'">';
        $table_header = $table_header . '<input type="hidden" id="sort_order" name="sort_order" value="' . $search['sort_order'] .'">';
    } else {
        foreach ($param as $key => $value) {
            $class = isset($value['class']) ? $value['class'] : '';
            if (isset($value['not_sort'])) {
                $table_header = $table_header . '<th class="' . $class .'">' . $value['name'] . '</th>';
            } else {
                $table_header = $table_header . '<th style="cursor : pointer;" class="sort submit_button ' . $class .'" data-action="search" data-column="' . $key . '">' . $value['name'] . costom_sorting('none') . '</th>';
            }
        }
    }

    return $table_header;
}

/**
 * 発注元のselectボックス取得
 */
function ordererSelect($name, $param, $attr = []) {
    $lists = Orderer::orderBy('sort', 'asc')->get();

    $list = ['' => '']+Arr::pluck($lists, 'name', 'id');

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select($name, $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * 案件のselectボックス取得
 */
function projectSelect($name, $param, $attr = []) {
    $lists = Project::orderBy('sort', 'asc')->get();

    $list = ['' => '']+Arr::pluck($lists, 'name', 'id');

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select($name, $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * 社員のselectボックス取得
 */
function employeeSelect($name, $param, $attr = []) {
    $lists = Employee::orderBy('sort', 'asc')->get();

    $list = ['' => '']+Arr::pluck($lists, 'name', 'id');

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select($name, $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
* 一覧表示がない場合の表示を出し分ける
*/
function listEmptyDisplay($param, $colspan)
{
    echo '<tr>' . PHP_EOL;
    echo "<td colspan='$colspan'>" . PHP_EOL;
    if(isset($param['search']) && array_filter($param['search'])) {
        echo '該当する検索結果が見つかりません。<br>条件を変えて、検索を行ってください。' . PHP_EOL;
    } else {
        echo '登録がまだありません。' . PHP_EOL;
    }
    echo '</td>' . PHP_EOL;
    echo '</tr>' . PHP_EOL;
}

/**
* 検索条件が全て空か又は検索結果が0件かのチェックを行う
*/
function createAlertMessageWhenAllDelete($lists, $param)
{
    $message = '';
    $search = $param['search'] ?? [];

    if (collect($search)->filter(fn($s) => isset($s))->count() === 0) {
        $message = '1つ以上検索条件を設定・変更してください';
    } else if ($lists->count() === 0) {
        $message = '検索結果が0件です';
    }
    return $message;
}

function getUnixTimeMillSecond()
{
    //microtimeを.で分割
    $arrTime = explode('.',microtime(true));
    //日時＋ミリ秒
    return date('YmdHis', $arrTime[0]) .$arrTime[1];
}

// 以下ヘルパークラス--------------------

/**
 * ソートテーブルのヘルパークラス
 * 
 * Viewから直接インスタンス化されることを期待しているのでhelperに直接記載してます
 * インスタンス経由でフィールドの値が上書きされることは想定してないので、
 * public経由でアクセスできるsetter的なメソッドは用意してません
 */
class SortTableHelper
{
    /**
     * 検索条件の連想配列
     */
    private $search_params;

    /**
     * テーブルのヘッダーに設定する連想配列
     */
    private $table_header;

    public function __construct(array $search_params, array $table_header)
    {
        $this->search_params = $search_params;
        $this->table_header = $table_header;
    }

    /**
     * フィールドに設定されたテーブルヘッダーの連想配列のキー数をカウントして返却
     * 
     * 検索結果が0件の時にcolspan = テーブルのヘッダー数にするために利用
     */
    public function colspanCount()
    {
        return count(array_keys($this->table_header));
    }
    
    /**
     * Viewからインスタンス経由で呼ばれるwrapperメソッド
     */
    public function showTableHeader()
    {
        return setTableHeader($this->search_params, $this->table_header);
    }

    /**
     * Viewからインスタンス経由で呼ばれるwrapperメソッド
     */
    public function showEmptyList()
    {
        return listEmptyDisplay($this->search_params, $this->colspanCount());
    }
}
