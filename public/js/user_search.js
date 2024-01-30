$(function () {
  $('.search_conditions').click(function () {
    $(this).toggleClass('active');
    $('.search_conditions_inner').slideToggle();
  });

  $('.search_conditions').click(function () {
    $('.subject_inner').slideToggle();
  });
});

$(function () {
  $('.subject_edit_btn').click(function () {
    $(this).toggleClass('active');
    $('.subject_inner').slideToggle();
  });

  $('.subject_edit_btn').click(function () {
    $('.search_conditions_inner').slideToggle();
  });
});

// $('.subject_edit_btn').on('click', function () {
//   $(this).toggleClass('active');
//   $('.subject_inner').fadeIn();
//   return false;
// });
// $('.subject_edit_btn').on('click', function () {
//   $('.subject_edit_btn').fadeOut();
//   return false;
// });
