<div class="acp-form-field" id="acp-form-field-<?= $id ?>">

  <label for="<?= $id ?>">
    <?= $title ?>
  </label>

  <textarea 
  name="<?= $id ?>" 
  id="<?= $id ?>" 
  placeholder="<?= $placeholder ?>" 
  ><?= $value ? $value : $default_value; ?></textarea>

  <?php if ($description): ?>
    <p class="acp-form-field-description"><?= $description ?></p>
  <?php endif; ?>

</div>