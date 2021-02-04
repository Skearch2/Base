<!-- Start createalbum.php -->

<?php
$main   = $this->config->item('main_class');
$css    = $this->config->item('css_thumbnail_class');

$aid    = $this->config->item('imageserver_field_album_id');
$atitle   = $this->config->item('imageserver_field_album_title');
$adesc    = $this->config->item('imageserver_field_album_description');
$atype  = $this->config->item('imageserver_field_album_type');

$iid    = $this->config->item('imageserver_field_image_id');
$ibrandid = $this->config->item('imageserver_field_image_brandid');
$ititle = $this->config->item('imageserver_field_image_title');
$idesc  = $this->config->item('imageserver_field_image_description');
$imediaurl  = $this->config->item('imageserver_field_image_mediaurl');
$iimp     = $this->config->item('imageserver_field_image_impressions');
$iclicks  = $this->config->item('imageserver_field_image_clicks');
$iduration  = $this->config->item('imageserver_field_image_duration');
$ifile  = $this->config->item('imageserver_field_image_filename');
$ipriority  = $this->config->item('imageserver_field_image_priority');
$istatus  = $this->config->item('imageserver_field_image_status');
$idate_created  = $this->config->item('imageserver_field_image_date_created');
$idate_modified  = $this->config->item('imageserver_field_image_date_modified');

$title  = $this->config->item('data_title');
$desc   = $this->config->item('data_description');

?>

<div class="page-header">
  <h2><?= ucwords($album->$atype) .  " - " . $album->$atitle; ?></h2>
</div>

<br>

<form class="form-horizontal" method="POST" action="<?= base_url(); ?><?= $main; ?>/updatealbum/<?= $album->{$aid}; ?>">

  <label for="<?= $title; ?>" class="control-label">Album Title</label>
  <input type="text" name="<?= $title; ?>" id="<?= $title; ?>" class="form-control" value="<?= $album->{$atitle}; ?>" required autofocus>

  <br>

  <label for="<?= $desc; ?>" class="control-label">Album Description</label>
  <input type="text" name="<?= $desc; ?>" id="<?= $desc; ?>" class="form-control" value="<?= $album->{$adesc}; ?>" required autofocus>

  <br>

  <button class="btn btn-small btn-primary" type="submit" id="updatebutton" onclick="updateAlbum()">Update Album</button>
  <a href="<?= base_url(); ?><?= $main; ?>/deletealbum/<?= $album->$aid; ?>" class="btn btn-small btn-danger float-right">Delete Album</a><br>

</form>

<br>

<span class="border-top my-3"></span>


<div class="row">
  <div class="col-md-12">
    <table class="table table-striped" style="table-layout:fixed">
      <thead>
        <tr>
          <th style='display:none;'>ID</th>
          <th>Priority</th>
          <th>Name</th>
          <th>Description</th>
          <!-- <th>Brand ID</th> -->
          <th width="120px">Thumbnail</th>
          <th>Clicks</th>
          <th>Impressions</th>
          <th>Time</th>
          <th>Active</th>
          <th>Last Modified</th>
          <th>Date Created</th>
          <th width="150px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!(array) $images) : ?>
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
          <?php if (isset($images->item->item)) : ?>
            <?php foreach ($images->item->item as $image) : ?>
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
              $image = $images->item;
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
  </div><!-- /.col-md-12 -->
</div>

<div class="row">
  <div class="col-md-6">
    <?php if ($archived == 0) : ?>
      <a class="btn btn-primary" href="<?= base_url("$main/addimageglobal/") . $album->$aid; ?>">Add Media</a>
      <a class="btn btn-secondary" href="<?= base_url("$main/viewalbumglobal/") . $album->$aid . "/1"; ?>">View Archived Media</a>
    <?php else : ?>
      <a class="btn btn-secondary" href="<?= base_url("$main/viewalbumglobal/") . $album->$aid; ?>">Back</a>
    <?php endif; ?>
  </div>
</div>

<!-- bootstrap modal where the image will appear -->
<div class="modal fade" id="mediamodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <img id="mediapreview">
      </div>
    </div>
  </div>
</div>

<!-- bootstrap modal where the video will appear -->
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

<script>
  const Toast = Swal.mixin({
    toast: true,
    showConfirmButton: false,
    timer: 3000,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  function updateAlbum() {
    document.getElementById("updatebutton").innerHTML = "Updating...";
  }

  <?php if ($archived == 0) : ?>

    // Toggle media active status
    function setMediaActiveStatus(imageId) {
      $.ajax({
        url: "<?= site_url("main/setimageactivestatus/"); ?>" + imageId,
        type: 'GET',
        success: function(status) {
          Toast.fire({
            icon: 'success',
            title: 'Saved'
          })
        },
        contentType: "application/text",
        dataType: "text",
        error: function() {
          Toast.fire({
            icon: 'error',
            title: 'Error'
          })
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
          updateMediaPriorities(data)
        }
      })
    });

    // update media priorities
    function updateMediaPriorities(data) {
      Swal.fire({
        toast: true,
        title: 'Do you want to save the changes?',
        confirmButtonText: 'Save',
        showCancelButton: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: "<?= site_url("main/updatemediapriorities"); ?>",
            data: {
              "mediapriorities": data
            },
            contentType: "application/x-www-form-urlencoded",
            datatype: 'json',
            success: function(status) {
              Toast.fire({
                icon: 'success',
                title: 'Saved'
              })
            },
            error: function() {
              Swal.fire('Unable to make changes!', '', 'error')
            }
          });
        } else if (result.isDismissed) {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })
    }

  <?php endif; ?>

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
      Swal.fire({
        title: 'Do you want to save the changes?',
        confirmButtonText: 'Save',
        showCancelButton: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url("main/updatemediaduration/"); ?>" + mediaId + "/" + duration,
            type: 'GET',
            success: function(status) {
              Swal.fire('Saved!', '', 'success')
            },
            error: function() {
              Swal.fire('Unable to make changes!', '', 'error')
            }
          });
        } else if (result.isDismissed) {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })
    } else {
      Swal.fire('Duration must be between 1 to 300 seconds!', '', 'info')
    }
  }
</script>

<!-- End viewalbum.php -->