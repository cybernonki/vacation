/**
 * テーブルヘッダ カラム押下時のソート処理
 *
 * @param {*} form 対象のフォーム(セレクタ)
 * @param {*} element 選択された要素
 * @param {*} data データ属性に設定しているキー名
 */
function listOrder(formSelector, element, data) {
  // 要素チェックと引数チェック
  if (!$(formSelector)[0] || !data || !$(element)[0]) {
    return false;
  }

  // submitするフォームを取得
  const form = $(formSelector);
  const column = $(element).data(data);

  const sortColumn = $("#sort_column")[0] ? $("#sort_column").val() : "";
  let sortOrder = $("#sort_order")[0] ? $("#sort_order").val() : "";

  if(sortColumn != column){
    sortOrder = 'asc';
  }else if(sortOrder == 'asc'){
    sortOrder = 'desc';
  }else if(sortOrder == 'desc'){
    sortOrder = 'asc';
  }else{
    sortOrder = 'asc';
  }

  // controllerにカラム名とソート順(asc, desc)を投げる
  $('<input>').attr({
    'type': 'hidden',
    'name': 'sort_column',
    'value': column
  }).appendTo(form);

  $('<input>').attr({
    'type': 'hidden',
    'name': 'sort_order',
    'value': sortOrder
  }).appendTo(form);

  // 検索する
  form.trigger('submit');
}

export {
  listOrder,
};
