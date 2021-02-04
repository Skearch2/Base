<!-- Start createalbum.php -->

<?php
$main     = $this->config->item('main_class');
$css      = $this->config->item('css_thumbnail_class');

$iid      = $this->config->item('imageserver_field_image_id');
$ititle   = $this->config->item('imageserver_field_image_title');
$idesc    = $this->config->item('imageserver_field_image_description');
$ibrandid = $this->config->item('imageserver_field_image_brandid');
$imediaurl  = $this->config->item('imageserver_field_image_mediaurl');
$iimp     = $this->config->item('imageserver_field_image_impressions');
$iclicks  = $this->config->item('imageserver_field_image_clicks');
$iduration  = $this->config->item('imageserver_field_image_duration');
$ifile    = $this->config->item('imageserver_field_image_filename');
$ipriority  = $this->config->item('imageserver_field_image_priority');
$istatus  = $this->config->item('imageserver_field_image_status');
$idate_created  = $this->config->item('imageserver_field_image_date_created');
$idate_modified  = $this->config->item('imageserver_field_image_date_modified');

$alb_umbrella = $this->config->item('album_umbrella');
$alb_field    = $this->config->item('album_field');

if ($albumtype === $alb_umbrella) {
  $keyword = $umbrella;
} elseif ($albumtype === $alb_field) {
  $keyword = $field;
}

// echo "<pre>";
// print_r(sizeof($mediaboxa_images['vals']));
// die();


?>

<div class="page-header">
  <?php if ($albumtype === $alb_umbrella) : ?>
    <h1><?= ucwords($albumtype); ?>: <?= ucwords($umbrella); ?></h1>
  <?php elseif ($albumtype === $alb_field) : ?>
    <h1><?= ucwords($albumtype); ?>: <?= ucwords($field); ?></h1>
  <?php endif; ?>
</div>

<br>

<div class="page-header">
  <h2>Media Box A</h2>
</div>


