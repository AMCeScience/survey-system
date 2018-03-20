<?php $question_begin = 0; ?>

<div class="container main-form-container">
  <form>
    <?php if ($form_page * 1 == 0 || is_null($form_page)) { ?>
      <div data-list-name="generic" class="question-container generic-questions">
        <p>
          Thank you for completing the check of the answers to the first questionnaire.
          The remainder of this questionnaire will take approximately 10 to 15 minutes.
          First, we ask you general questions about how you choose and assess (new) tools.
        </p>

        <?php $user_answers = $user_answers['generic']; ?>
        
        <?php foreach ($generic_questions as $question_number => $question_obj) {
          require ('questions/question.php');
        } ?>

        <?php $list_type = 'generic'; ?>

        <?php require('questions/comments.php'); ?>

        <div class="row btn-page-change">
          <div class="col-12">
            <a class="btn btn-primary btn-continue" href="/questionnaire/form/1" role="button">Next »</a>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if ($form_page * 1 == 1) { ?>
      <div data-list-name="specific" class="question-container tool-specific-questions">
        <p>
          In this part we ask you questions about a specific automation tool.
          The first tool is picked automatically by the questionnaire,
          at the end of the questionnaire you may answer the questions about additional tools of your own choosing.
        </p>

        <div class="alert alert-info">
          You are filling out the questionnaire for the following tool:

          <h3><?php echo $picked_software->name; ?></h3>
        </div>

        <input type="hidden" name="software_id" value="<?php echo $picked_software->software_id; ?>"/>

        <?php $user_answers = $user_answers['specific']; ?>
        <?php $question_begin = 13; ?>

        <script>
          var question_begin = 13;
        </script>

        <?php foreach ($tool_questions as $question_number => $question_obj) {
          require ('questions/question.php');
        } ?>

        <?php $list_type = 'specific'; ?>

        <?php require('questions/comments.php'); ?>

        <div class="row btn-page-change">
          <div class="col-4"><a class="btn btn-previous row-btn" href="/questionnaire/form" role="button">Previous</a></div>
          <div class="col-8"><a class="btn btn-primary btn-continue row-btn" href="/questionnaire/form/2" role="button">Next »</a></div>
        </div>
      </div>
    <?php } ?>

    <?php if ($form_page * 1 == 2) { ?>
      <div data-list-name="usability" class="question-container usability-questions">
        <p>
          On this last page we ask about the usability of a specific automation tool.
          The first tool is picked automatically by the questionnaire,
          at the end of the questionnaire you may answer the questions about additional tools of your own choosing.
        </p>

        <div class="alert alert-info">
          You are filling out the usability questions for the following tool:

          <h3><?php echo $picked_software->name; ?></h3>
        </div>

        <input type="hidden" name="software_id" value="<?php echo $picked_software->software_id; ?>"/>

        <?php $user_answers = $user_answers['usability']; ?>
        <?php $question_begin = 24; ?>

        <script>
          var question_begin = 24;
        </script>

        <?php foreach ($sus_questions as $question_number => $question_obj) {
          require ('questions/question.php');
        } ?>

        <?php $list_type = 'usability'; ?>

        <?php require('questions/comments.php'); ?>

        <div class="row btn-page-change">
          <div class="col-4"><a class="btn btn-previous row-btn" href="/questionnaire/form/1" role="button">Previous</a></div>
          <div class="col-8"><a class="btn btn-primary btn-continue row-btn" href="/questionnaire/redo" role="button">Next »</a></div>
        </div>
      </div>
    <?php } ?>
  </form>
</div>