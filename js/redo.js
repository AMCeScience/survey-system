$(function() {
  $('.btn-redo').on('click', function(e) {
    e.preventDefault();

    $('div.alert-warning').remove();

    var dropdown_el = $('select');

    var software_id = $(dropdown_el).val();

    if (software_id * 1 === 0) {
      $('.main-container').prepend('<div class="alert alert-warning">Please select a software package</div>');

      return;
    }

    $.post({
    url: '/answer/ajaxRedo',
    data: {
      software_id: software_id
    },
    dataType: 'json',
    success: function(response) {
      if (response.success === true) {
        window.location = $('.btn-redo').attr('href');
      } else {
        if (response.logged_in === false) {
          window.location = '/login/error';
        }
      }
    }
  });

    return false;
  });
});