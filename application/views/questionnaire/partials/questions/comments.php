<fieldset>
  <legend>Additional comments</legend>

  <div class="form-group comments-container">
    <label for="comments"></label>
    <textarea name="comments" type="text" class="form-control" placeholder=""><?php echo (array_key_exists($list_type, $comments) ? $comments[$list_type] : ''); ?></textarea>
  </div>
</fieldset>