<div class="row">
  <div class="col-md-12">
    <table class="table table-striped" style="table-layout:fixed">
      <thead>
        <tr>
          <th style='display:none;'>ID</th>
          <th>Priority</th>
          <th>Name</th>
          <th>Description</th>
          <th width="120px">Thumbnail</th>
          <th>Clicks</th>
          <th>Impressions</th>
          <th>Time</th>
          <th>Active</th>
          <th>Last Modified</th>
          <th>Date Created</th>
          <th width="150px">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!(array) $mediaboxa_images) : ?>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style='text-align:right'>No Media</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        <?php else : ?>
          <?php if (isset($mediaboxa_images->item->item)) : ?>
            <?php foreach ($mediaboxa_images->item->item as $image) : ?>
              <?php
              // check if the media is a video (only mp4 format)
              $is_video = substr(strtolower($image->$ifile), -3) == 'mp4' ? 1 : 0;
              ?>
              <?php if ($archived == 0) : ?>
                <tr style='cursor: grab;'>
                <?php else : ?>
                <tr>
                <?php endif ?>
                <td style='display: none'><?= $image->$iid ?></td>
                <td><?= $image->$ipriority ?></td>
                <td><?= $image->$ititle ?></td>
                <td><?= $image->$idesc ?></td>
                <!-- <td><?= $image->$ibrandid ?></td> -->
                <td>
                  <?php if ($is_video) : ?>
                    <i title="Video" class="fas fa-video"></i>
                  <?php else : ?>
                    <img src=<?= $image->$ifile ?> alt="No Media" id="image_<?= $image->$iid ?>" class="<?= $css ?>">
                  <?php endif ?>
                </td>
                <td><?= $image->$iclicks ?></td>
                <td><?= $image->$iimp ?></td>
                <td><input type="number" onchange="updateMediaDuration(<?= $image->$iid ?>,$(this).val())" value=<?= $image->$iduration ?> style="width:60%"></td>
                <td>
                  <?php if ($image->$istatus) : ?>
                    <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" checked <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                  <?php else : ?>
                    <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                  <?php endif ?>
                <td><?= $image->$idate_modified ?></td>
                <td><?= $image->$idate_created ?> </td>
                </td>
                <td>
                  <a href="#" onclick="viewMedia('<?= $image->$ifile ?>',<?= $is_video ?>)" title="View Media" class="fas fa-eye"></a>&nbsp;
                  <a href="<?= base_url("$main/editimageglobal") . '/' . $image->$iid ?>" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;
                  <?php if ($archived == 0) : ?>
                    <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Archive Media" class="fas fa-archive"></a>&nbsp;
                  <?php else : ?>
                    <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Restore Media" class="fas fa-undo-alt"></a>
                    <a href="<?= base_url("$main/deleteimageglobal") . '/' . $image->$iid ?>" title="Delete Media" class="fas fa-trash"></a>
                  <?php endif ?>
                </td>
                </tr>
              <?php endforeach ?>
            <?php else : ?>
              <?php
              // reassigning for easier use
              $image = $mediaboxa_images->item;
              // check if the media is a video (only mp4 format)
              $is_video = substr(strtolower($image->$ifile), -3) == 'mp4' ? 1 : 0;
              ?>
              <?php if ($archived == 0) : ?>
                <tr style='cursor: grab;'>
                <?php else : ?>
                <tr>
                <?php endif ?>
                <td style='display: none'><?= $image->$iid ?></td>
                <td><?= $image->$ipriority ?></td>
                <td><?= $image->$ititle ?></td>
                <td><?= $image->$idesc ?></td>
                <!-- <td><?= $image->$ibrandid ?></td> -->
                <td>
                  <?php if ($is_video) : ?>
                    <i title="Video" class="fas fa-video"></i>
                  <?php else : ?>
                    <img src=<?= $image->$ifile ?> alt="No Media" id="image_<?= $image->$iid ?>" class="<?= $css ?>">
                  <?php endif ?>
                </td>
                <td><?= $image->$iclicks ?></td>
                <td><?= $image->$iimp ?></td>
                <td><input type="number" onchange="updateMediaDuration(<?= $image->$iid ?>,$(this).val())" value=<?= $image->$iduration ?> style="width:60%"></td>
                <td>
                  <?php if ($image->$istatus) : ?>
                    <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" checked <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                  <?php else : ?>
                    <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                  <?php endif ?>
                <td><?= $image->$idate_modified ?></td>
                <td><?= $image->$idate_created ?> </td>
                </td>
                <td>
                  <a href="#" onclick="viewMedia('<?= $image->$ifile ?>',<?= $is_video ?>)" title="View Media" class="fas fa-eye"></a>&nbsp;
                  <a href="<?= base_url("$main/editimageglobal") . '/' . $image->$iid ?>" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;
                  <?php if ($archived == 0) : ?>
                    <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Archive Media" class="fas fa-archive"></a>&nbsp;
                  <?php else : ?>
                    <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Restore Media" class="fas fa-undo-alt"></a>
                    <a href="<?= base_url("$main/deleteimageglobal") . '/' . $image->$iid ?>" title="Delete Media" class="fas fa-trash"></a>
                  <?php endif ?>
                </td>
                </tr>
              <?php endif ?>
            <?php endif ?>
      </tbody>
    </table>
  </div>
  <!-- /.col-md-6 -->
</div>

<div class="row">
  <div class="col-md-6">
    <?= '<a class="btn btn-primary" href="' . base_url("$main/addimage/$albumtype/$albumtypeid/$keyword/$mediaboxa_albumid") . '">Add Media</a>'; ?>
  </div>
</div>

<br>

