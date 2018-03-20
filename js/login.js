asyncLogin = function() {
  $('.failed-login').remove();

  $.post({
    url: '/login/ajax',
    data: $('.form-signin').serialize(),
    dataType: 'json',
    success: function(response) {
      if (response.success !== true) {
        addFailedBox();

        return false;
      }

      window.location = response.redirect;
    },
    failure: function(response) {
      addFailedBox();
    }
  });

  return false;
}

addFailedBox = function() {
  $('.form-signin').before('<div class="failed-login alert alert-danger" role="alert">\
      Sign in failed, please try again or sign in through the link provided in the invitation e-mail. You can contact us at: <a href="email:a.j.vanaltena@amc.uva.nl">a.j.vanaltena@amc.uva.nl</a>\
    </div>');
}