<fieldset data-question-id="<?php echo $question_number; ?>" data-followup-name="<?php echo $followup; ?>" class="custom-controls-stacked">
  <legend><?php echo $question_number_display . '. ' . $question; ?></legend>
  
  <?php foreach ($answers as $value => $answer) { ?>
    <?php $selected = ''; ?>
    
    <?php if (!is_null($question_answer) && strtolower($value) === $question_answer) {
      $selected = 'checked="checked"';
    } ?>

    <label class="custom-control custom-radio">
      <input name="<?php echo $name; ?>" <?php echo $selected; ?> type="radio" class="custom-control-input" value="<?php echo $value; ?>">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description"><?php echo $answer; ?></span>
    </label>
  <?php } ?>

  <?php if ($other === true) { ?>
    <?php $selected = ''; ?>
    <?php $other_text = ''; ?>

    <?php if (!is_null($question_answer) && $question_answer === '0') {
      $selected = 'checked="checked"';
    } ?>

    <?php if (!is_null($question_answer_other)) {
      $other_text = $question_answer_other;
    } ?>
    
    <label class="custom-control custom-radio">
      <input name="<?php echo $name; ?>" <?php echo $selected; ?> type="radio" class="custom-control-input other-option" value="0">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description">Other</span>
    </label>
    <div class="form-group hidden other-container">
      <label for="other"></label>
      <input name="<?php echo $name . '-open-input'; ?>" type="text" class="form-control" placeholder="Please Specify" value="<?php echo $other_text; ?>">
    </div>
  <?php } ?>
</fieldset>