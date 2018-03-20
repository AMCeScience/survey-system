<link rel="stylesheet" href="/css/loader.css">

<div class="container software-check">
  <h3>Answers to the previous questionnaire</h3>

  <p>Here we'd like to check whether the answers you've given to the previous questionnaire are still up to date.</p>
  
  <hr/>
  
  <div class="form-group prefill">
    <h4>In how many systematic reviews were you involved on average in the past two years?</h4>

    <div class="row">
        <div class="col">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="reviews" class="form-check-input" value="1" <?php echo ($reviews->number_of_reviews === '1' ? 'checked="checked"' : ''); ?>>
              Less than 1 per year
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="reviews" class="form-check-input" value="2" <?php echo ($reviews->number_of_reviews === '2' ? 'checked="checked"' : ''); ?>>
              1 per year
            </label>
          </div>
        </div>

        <div class="col">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="reviews" class="form-check-input" value="3" <?php echo ($reviews->number_of_reviews === '3' ? 'checked="checked"' : ''); ?>>
              2 per year
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="reviews" class="form-check-input" value="4" <?php echo ($reviews->number_of_reviews === '4' ? 'checked="checked"' : ''); ?>>
              3 per year
            </label>
          </div>
        </div>

        <div class="col">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="reviews" class="form-check-input" value="5" <?php echo ($reviews->number_of_reviews === '5' ? 'checked="checked"' : ''); ?>>
              4 per year
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="reviews" class="form-check-input" value="6" <?php echo ($reviews->number_of_reviews === '6' ? 'checked="checked"' : ''); ?>>
              More than 4 per year
            </label>
          </div>
        </div>
    </div>
  </div>

  <div class="form-group prefill">
    <h4>What is the average number of search results in systematic reviews you are involved in?</h4>

    <div class="row">
        <div class="col">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="papers" class="form-check-input" value="1" <?php echo ($reviews->number_of_papers === '1' ? 'checked="checked"' : ''); ?>>
              Less than 500
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="papers" class="form-check-input" value="2" <?php echo ($reviews->number_of_papers === '2' ? 'checked="checked"' : ''); ?>>
              500 to 1500
            </label>
          </div>
        </div>

        <div class="col">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="papers" class="form-check-input" value="3" <?php echo ($reviews->number_of_papers === '3' ? 'checked="checked"' : ''); ?>>
              1501 to 3000
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="papers" class="form-check-input" value="4" <?php echo ($reviews->number_of_papers === '4' ? 'checked="checked"' : ''); ?>>
              3001 to 9000
            </label>
          </div>
        </div>

        <div class="col">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="papers" class="form-check-input" value="5" <?php echo ($reviews->number_of_papers === '5' ? 'checked="checked"' : ''); ?>>
              9001 to 18000
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" name="papers" class="form-check-input" value="6" <?php echo ($reviews->number_of_papers === '6' ? 'checked="checked"' : ''); ?>>
              More than 18000
            </label>
          </div>
        </div>
    </div>
  </div>

  <table class="table table-striped software-table">
    <thead class="thead-inverse">
      <tr>
        <th></th>
        <th>I'm not using or considering it</th>
        <th>I'm considering using it</th>
        <th>I use it incidentally</th>
        <th>I use it regularly</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach($software as $item) { ?>
        <?php if ($item->name === 'Other') { continue; } ?>
        <tr>
          <th scope="row">
            <?php echo $item->name; ?>
          </th>
          <td>
            <input type="radio" name="<?php echo $item->software_id; ?>" value="0" <?php echo ($item->value === '0' ? 'checked="checked"' : ''); ?>/>
          </td>
          <td>
            <input type="radio" name="<?php echo $item->software_id; ?>" value="1" <?php echo ($item->value === '1' ? 'checked="checked"' : ''); ?>/>
          </td>
          <td>
            <input type="radio" name="<?php echo $item->software_id; ?>" value="2" <?php echo ($item->value === '2' ? 'checked="checked"' : ''); ?>/>
          </td>
          <td>
            <input type="radio" name="<?php echo $item->software_id; ?>" value="3" <?php echo ($item->value === '3' ? 'checked="checked"' : ''); ?>/>
          </td>
        </tr>
      <?php } ?>
    </tbody>

    <tfoot class="thead-inverse">
      <tr>
        <th></th>
        <th>I'm not using or considering it</th>
        <th>I'm considering using it</th>
        <th>I use it incidentally</th>
        <th>I use it regularly</th>
      </tr>
    </tfoot>
  </table>

  <a class="btn btn-primary btn-continue" href="/questionnaire/form" role="button"><span class="oi oi-check" title="checked" aria-hidden="true"></span> I've checked my previous answers</a>

  <div class="clearfix"></div>
</div>

<script src="/js/software_check.js"></script>