<?php if ($albumtype === $alb_umbrella) : ?>

  <div class="page-header">
    <h2>Media Box U</h2>
  </div>

  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped" style="table-layout:fixed">
        <thead>
          <tr>
            <th style='display:none;'>ID</th>
            <th>Priority</th>
            <th>Name</th>
            <th>Description</th>
            <th width="120px">Thumbnail</th>
            <th>Clicks</th>
            <th>Impressions</th>
            <th>Time</th>
            <th>Active</th>
            <th>Last Modified</th>
            <th>Date Created</th>
            <th width="150px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!(array) $mediaboxu_images) : ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style='text-align:right'>No Media</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          <?php else : ?>
            <?php if (isset($mediaboxu_images->item->item)) : ?>
              <?php foreach ($mediaboxu_images->item->item as $image) : ?>
                <?php
                // check if the media is a video (only mp4 format)
                $is_video = substr(strtolower($image->$ifile), -3) == 'mp4' ? 1 : 0;
                ?>
                <?php if ($archived == 0) : ?>
                  <tr style='cursor: grab;'>
                  <?php else : ?>
                  <tr>
                  <?php endif ?>
                  <td style='display: none'><?= $image->$iid ?></td>
                  <td><?= $image->$ipriority ?></td>
                  <td><?= $image->$ititle ?></td>
                  <td><?= $image->$idesc ?></td>
                  <!-- <td><?= $image->$ibrandid ?></td> -->
                  <td>
                    <?php if ($is_video) : ?>
                      <i title="Video" class="fas fa-video"></i>
                    <?php else : ?>
                      <img src=<?= $image->$ifile ?> alt="No Media" id="image_<?= $image->$iid ?>" class="<?= $css ?>">
                    <?php endif ?>
                  </td>
                  <td><?= $image->$iclicks ?></td>
                  <td><?= $image->$iimp ?></td>
                  <td><input type="number" onchange="updateMediaDuration(<?= $image->$iid ?>,$(this).val())" value=<?= $image->$iduration ?> style="width:60%"></td>
                  <td>
                    <?php if ($image->$istatus) : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" checked <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php else : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php endif ?>
                  <td><?= $image->$idate_modified ?></td>
                  <td><?= $image->$idate_created ?> </td>
                  </td>
                  <td>
                    <a href="#" onclick="viewMedia('<?= $image->$ifile ?>',<?= $is_video ?>)" title="View Media" class="fas fa-eye"></a>&nbsp;
                    <a href="<?= base_url("$main/editimageglobal") . '/' . $image->$iid ?>" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;
                    <?php if ($archived == 0) : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Archive Media" class="fas fa-archive"></a>&nbsp;
                    <?php else : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Restore Media" class="fas fa-undo-alt"></a>
                      <a href="<?= base_url("$main/deleteimageglobal") . '/' . $image->$iid ?>" title="Delete Media" class="fas fa-trash"></a>
                    <?php endif ?>
                  </td>
                  </tr>
                <?php endforeach ?>
              <?php else : ?>
                <?php
                // reassigning for easier use
                $image = $mediaboxu_images->item;
                // check if the media is a video (only mp4 format)
                $is_video = substr(strtolower($image->$ifile), -3) == 'mp4' ? 1 : 0;
                ?>
                <?php if ($archived == 0) : ?>
                  <tr style='cursor: grab;'>
                  <?php else : ?>
                  <tr>
                  <?php endif ?>
                  <td style='display: none'><?= $image->$iid ?></td>
                  <td><?= $image->$ipriority ?></td>
                  <td><?= $image->$ititle ?></td>
                  <td><?= $image->$idesc ?></td>
                  <!-- <td><?= $image->$ibrandid ?></td> -->
                  <td>
                    <?php if ($is_video) : ?>
                      <i title="Video" class="fas fa-video"></i>
                    <?php else : ?>
                      <img src=<?= $image->$ifile ?> alt="No Media" id="image_<?= $image->$iid ?>" class="<?= $css ?>">
                    <?php endif ?>
                  </td>
                  <td><?= $image->$iclicks ?></td>
                  <td><?= $image->$iimp ?></td>
                  <td><input type="number" onchange="updateMediaDuration(<?= $image->$iid ?>,$(this).val())" value=<?= $image->$iduration ?> style="width:60%"></td>
                  <td>
                    <?php if ($image->$istatus) : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" checked <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php else : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php endif ?>
                  <td><?= $image->$idate_modified ?></td>
                  <td><?= $image->$idate_created ?> </td>
                  </td>
                  <td>
                    <a href="#" onclick="viewMedia('<?= $image->$ifile ?>',<?= $is_video ?>)" title="View Media" class="fas fa-eye"></a>&nbsp;
                    <a href="<?= base_url("$main/editimageglobal") . '/' . $image->$iid ?>" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;
                    <?php if ($archived == 0) : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Archive Media" class="fas fa-archive"></a>&nbsp;
                    <?php else : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Restore Media" class="fas fa-undo-alt"></a>
                      <a href="<?= base_url("$main/deleteimageglobal") . '/' . $image->$iid ?>" title="Delete Media" class="fas fa-trash"></a>
                    <?php endif ?>
                  </td>
                  </tr>
                <?php endif ?>
              <?php endif ?>
        </tbody>
      </table>
    </div><!-- /.col-md-6 -->
  </div>

  <div class="row">
    <div class="col-md-6">
      <?= '<a class="btn btn-primary" href="' . base_url("$main/addimage/$albumtype/$albumtypeid/$keyword/$mediaboxu_albumid") . '">Add Media</a>'; ?>
    </div>
  </div>

  <!-- Creates the bootstrap modal where the image will appear -->
  <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="modal-body">
          <img src="" id="imagepreview">
        </div>
      </div>
    </div>
  </div>

  <!-- Creates the bootstrap modal where the video will appear -->
  <div class="modal fade" id="videomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="modal-body">
          <video controls autoplay id="videopreview">
            Unable to play video, incompatible browser.
          </video>
        </div>
      </div>
    </div>
  </div>

