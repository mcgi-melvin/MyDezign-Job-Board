<?php
$categories = get_terms(
  array(
    'taxonomy' => 'job_listing_category',
    'hide_empty' => true,
  )
);
?>
<div id="JEPH_joblist_filter" class="mb-5">
  <h4 class="text-center">FILTER</h4>
  <div class="filter-form-container">
    <div>
    <form action="<?php echo get_permalink(); ?>" method="GET" autocomplete="off">
      <input class="field-input" type="text" title="Job Title" placeholder="Job Title" name="q" />
      <input class="field-input" type="text" title="Address" placeholder="Address" name="job_address" />
      <select name="job_category">
        <option selected>Choose Category</option>
        <?php foreach($categories as $category): ?>
          <option value="<?= $category->term_id; ?>"><?= $category->name; ?></option>
        <?php endforeach; ?>
      <select>
      <input type="submit" value="SUBMIT" />
    </form>
    </div>
  </div>
</div>
