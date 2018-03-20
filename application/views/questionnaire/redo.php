<script src="/js/redo.js"></script>

<div class="container main-container">
  <div class="alert alert-info">
    <h3>Thank you for completing the questionnaire!</h3>

    <p>You can help us to gather data on as many tools as possible.</p>
    
    <p>Below, select with which tool you want to redo the questionnaire and click next (<span class="font-weight-bold">this takes approximately 10 minutes</span>).</p>

    <select class="form-control">
      <?php foreach ($interesting_software as $software_id => $name) { ?>
        <option value="<?php echo $software_id; ?>"><?php echo $name; ?></option>
      <?php } ?>
    </select>

    <a class="btn btn-primary btn-continue btn-redo" href="/questionnaire/form/1" role="button">Next »</a>
  </div>

  <div class="container">
    <a class="btn btn-continue" href="/questionnaire" role="button">Exit</a>
  </div>
</div>