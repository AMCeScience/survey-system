<script src="/js/redo.js"></script>

<div class="container main-container">
  <?php if (count($software_done) > 0 && $last_is_complete) {
    require('partials/redo_landing.php');

    require('partials/questionnaire_done.php');
  } else if ($last_is_complete) {
    require('partials/questionnaire_done.php');
  } else { ?>
    <?php if ($done_precheck_stage === false) {
      require('partials/new_user.php');
    } ?>

    <?php if ($done_precheck_stage === true) {
      require('partials/precheck_done.php');
    } ?>
  <?php } ?>
</div>