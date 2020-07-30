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

$alb_umbrella = $this->config->item('album_umbrella');
$alb_field    = $this->config->item('album_field');

if ($albumtype === $alb_umbrella) {
  $keyword = $umbrella;
} elseif ($albumtype === $alb_field) {
  $keyword = $field;
}

?>

<div class="page-header">
  <?php if ($albumtype === $alb_umbrella) : ?>
    <h1><?= ucwords($albumtype); ?> Media for <?= ucwords($umbrella); ?></h1>
  <?php elseif ($albumtype === $alb_field) : ?>
    <h1><?= ucwords($albumtype); ?> Media for <?= ucwords($field); ?></h1>
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
          <th>Thumbnail</th>
          <th>Clicks</th>
          <th>Impressions</th>
          <th>Time</th>
          <th>Active</th>
          <th width="150px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (sizeof($mediaboxa_images['vals']) <= 10) {
          echo '<tr>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td style=\'text-align:right\'>No Media</td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo  '<td></td>';
          echo '</tr>';
        } else {
          $arr = $mediaboxa_images;

          // initialize the HTML storage variable and the images storage array
          $mediaboxa_images = array();

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
              $mediaboxa_images = array();
            }

            // Add the element to the data array if the right element
            if ($val['type'] == 'complete' && $val['level'] == $level + 1) {
              $value = (isset($val['value']) ? $val['value'] : 'unknown');
              $mediaboxa_images[strtolower($val['tag'])] = $value;
            }

            // On the </item>, build the html
            if ($val['tag'] == $word && $val['type'] == 'close' && $val['level'] == $level) {

              // check if the media is a video (only mp4 format)
              $is_video = substr(strtolower($images[$ifile]), -3) == 'mp4' ? 1 : 0;

              echo  "<tr style='cursor: grab;'>" . PHP_EOL;
              echo  "<td style='display: none'>$mediaboxa_images[$iid]</td>" . PHP_EOL;
              echo  "<td>$mediaboxa_images[$ipriority]</td>" . PHP_EOL;
              echo  "<td>$mediaboxa_images[$ititle]</td>" . PHP_EOL;
              echo  "<td>$mediaboxa_images[$idesc]</td>" . PHP_EOL;
              echo  '<td>' . PHP_EOL;
              if ($is_video) {
                echo '<i title="Video" class="fas fa-video"></i>';
              } else {
                echo '<img src="' . $mediaboxa_images[$ifile] . '" alt="No Media" id="image_' . $mediaboxa_images[$iid] . '" class="' . $css . '">' . PHP_EOL;
              }
              echo  '</td>' . PHP_EOL;
              echo  "<td>$mediaboxa_images[$iclicks]</td>" . PHP_EOL;
              echo  "<td>$mediaboxa_images[$iimp]</td>" . PHP_EOL;
              echo  '<td>' . PHP_EOL;
        ?>
              <input type="number" onchange="updateMediaDuration(<?= $mediaboxa_images[$iid] ?>,$(this).val())" value=<?= $mediaboxa_images[$iduration] ?> style="width:60%">
              <?php
              echo  '</td>' . PHP_EOL;
              echo  '<td>' . PHP_EOL;
              if ($mediaboxa_images[$istatus] == 1) : ?>
                <label class="switch"><input type="checkbox" onclick="toggleMediaStatus(<?= $mediaboxa_images[$iid] ?>)" checked><span class="slider round"></span></label>
              <?php else : ?>
                <label class="switch"><input type="checkbox" onclick="toggleMediaStatus(<?= $mediaboxa_images[$iid] ?>)"><span class="slider round"></span></label>
              <?php endif;
              echo  '<td>' . PHP_EOL;
              ?>
              <a href="#" onclick="viewMedia('<?= $mediaboxa_images[$ifile] ?>',<?= $is_video ?>);" title="View Media" class="fas fa-eye"></a>&nbsp;
        <?php
              echo '&nbsp;';
              echo '&nbsp;';
              echo   '<a href="' . base_url("$main/editimageglobal") . '/' . $mediaboxa_images[$iid] . '" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;' . PHP_EOL;
              echo '&nbsp;';
              echo '&nbsp;';
              echo   '<a href="' . base_url("$main/deleteimageglobal") . '/' . $mediaboxa_images[$iid] . '" title="Archive Media" class="fas fa-archive"></a>&nbsp;' . PHP_EOL;
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
            <th>Thumbnail</th>
            <th>Clicks</th>
            <th>Impressions</th>
            <th>Time</th>
            <th>Active</th>
            <th width="150px">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (sizeof($mediaboxu_images['vals']) <= 10) {
            echo '<tr>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td style=\'text-align:right\'>No Media</td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo '</tr>';
          } else {
            $arr = $mediaboxu_images;

            // initialize the HTML storage variable and the images storage array
            $mediaboxu_images = array();

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
                $mediaboxu_images = array();
              }

              // Add the element to the data array if the right element
              if ($val['type'] == 'complete' && $val['level'] == $level + 1) {
                $value = (isset($val['value']) ? $val['value'] : 'unknown');
                $mediaboxu_images[strtolower($val['tag'])] = $value;
              }

              // On the </item>, build the html
              if ($val['tag'] == $word && $val['type'] == 'close' && $val['level'] == $level) {

                // check if the media is a video (only mp4 format)
                $is_video = substr(strtolower($images[$ifile]), -3) == 'mp4' ? 1 : 0;

                echo '<tr>' . PHP_EOL;
                echo  "<tr style='cursor: grab;'>" . PHP_EOL;
                echo  "<td style='display: none'>$mediaboxu_images[$iid]</td>" . PHP_EOL;
                echo  "<td>$mediaboxu_images[$ipriority]</td>" . PHP_EOL;
                echo  "<td>$mediaboxu_images[$ititle]</td>" . PHP_EOL;
                echo  "<td>$mediaboxu_images[$idesc]</td>" . PHP_EOL;
                echo  '<td>' . PHP_EOL;
                if ($is_video) {
                  echo '<i title="Video" class="fas fa-video"></i>';
                } else {
                  echo '<img src="' . $mediaboxu_images[$ifile] . '" alt="No Media" id="image_' . $mediaboxu_images[$iid] . '" class="' . $css . '">' . PHP_EOL;
                }
                echo  '</td>' . PHP_EOL;
                echo  "<td>$mediaboxu_images[$iclicks]</td>" . PHP_EOL;
                echo  "<td>$mediaboxu_images[$iimp]</td>" . PHP_EOL;
                echo  '<td>' . PHP_EOL;
          ?>
                <input type="number" onchange="updateMediaDuration(<?= $mediaboxu_images[$iid] ?>,$(this).val())" value=<?= $mediaboxu_images[$iduration] ?> style="width:60%">
                <?php
                echo  '</td>' . PHP_EOL;
                echo  '<td>' . PHP_EOL;
                if ($mediaboxu_images[$istatus] == 1) : ?>
                  <label class="switch"><input type="checkbox" onclick="toggleMediaStatus(<?= $mediaboxu_images[$iid] ?>)" checked><span class="slider round"></span></label>
                <?php else : ?>
                  <label class="switch"><input type="checkbox" onclick="toggleMediaStatus(<?= $mediaboxu_images[$iid] ?>)"><span class="slider round"></span></label>
                <?php endif;
                echo  '</td>' . PHP_EOL;
                echo  '<td>' . PHP_EOL;
                ?>
                <a href="#" onclick="viewMedia('<?= $mediaboxu_images[$ifile] ?>',<?= $is_video ?>);" title="View Media" class="fas fa-eye"></a>&nbsp;
          <?php
                echo '&nbsp;';
                echo '&nbsp;';
                echo   '<a href="' . base_url("$main/editimageglobal") . '/' . $mediaboxu_images[$iid] . '" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;' . PHP_EOL;
                echo '&nbsp;';
                echo '&nbsp;';
                echo   '<a href="' . base_url("$main/deleteimageglobal") . '/' . $mediaboxu_images[$iid] . '" title="Delete Media" class="fas fa-trash-alt"></a>&nbsp;' . PHP_EOL;
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
            <th>Thumbnail</th>
            <th>Clicks</th>
            <th>Impressions</th>
            <th>Time</th>
            <th>Active</th>
            <th width="150px">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (sizeof($mediaboxb_images['vals']) <= 10) {
            echo '<tr>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td style=\'text-align:right\'>No Media</td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo  '<td></td>';
            echo '</tr>';
          } else {
            $arr = $mediaboxb_images;

            // initialize the HTML storage variable and the images storage array
            $mediaboxu_images = array();

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
                $mediaboxb_images = array();
              }

              // Add the element to the data array if the right element
              if ($val['type'] == 'complete' && $val['level'] == $level + 1) {
                $value = (isset($val['value']) ? $val['value'] : 'unknown');
                $mediaboxb_images[strtolower($val['tag'])] = $value;
              }

              // On the </item>, build the html
              if ($val['tag'] == $word && $val['type'] == 'close' && $val['level'] == $level) {

                // check if the media is a video (only mp4 format)
                $is_video = substr(strtolower($images[$ifile]), -3) == 'mp4' ? 1 : 0;

                echo '<tr>' . PHP_EOL;
                echo  "<tr style='cursor: grab;'>" . PHP_EOL;
                echo  "<td style='display: none'>$mediaboxb_images[$iid]</td>" . PHP_EOL;
                echo  "<td>$mediaboxb_images[$ipriority]</td>" . PHP_EOL;
                echo  "<td>$mediaboxb_images[$ititle]</td>" . PHP_EOL;
                echo  "<td>$mediaboxb_images[$idesc]</td>" . PHP_EOL;
                echo  '<td>' . PHP_EOL;
                if ($is_video) {
                  echo '<i title="Video" class="fas fa-video"></i>';
                } else {
                  echo '<img src="' . $mediaboxb_images[$ifile] . '" alt="No Media" id="image_' . $mediaboxb_images[$iid] . '" class="' . $css . '">' . PHP_EOL;
                }
                echo  '</td>' . PHP_EOL;
                echo  "<td>$mediaboxb_images[$iclicks]</td>" . PHP_EOL;
                echo  "<td>$mediaboxb_images[$iimp]</td>" . PHP_EOL;
                echo  '<td>' . PHP_EOL;
          ?>
                <input type="number" onchange="updateMediaDuration(<?= $mediaboxb_images[$iid] ?>,$(this).val())" value=<?= $mediaboxb_images[$iduration] ?> style="width:60%">
                <?php
                echo  '</td>' . PHP_EOL;
                echo  '<td>' . PHP_EOL;
                if ($mediaboxb_images[$istatus] == 1) : ?>
                  <label class="switch"><input type="checkbox" onclick="toggleMediaStatus(<?= $mediaboxb_images[$iid] ?>)" checked><span class="slider round"></span></label>
                <?php else : ?>
                  <label class="switch"><input type="checkbox" onclick="toggleMediaStatus(<?= $mediaboxb_images[$iid] ?>)"><span class="slider round"></span></label>
                <?php endif;
                echo  '</td>' . PHP_EOL;
                echo  '<td>' . PHP_EOL;
                ?>
                <a href="#" onclick="viewMedia('<?= $mediaboxb_images[$ifile] ?>',<?= $is_video ?>);" title="View Media" class="fas fa-eye"></a>&nbsp;
          <?php
                echo '&nbsp;';
                echo '&nbsp;';
                echo   '<a href="' . base_url("$main/editimageglobal") . '/' . $mediaboxb_images[$iid] . '" title="Edit Media Details" class="fas fa-edit"></a>&nbsp;' . PHP_EOL;
                echo '&nbsp;';
                echo '&nbsp;';
                echo   '<a href="' . base_url("$main/deleteimageglobal") . '/' . $mediaboxb_images[$iid] . '" title="Delete Media" class="fas fa-trash-alt"></a>&nbsp;' . PHP_EOL;
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