<?php elseif ($albumtype === $alb_field) : ?>

  <div class="page-header">
    <h2>Media Box B</h2>
  </div>

  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped" style="table-layout:fixed">
        <thead>
          <tr>
            <th style='display:none;'>ID</th>
            <th>Priority</th>
            <th>Name</th>
            <th>Description</th>
            <th width="120px">Thumbnail</th>
            <th>Clicks</th>
            <th>Impressions</th>
            <th>Time</th>
            <th>Active</th>
            <th>Last Modified</th>
            <th>Date Created</th>
            <th width="150px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!(array) $mediaboxb_images) : ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style='text-align:right'>No Media</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          <?php else : ?>
            <?php if (isset($mediaboxb_images->item->item)) : ?>
              <?php foreach ($mediaboxb_images->item->item as $image) : ?>
                <?php
                // check if the media is a video (only mp4 format)
                $is_video = substr(strtolower($image->$ifile), -3) == 'mp4' ? 1 : 0;
                ?>
                <?php if ($archived == 0) : ?>
                  <tr style='cursor: grab;'>
                  <?php else : ?>
                  <tr>
                  <?php endif ?>
                  <td style='display: none'><?= $image->$iid ?></td>
                  <td><?= $image->$ipriority ?></td>
                  <td><?= $image->$ititle ?></td>
                  <td><?= $image->$idesc ?></td>
                  <!-- <td><?= $image->$ibrandid ?></td> -->
                  <td>
                    <?php if ($is_video) : ?>
                      <i title="Video" class="fas fa-video"></i>
                    <?php else : ?>
                      <img src=<?= $image->$ifile ?> alt="No Media" id="image_<?= $image->$iid ?>" class="<?= $css ?>">
                    <?php endif ?>
                  </td>
                  <td><?= $image->$iclicks ?></td>
                  <td><?= $image->$iimp ?></td>
                  <td><input type="number" onchange="updateMediaDuration(<?= $image->$iid ?>,$(this).val())" value=<?= $image->$iduration ?> style="width:60%"></td>
                  <td>
                    <?php if ($image->$istatus) : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" checked <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php else : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php endif ?>
                  <td><?= $image->$idate_modified ?></td>
                  <td><?= $image->$idate_created ?> </td>
                  </td>
                  <td>
                    <a href="#" onclick="viewMedia('<?= $image->$ifile ?>',<?= $is_video ?>)" title="View Media" class="fas fa-eye"></a>&nbsp;
                    <a href="<?= base_url("$main/editimageglobal") . '/' . $image->$iid ?>" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;
                    <?php if ($archived == 0) : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Archive Media" class="fas fa-archive"></a>&nbsp;
                    <?php else : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Restore Media" class="fas fa-undo-alt"></a>
                      <a href="<?= base_url("$main/deleteimageglobal") . '/' . $image->$iid ?>" title="Delete Media" class="fas fa-trash"></a>
                    <?php endif ?>
                  </td>
                  </tr>
                <?php endforeach ?>
              <?php else : ?>
                <?php
                // reassigning for easier use
                $image = $mediaboxb_images->item;
                // check if the media is a video (only mp4 format)
                $is_video = substr(strtolower($image->$ifile), -3) == 'mp4' ? 1 : 0;
                ?>
                <?php if ($archived == 0) : ?>
                  <tr style='cursor: grab;'>
                  <?php else : ?>
                  <tr>
                  <?php endif ?>
                  <td style='display: none'><?= $image->$iid ?></td>
                  <td><?= $image->$ipriority ?></td>
                  <td><?= $image->$ititle ?></td>
                  <td><?= $image->$idesc ?></td>
                  <!-- <td><?= $image->$ibrandid ?></td> -->
                  <td>
                    <?php if ($is_video) : ?>
                      <i title="Video" class="fas fa-video"></i>
                    <?php else : ?>
                      <img src=<?= $image->$ifile ?> alt="No Media" id="image_<?= $image->$iid ?>" class="<?= $css ?>">
                    <?php endif ?>
                  </td>
                  <td><?= $image->$iclicks ?></td>
                  <td><?= $image->$iimp ?></td>
                  <td><input type="number" onchange="updateMediaDuration(<?= $image->$iid ?>,$(this).val())" value=<?= $image->$iduration ?> style="width:60%"></td>
                  <td>
                    <?php if ($image->$istatus) : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" checked <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php else : ?>
                      <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $image->$iid ?>)" <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
                    <?php endif ?>
                  <td><?= $image->$idate_modified ?></td>
                  <td><?= $image->$idate_created ?> </td>
                  </td>
                  <td>
                    <a href="#" onclick="viewMedia('<?= $image->$ifile ?>',<?= $is_video ?>)" title="View Media" class="fas fa-eye"></a>&nbsp;
                    <a href="<?= base_url("$main/editimageglobal") . '/' . $image->$iid ?>" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;
                    <?php if ($archived == 0) : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Archive Media" class="fas fa-archive"></a>&nbsp;
                    <?php else : ?>
                      <a href="<?= base_url("$main/archiveimageglobal") . '/' . $image->$iid ?>" title="Restore Media" class="fas fa-undo-alt"></a>
                      <a href="<?= base_url("$main/deleteimageglobal") . '/' . $image->$iid ?>" title="Delete Media" class="fas fa-trash"></a>
                    <?php endif ?>
                  </td>
                  </tr>
                <?php endif ?>
              <?php endif ?>
        </tbody>
      </table>
    </div><!-- /.col-md-6 -->
  </div>

  <div class="row">
    <div class="col-md-6">
      <?= '<a class="btn btn-primary" href="' . base_url("$main/addimage/$albumtype/$albumtypeid/$keyword/$mediaboxb_albumid") . '">Add Media</a>'; ?>
    </div>
  </div>

