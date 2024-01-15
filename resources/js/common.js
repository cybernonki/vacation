import {
  listOrder,
} from "./modules/utilization";

$(function() {
  // テーブルヘッダーのカラムでソート処理
  $('.submit_button').on('click', function(){
    listOrder("#search_form", this, 'column');
  });

  /* =======================
    削除確認処理
  ======================= */
  $('.delete_confirm').on('click', function() {
      if (!confirm(confirm_message)) {
          return false;
      }
  });

  /* =======================
    数値の3桁区切りカンマ
  ======================= */
  $('.comma').each(function(){
    var num   = $(this).text();
    var comma = String(num).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $(this).text(comma);
  });
})

// 2重送信防止処理
$("form").submit(function() {
    // 2重送信防止クラスのチェック
    if ($(this).hasClass("submitted")) {
        return false;
    }

    // 2重送信防止クラス
    $(this).addClass("submitted");
});
