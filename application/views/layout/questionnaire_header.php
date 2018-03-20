<link rel="stylesheet" href="/css/form_layout.css">
<link rel="stylesheet" href="/css/questionnaire.css">
<link rel="stylesheet" href="/css/nouislider.min.css">
<link rel="stylesheet" href="/css/loader.css">

<script src="/js/nouislider.min.js"></script>
<script src="/js/jquery.debounce.js"></script>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="/">Systematic Review Questionnaire</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php echo ($tab_active === 'landing' ? 'active' : ''); ?>">
        <a class="nav-link" href="/questionnaire">Home</a>
      </li>
      <li class="nav-item <?php echo ($tab_active === 'software_check' ? 'active' : ''); ?>">
        <a class="nav-link" href="/questionnaire/software">Previous answers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-warning <?php echo ($tab_active === 'questionnaire' ? 'active' : ''); ?>" href="/questionnaire/form">Questionnaire</a>
      </li>
    </ul>

    <div class="progress">
      <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <a class="btn btn-dark" href="/logout" role="button">Sign out</a>
  </div>
</nav>

<div class="spacer"></div>