<?php endif; ?>

<script>
  // Toggle media active status
  function toggleMediaStatus(imageId) {
    $.ajax({
      url: "<?= site_url("main/toggleimagestatus/"); ?>" + imageId,
      type: 'GET',
      success: function(status) {
        console.log("Success toggling media view");
      },
      contentType: "application/text",
      dataType: "text",
      error: function() {
        console.log("Unable to toggle media view.");
      }
    });
  }

  // get media priorities from the album
  $(function() {
    var data = {};
    $("table tbody").sortable({
      refreshPositions: true,
      cursor: "row-resize",
      scroll: false,
      containment: 'parent',
      axis: "y",
      // prevent table from shrinking
      'start': function(event, ui) {
        ui.placeholder.html("")
      },
      update: function(event, ui) {
        $(this).children().each(function(index) {
          // update priorites
          $(this).find('td').eq(1).html(index + 1)
        });
      },
      stop: function() {
        $(this).children().each(function() {
          // get the id and prioriy of the current row
          data[$(this).find('td').eq(0).html()] = $(this).find('td').eq(1).html();
        })
        updateMediaPriorities(data);
      }
    }).disableSelection();
  });

  // update media priorities
  function updateMediaPriorities(data) {
    $.ajax({
      type: 'POST',
      url: "<?= site_url("main/updatemediapriorities"); ?>",
      data: {
        "mediapriorities": data
      },
      contentType: "application/x-www-form-urlencoded",
      datatype: 'json',
      success: function(status) {
        console.log("Success updating priorities");
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log("Unable to update priorities");
      }
    });
  }

  // Show modal dialog to preview media
  function viewMedia(src, isVideo = 0) {
    if (isVideo == 1) {
      $('#videopreview').attr('src', src);
      $('#videomodal').modal('show');
    } else {
      $('#mediapreview').attr('src', src);
      $('#mediamodal').modal('show');
    }
  }

  // Stop the video when the modal dialog is closed
  $('body').on('hidden.bs.modal', '.modal', function() {
    $('video').trigger('pause');
  });

  // Update media duration
  function updateMediaDuration(mediaId, duration) {
    // duration must be within 1 to 300 range
    if (duration >= 1 && duration <= 300) {
      $.ajax({
        url: "<?= site_url("main/updatemediaduration/"); ?>" + mediaId + "/" + duration,
        type: 'GET',
        success: function(status) {},
        error: function() {
          console.log("Unable to updating media duration.");
        }
      });
    } else {
      alert("Duration must be between 1 to 300 seconds");
    }
  }
</script>

<!-- End viewalbum.php -->