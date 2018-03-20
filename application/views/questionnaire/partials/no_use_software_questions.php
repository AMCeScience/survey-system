<?php $question_begin = 0; ?>

<div class="container">
  <form>
    <div data-list-name="generic" class="question-container generic-questions">
      <p>
        Thank you for completing the check of the answers to the first questionnaire.
        The remainder of this questionnaire will take approximately 5 to 10 minutes.
        Here we ask you general questions about how you choose and assess (new) tools.
      </p>

      <?php $user_answers = $user_answers['generic']; ?>

      <?php foreach ($generic_questions as $question_number => $question_obj) {
        require ('questions/question.php');
      } ?>

      <?php $list_type = 'generic'; ?>

      <?php require('questions/comments.php'); ?>

      <a class="btn btn-primary btn-continue" href="/questionnaire" role="button">Next »</a>
    </div>
  </form>
</div>