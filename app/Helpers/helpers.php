<?php

use App\Models\User;
use App\Models\Tag;
use App\Models\Customer;
use App\Models\UserAuthorityGroup;
use App\Models\Prefecture;

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
 * ユーザー権限グループのselectボックス取得
 */
function authorityGroupsSelect($name, $param, $attr = []) {
    $lists = UserAuthorityGroup::get();

    $list = ['' => '選択してください']+Arr::pluck($lists, 'label', 'id');

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select($name, $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * ユーザー氏名のselectボックス取得
 */
function userFullNameSelect($name, $param, $attr = []) {
    $lists = User::get();

    $list = ['' => '選択してください']+Arr::pluck($lists, 'full_name', 'full_name');

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select($name, $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * タグ名のselectボックス取得
 */
function tagNameSelect($name, $param, $attr = []) {
    $lists = Tag::get();

    $list = ['' => '選択してください']+Arr::pluck($lists, 'name', 'name');

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select($name, $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * 検索用のselectボックス取得
 */
function selectForList($name, $lists, $param, $attr = []) {
    $list = ['' => '選択してください']+Arr::pluck($lists, $name, $name);

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select("search[$name]", $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * 検索用のselectボックス取得
 */
function selectForCustomerList($name, $param, $attr = []) {
    if ($param) {
        $list = Customer::select($name)->whereNotNull($name)->where($name, '<>', '')->where($name, $param)->distinct()->pluck($name, $name)->toArray();
    } else {
        $list = [];
    }

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select("search[$name]", $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * 検索用のmultipleselectボックス取得(nameに「_in」と「[]」を自動的に付与する)
 */
function multipleSelectForList($name, $lists, $param, $attr = []) {
    $list = Arr::pluck($lists, $name, $name);

    $form = "<select name='search[{$name}_in][]'";
    
    if (isset($attr['class'])) {
        $class = $attr['class'];
        $form .= " class='$class'";
    }

    $form .= ">" . PHP_EOL;

    foreach ($list as $key => $data) {
        $form .= "<option value='$key'>$data</option>" . PHP_EOL;
    }

    $form .= "</select>";

    return $form;
}

/**
 * 検索用のmultipleselectボックス取得(nameに「_in」と「[]」を自動的に付与する)
 */
function multipleSelectForCustomerList($name, $param, $attr = []) {
    if ($param) {
        $list = Customer::select($name)->whereNotNull($name)->where($name, '<>', '')->whereIn($name, $param)->distinct()->pluck($name, $name)->toArray();
    } else {
        $list = [];
    }

    $form = "<select name='search[{$name}_in][]'";
    
    if (isset($attr['class'])) {
        $class = $attr['class'];
        $form .= " class='$class'";
    }

    $form .= ">" . PHP_EOL;

    foreach ($list as $key => $data) {
        $form .= "<option value='$key'>$data</option>" . PHP_EOL;
    }

    $form .= "</select>";

    return $form;
}

/**
 * 都道府県のselectボックス取得
 */
function prefectureSelect($name, $param, $attr = []) {
    $lists = Prefecture::get();

    $list = ['' => '']+Arr::pluck($lists, 'name', 'id');

    // オプションを指定する場合はこちらに配列で渡す
    $optionAttributes = [];

    $form = Form::select($name, $list, $param, $attr, $optionAttributes);
    return $form;
}

/**
 * 都道府県のマルチ検索用selectボックス取得
 */
function prefectureSelectForList($name, $param, $attr = []) {
    $lists = Prefecture::get();

    $list = Arr::pluck($lists, 'name', 'id');

    $form = "<select name='$name'";
    
    if (isset($attr['class'])) {
        $class = $attr['class'];
        $form .= " class='$class'";
    }

    $form .= ">" . PHP_EOL;

    foreach ($list as $key => $data) {
        $form .= "<option value='$key'>$data</option>" . PHP_EOL;
    }

    $form .= "</select>";

    return $form;
}

/**
 * 顧客ページのタグ名のselectボックス取得
 */
function customertagNameSelect($name, $param, $attr = []) {
    $lists = Tag::get();

    $list = Arr::pluck($lists, 'name', 'name');

    $form = "<select name='$name'";
    
    if (isset($attr['class'])) {
        $class = $attr['class'];
        $form .= " class='$class'";
    }

    $form .= ">" . PHP_EOL;

    // formファサードだとoldが出来ない為、作っていく
    if (is_array($param)) {
        foreach ($param as $tag) {
            $form .= "<option value='$tag'>$tag</option>" . PHP_EOL;
        }
        foreach ($list as $data) {
            if (!in_array($data, $param)) {
                $form .= "<option value='$data'>$data</option>" . PHP_EOL;
            }
        }
    } else {
        foreach ($list as $data) {
            $form .= "<option value='$data'>$data</option>" . PHP_EOL;
        }
    }

    $form .= "</select>";

    return $form;
}

/**
 * 顧客一覧のタグのマルチ検索用selectボックス取得
 */
function custmerTagSelect($name, $param, $attr = []) {
    $lists = Tag::get();

    $list = Arr::pluck($lists, 'name', 'id');

    $form = "<select name='$name'";
    
    if (isset($attr['class'])) {
        $class = $attr['class'];
        $form .= " class='$class'";
    }

    $form .= ">" . PHP_EOL;

    foreach ($list as $key => $data) {
        $form .= "<option value='$key'>$data</option>" . PHP_EOL;
    }

    $form .= "</select>";

    return $form;
}

/**
* 登録更新情報を表示する
*/
function updateInformations($data)
{
    // 更新者がユーザー
    if($data->updater_type == config('const.CREATOR_TYPE.USER') && !empty($data->updated_by)) {
        $updater = User::find($data->updated_by);
        echo '最終更新者:[ユーザー]' . $updater->full_name . '(' . $data->updated_at . ')<br>' . PHP_EOL;
    // 更新者がシステム
    } elseif ($data->updater_type == config('const.CREATOR_TYPE.SYSTEM')) {
        echo '最終更新者:[システム](' . $data->updated_at . ')<br>' . PHP_EOL;
    }
    // 登録者がユーザー
    if($data->creator_type == config('const.CREATOR_TYPE.USER') && !empty($data->created_by)) {
        $creater = User::find($data->created_by);
        echo '登録者:[ユーザー]' . $creater->full_name . '(' . $data->created_at . ')<br>' . PHP_EOL;
    // 登録者が代理店
    } elseif ($data->creator_type == config('const.CREATOR_TYPE.SYSTEM')) {
        echo '登録者:[システム](' . $data->created_at . ')<br>' . PHP_EOL;
    }
}

/**
* 登録情報を表示する
*/
function createByName($data)
{
    // 更新者がユーザー
    if($data->creator_type == config('const.CREATOR_TYPE.USER') && !empty($data->created_by)) {
        $creater = User::find($data->created_by);
        $creater_name = $creater->full_name;
    // 更新者がシステム
    } elseif ($data->creator_type == config('const.CREATOR_TYPE.SYSTEM')) {
        $creater_name = 'システム';
    }

    return $creater_name;
}

/**
* 更新情報を表示する
*/
function updateByName($data)
{
    // 更新者がユーザー
    if($data->updater_type == config('const.CREATOR_TYPE.USER') && !empty($data->updated_by)) {
        $updater = User::find($data->updated_by);
        $updater_name = $updater->full_name;
    // 更新者がシステム
    } elseif ($data->updater_type == config('const.CREATOR_TYPE.SYSTEM')) {
        $updater_name = 'システム';
    }

    return $updater_name;
}

/**
* 登録情報を表示する(Excel出力で使用する)
*/
function createByNameExcel($data)
{
    // 更新者がユーザー
    if($data->creator_type == config('const.CREATOR_TYPE.USER') && !empty($data->created_by)) {
        $creater_name = $data->createdData->full_name;
    // 更新者がシステム
    } elseif ($data->creator_type == config('const.CREATOR_TYPE.SYSTEM')) {
        $creater_name = 'システム';
    }

    return $creater_name;
}

/**
* 更新情報を表示する(Excel出力で使用する)
*/
function updateByNameExcel($data)
{
    // 更新者がユーザー
    if($data->updater_type == config('const.CREATOR_TYPE.USER') && !empty($data->updated_by)) {
        $updater_name = $data->updatedData->full_name;
    // 更新者がシステム
    } elseif ($data->updater_type == config('const.CREATOR_TYPE.SYSTEM')) {
        $updater_name = 'システム';
    }

    return $updater_name;
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

function customerType()
{
    return Customer::TYPE;
}

function customerTypeOfBusiness()
{
    return Customer::TYPE_OF_BUSINESS;
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
