<fieldset data-question-id="<?php echo $question_number; ?>" class="form-group">
  <legend><?php echo $question_number_display . '. ' . $question; ?></legend>
  <?php if (!is_null($labels)) { ?>
    <div class="row">
      <div class="col-6 label"><?php echo $labels['min']; ?></div>
      <div class="col-6 label label-end"><?php echo $labels['max']; ?></div>
    </div>
  <?php } ?>
  <div data-slider-name="<?php echo $name; ?>-slider" data-max-answer="<?php echo $answers; ?>" data-question-answer="<?php echo $question_answer; ?>" class="unmoved sliders <?php echo $name; ?>-slider"></div>
</fieldset>