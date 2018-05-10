<div class="gae-form-field" id="gae-form-field-<?= $id ?>">
  <label for="<?= $id ?>">
    <?= $title ?>
  </lable>

  <select name="<?= $id ?>" id="<?= $id ?>">
    <?php foreach($options as $o): ?>
      <option
      <?php if ((strlen($value)>0 && $value===$o["value"]) || (empty($value) && $default_value===$o["value"])): ?>
        selected="selected"
      <?php endif; ?>
      value="<?= $o["value"] ?>"><?= $o["title"] ?></option>
    <?php endforeach; ?>
  </select>
</div>
