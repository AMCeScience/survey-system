<?php
  switch ($user_type) {
    case 'using':
      require('partials/uses_software_questions.php');

      break;
    case 'considering':
      require('partials/considers_software_questions.php');

      break;
    case 'no_use':
      require('partials/no_use_software_questions.php');

      break;
  }
?>

<script src="/js/questionnaire.js"></script>