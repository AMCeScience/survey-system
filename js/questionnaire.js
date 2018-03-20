$(function() {
  bind_check_list_completion();

  bind_other_options();

  bind_question_inputs();

  // Bind window change to alert popup
  prevent_window_change();
});

var send_answer = function(question_el, answer) {
  var question_list = $(question_el).closest('.question-container').data('list-name');
  var question_id = $(question_el).closest('fieldset').data('question-id');

  var other_text = $(question_el).closest('fieldset').find('.other-container input').val();
  
  var software_id = $('input[name=software_id]').val();

  disable_page_buttons();

  $.post({
      url: '/answer/ajax',
      data: {
        question_list: question_list,
        question_id: question_id,
        answer: answer,
        other_text: other_text,
        software_id: software_id
      },
      dataType: 'json',
      success: function(response) {
        if (response.success === true) {
          $('.progress-bar').css('width', response.new_progress + '%');
        } else if (response.logged_in === false) {
          window.location = '/login/error';
        }

        enable_page_buttons();
      }
    });
}

var disable_page_buttons = function() {
  if ($.active === 0) {
    $('.btn-page-change').find('.btn-previous').addClass('disabled');
    $('.btn-page-change').find('.btn-primary').addClass('disabled').html('<div class="loader-center">Saving <div class="loader light"></div></div>');
  }
}

var enable_page_buttons = function() {
  if ($.active < 2) {
    $('.btn-page-change').find('.btn-previous').removeClass('disabled');
    $('.btn-page-change').find('.btn-primary').removeClass('disabled').html('Next »');
  }
}

var prevent_window_change = function() {
  $(window).bind('beforeunload', function() {
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");
      var edge = ua.indexOf("Edge");

      if (msie > 0 || edge > -1 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        return;
      } else if ($.active > 0) {
        return 'Still busy storing answers, are you sure?';
      }
      
      return;
  });
}

var bind_check_list_completion = function() {
  $('.btn-continue').on('click', function(e) {
    e.preventDefault();

    var btn_el = $(this);

    check_list_completion(btn_el, true);
  });
}

var check_list_completion = function(btn_el, first) {
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");
  var edge = ua.indexOf("Edge");

  if ((msie > 0 || edge > -1 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) && first)  {
    setTimeout(check_list_completion(btn_el), 500, false);
  } else if ($.active > 0) {
    setTimeout(check_list_completion(btn_el), 100, false);

    return;
  }

  var question_container = $(btn_el).closest('.question-container');

  // Remove any warnings from last check
  $('.alert').remove();

  $('fieldset', question_container).each(function() {
    $(this).removeClass('warning');
  });

  var question_list = $(question_container).data('list-name');

  $.post({
    url: '/questionnaire/nextCheck',
    data: {
      question_list: question_list
    },
    dataType: 'json',
    success: function(response) {
      if (response.completed === true) {
        window.location = $(btn_el).attr('href');
      } else {
        try {
          var add_number = question_begin;  
        } catch(e) {
          var add_number = 0;
        }

        var todo = response.todo.map(function(question_number) {
          return question_number + add_number;
        });
        
        $(question_container).prepend('<div class="alert alert-danger">Please answer the following questions: ' + todo.join(', ') + '</div>');

        $('fieldset', question_container).each(function() {
          if (response.todo.indexOf($(this).data('question-id')) !== -1) {
            $(this).addClass('warning');
          }
        });

        $("html, body").animate({ scrollTop: 0 }, "slow");
      }
    }
  });

  return false;
}

var bind_other_options = function() {
  // Initialise checkbox 'other' input field
  $('.other-option').change(function() {
    var container = $(this).parent().parent().find('.other-container');

    if (this.checked) {
      $(container).show();

      return;
    }

    $(container).hide();
  });

  $('.other-container input').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);

    if (keycode == '13') {
      var answer_values = get_input_answers($(this).parent().prev().find('.other-option'));

      send_answer(this, answer_values);
    }
  });

  $('.other-container input').blur(function() {
    var answer_values = get_input_answers($(this).parent().prev().find('.other-option'));

    send_answer(this, answer_values);
  });

  // Initialise radio 'other' input field
  $('input[type=radio]').each(function() {
    var follow_up = $(this).closest('fieldset').data('followup-name');
    var container = $('.' + follow_up + '-container');
    var other_el = $(this).parent().parent().find('.other-container');

    // Follow-up container
    if (container.length > 0) {
      if ($(this).val() === 'yes' && $(this).is(':checked')) {
        $(container).css('display', 'flex');
      }

      $(this).change(function() {
        if ($(this).val() === 'yes' && $(this).is(':checked')) {
          $(container).css('display', 'flex');

          return;
        }

        $(container).hide();
      });
    }

    if ($(this).val() === '0' && $(this).is(':checked')) {
      $(other_el).show();
    }

    // Other container
    $(this).change(function() {      
      if ($(this).val() === '0') {
        $(other_el).show();

        return;
      }

      $(other_el).hide();
    });
  });
}

var send_comment = function(el) {
  var question_list = $(el).closest('.question-container').data('list-name');

  disable_page_buttons();

  $.post({
    url: '/answer/storeComment',
    data: {
      comment: el.val(),
      question_list: question_list
    },
    dataType: 'json',
    success: function(response) {
      if (response.logged_in === false) {
        window.location = '/login/error';
      }

      enable_page_buttons();
    }
  });
}

var bind_question_inputs = function() {
  $('.comments-container textarea').on('focus', function() {
    $(this).css('height', '100px');
  });

  $('.comments-container textarea').on('blur', function() {
    $(this).css('height', '58px');

    send_comment($(this));
  })

  $('.comments-container textarea').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);

    if (keycode == '13') {
      send_comment($(this));
    }
  });

  // Create sliders and bind slider change to ajax
  $('div.sliders').each(function() {
    var slider_class = $(this).data('slider-name');
    var max_answer = $(this).data('max-answer');
    var user_input = $(this).data('question-answer');

    var slider_el = $('.' + slider_class)[0];

    noUiSlider.create(slider_el, {
      start: 1,
      step: 1,
      pips: {
        mode: 'steps',
        density: 20
      },
      range: {
        'min': [1],
        'max': [max_answer]
      }
    });

    if (user_input !== null && user_input !== '') {
      slider_el.noUiSlider.set(user_input);
      $(slider_el).removeClass('unmoved');
    } else {
      slider_el.noUiSlider.set(Math.round(max_answer / 2));
    }

    slider_el.noUiSlider.on('change', function() {
      send_answer(this.target, parseInt(this.get()));

      $(slider_el).removeClass('unmoved');
    });
  });

  // Bind checkbox change to ajax
  $('.custom-checkbox input').on('change', $.debounce(500,
    function() {
      var answer_values = get_input_answers($(this));

      send_answer(this, answer_values);
    }
  ));

  // Bind radio change to ajax
  $('.custom-radio input').on('change', function() {
    send_answer(this, $(this).val());
  });
}

var get_input_answers = function(el) {
  var el_type = $(el).attr('type');

  if (el_type === 'checkbox') {
    var el_name = $(el).attr('name').replace('[', '').replace(']', '');

    var answer_values = $('input[name^=' + el_name + ']:checkbox:checked').map(function(){
      return $(this).val();
    }).get();
  } else {
    var answer_values = $('input[name=' + $(el).attr('name') + ']:checked').val();
  }

  return answer_values;
}