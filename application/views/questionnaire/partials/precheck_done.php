<div class="jumbotron">
  <div class="col-sm-8 mx-auto">
    <h1>Welcome!</h1>

    <?php require('research_explanation.php'); ?>

    <div class="alert alert-warning">
      <?php $duration = ($user_type !== 'using' ? '5 minutes' : '10 to 15 minutes') ?>

      Thank you for completing the check of the answers to the first questionnaire.
      The remainder of this questionnaire will take approximately <?php echo $duration; ?>.
      Click on the button below to go to the questionnaire.
    </div>

    <p>
      <a class="btn btn-warning" href="questionnaire/form" role="button">Continue questionnaire »</a>
    </p>
  </div>
</div>