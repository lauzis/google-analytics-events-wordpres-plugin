<div class="gae-form-field" id="gae-form-field-<?= $id ?>">

  <label for="<?= $id ?>">
    <?= $title ?>
  </lable>

  <input name="<?= $id ?>" id="<?= $id ?>" placeholder="<?= $placeholder ?>" value="<?= $value ? $value : $default_value; ?>" />

</div>
