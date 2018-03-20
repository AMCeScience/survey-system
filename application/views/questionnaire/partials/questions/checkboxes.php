<fieldset data-question-id="<?php echo $question_number; ?>" class="custom-controls-stacked <?php echo ($is_followup === true ? $name . '-container hidden' : ''); ?>">
  <legend><?php echo $question_number_display . '. ' . $question; ?></legend>
  
  <?php foreach($answers as $key => $option) { ?>
    <?php $selected = ''; ?>
    
    <?php if (!is_null($question_answer) && in_array($key, $question_answer)) {
      $selected = 'checked="checked"';
    } ?>

    <label class="custom-control custom-checkbox">
      <input name="<?php echo $name; ?>[]" <?php echo $selected; ?> type="checkbox" class="custom-control-input" value="<?php echo $key; ?>">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description"><?php echo $option; ?></span>
    </label>
  <?php } ?>

  <?php if ($other === true) { ?>
    <?php $selected = ''; ?>
    <?php $shown = 'hidden'; ?>
    <?php $other_text = ''; ?>

    <?php if (!is_null($question_answer) && in_array('0', $question_answer)) {
      $shown = '';
      $selected = 'checked="checked"';
    } ?>

    <?php if (!is_null($question_answer_other)) {
      $other_text = $question_answer_other;
    } ?>

    <label class="custom-control custom-checkbox">
      <input name="<?php echo $name; ?>[]" <?php echo $selected; ?> type="checkbox" class="custom-control-input other-option" value="0">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description">Other (open)</span>
    </label>
    <div class="form-group <?php echo $shown; ?> other-container">
      <label for="other"></label>
      <input name="<?php echo $name . '-open-input'; ?>" type="text" class="form-control" id="" placeholder="Please Specify" value="<?php echo $other_text; ?>">
    </div>
  <?php } ?>
</fieldset>