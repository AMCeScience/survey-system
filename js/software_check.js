$(function() {
  var load_overlay = "<div class='load-overlay'><div class='loader-center'><div class='loader'></div></div></div>";

  $('.software-table input[type="radio"]').on('change', function() {
    disableButton();

    $.post({
      url: '/answer/updateSoftware',
      data: {
        new_value: $(this).val(),
        software_id: $(this).attr('name')
      },
      dataType: 'json',
      success: function(response) {
        enableButton();
      }
    });
  });

  $('.prefill input[type="radio"]').on('change', function() {    
    disableButton();

    $.post({
      url: '/answer/updatePrefill',
      data: {
        new_value: $(this).val(),
        type: $(this).attr('name')
      },
      dataType: 'json',
      success: function(response) {
        enableButton();
      }
    });
  });

  $('.btn-continue').on('click', function(e) {
    e.preventDefault();

    var btn_el = $(this);

    disableButton();

    $.post({
      url: '/questionnaire/finishedPrecheck',
      data: {},
      dataType: 'json',
      success: function(response) {
        if (response.success === true) {
          window.location = $(btn_el).attr('href');
        } else if (response.logged_in === false) {
          window.location = 'login/error';
        }

        enableButton();
      }
    });

    return false;
  });
});

var disableButton = function() {
  $('.btn-continue').addClass('disabled').html('<div class="loader-center">Saving <div class="loader light"></div></div>');
}

var enableButton = function() {
  $('.btn-continue').removeClass('disabled').html('<span class="oi oi-check" title="checked" aria-hidden="true"></span> I\'ve checked my previous answers');
}