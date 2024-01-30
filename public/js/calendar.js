//▼追加:モーダル機能
$(function () {
  // 編集ボタン(class="js-modal-open")が押されたら発火
  $('.btn-danger').on('click', function () {
    // モーダルの中身(class="js-modal")の表示
    $('.js-modal').fadeIn();
    // 押されたボタンから予約日を取得し変数へ格納
    var reserve_date = $(this).attr('value01');
    // 押されたボタンからリモ(1～3部)を取得し変数へ格納
    var part = $(this).attr('part');

    var id_date = $(this).attr('value02');

    // 取得した予約日をモーダルの中身へ渡す
    $('.modal_reserve_date').text(reserve_date);
    // 取得した投稿のをモーダルの中身へ渡す
    $('.modal_part').text(part);
    $('.modal_id_date').val(id_date);
    return false;
  });

  // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
  $('.js-reserve-close').on('click', function () {
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });
});
