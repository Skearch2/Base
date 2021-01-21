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
        <?php
        if (sizeof($images['vals']) <= 10) {
          echo '<tr>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          // echo  '<td></td>';
          echo  '<td style=\'text-align:right\'>No Media</td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo '</tr>';
        } else {
          $arr = $images;

          // initialize the HTML storage variable and the images storage array
          $images = array();

          if (sizeof($arr['index']['ITEM']) == 2) {
            $word = 'IMAGE';
            $level = 4;
          } else {
            $word = 'ITEM';
            $level = 5;
          }

          foreach ($arr['vals'] as $val) {

            // Initialize the data array if on a <item> element
            if ($val['tag'] == $word && $val['type'] == 'open' && $val['level'] == $level) {
              $images = array();
            }

            // Add the element to the data array if the right element
            if ($val['type'] == 'complete' && $val['level'] == $level + 1) {
              $value = (isset($val['value']) ? $val['value'] : 'unknown');
              $images[strtolower($val['tag'])] = $value;
            }

            // On the </item>, build the html
            if ($val['tag'] == $word && $val['type'] == 'close' && $val['level'] == $level) {
              // check if the media is a video (only mp4 format)
              $is_video = substr(strtolower($images[$ifile]), -3) == 'mp4' ? 1 : 0;

              echo ($archived == 0 ? "<tr style='cursor: grab;'>" : "<tr>") . PHP_EOL;
              echo  "<td style='display: none'>$images[$iid]</td>" . PHP_EOL;
              echo  "<td>$images[$ipriority]</td>" . PHP_EOL;
              echo  "<td>$images[$ititle]</td>" . PHP_EOL;
              echo  "<td>$images[$idesc]</td>" . PHP_EOL;
              // echo  "<td>$images[$ibrandid]</td>" . PHP_EOL;
              echo  '<td>' . PHP_EOL;
              if ($is_video) {
                echo '<i title="Video" class="fas fa-video"></i>';
              } else {
                echo '<img src="' . $images[$ifile] . '" alt="No Media" id="image_' . $images[$iid] . '" class="' . $css . '">' . PHP_EOL;
              }
              echo  '</td>' . PHP_EOL;
              echo  "<td>$images[$iclicks]</td>" . PHP_EOL;
              echo  "<td>$images[$iimp]</td>" . PHP_EOL;
              echo  '<td>' . PHP_EOL;
        ?>
              <input type="number" onchange="updateMediaDuration(<?= $images[$iid] ?>,$(this).val())" value=<?= $images[$iduration] ?> style="width:60%">
              <?php
              echo  '</td>' . PHP_EOL;
              echo  '<td>' . PHP_EOL;
              if ($images[$istatus] == 1) : ?>
                <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $images[$iid] ?>)" checked <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
              <?php else : ?>
                <label class="switch"><input type="checkbox" onclick="setMediaActiveStatus(<?= $images[$iid] ?>)" <?= ($archived == 0 ?: 'disabled'); ?>><span class="slider round"></span></label>
              <?php endif;
              echo  "<td>$images[$idate_modified]</td>" . PHP_EOL;
              echo  "<td>$images[$idate_created]</td>" . PHP_EOL;
              echo  '</td>' . PHP_EOL;
              echo  '<td>' . PHP_EOL;
              ?>
              <a href="#" onclick="viewMedia('<?= $images[$ifile] ?>',<?= $is_video ?>)" title="View Media" class="fas fa-eye"></a>&nbsp;

        <?php
              echo '&nbsp;';
              echo '&nbsp;';
              echo   '<a href="' . base_url("$main/editimageglobal") . '/' . $images[$iid] . '" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;' . PHP_EOL;
              echo '&nbsp;';
              echo '&nbsp;';
              if ($archived == 0) {
                echo   '<a href="' . base_url("$main/archiveimageglobal") . '/' . $images[$iid] . '" title="Archive Media" class="fas fa-archive"></a>&nbsp;' . PHP_EOL;
              } else {
                echo '<a href="' . base_url("$main/archiveimageglobal") . '/' . $images[$iid] . '" title="Restore Media" class="fas fa-undo-alt"></a>&nbsp;' . PHP_EOL;
                echo '&nbsp;';
                echo '&nbsp;';
                echo '<a href="' . base_url("$main/deleteimageglobal") . '/' . $images[$iid] . '" title="Delete Media" class="fas fa-trash"></a>&nbsp;' . PHP_EOL;
              }
              echo  '</td>' . PHP_EOL;
              echo '</tr>' . PHP_EOL;
            }
          }
        }
        ?>
      </tbody>
    </table>
  </div><!-- /.col-md-6 -->
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
          console.log("Success updating priorities")
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Unable to update priorities");
        }
      });
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