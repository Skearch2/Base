<!-- Start home.php -->
  <?php
    $main   = $this -> config -> item('main_class');

    $global = $this -> config -> item('album_default');
    $global = $this -> config -> item('album_global');
    $umbrella = $this -> config -> item('album_umbrella');
    $field = $this -> config -> item('album_field');

    $aid      = $this -> config -> item('imageserver_field_album_id');
    $atitle   = $this -> config -> item('imageserver_field_album_title');
    $adesc    = $this -> config -> item('imageserver_field_album_description');
    $atype    = $this -> config -> item('imageserver_field_album_type');
    $atypeid  = $this -> config -> item('imageserver_field_album_type_id');

    $edit   = $this -> config -> item('edit_icon');
    $delete = $this -> config -> item('delete_icon');
    $img    = $this -> config -> item('image_icon');

   ?>

   <style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

li {
  display: flex;
}
</style>
      <div class="jumbotron">
        <h1>Welcome!</h1>
        <p>Welcome to the Skearch Media Engine. Here, you can manage your media.</p>
      </div>

      <ul>
            <li style="float:left">
                  <div class="page-header">
                    <h1>Default Media</h1>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="dropdown show">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          View Defaults
                        </a>
                        <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuLink" role=menu>
                            <?php
                              if ( sizeof($albums_default['vals']) == 1 ) {
                                echo "<a class='dropdown-item' href='#'>No albums</a>";
                              } else {
                                $arr = $albums_default;
                            		// initialize the storage variables
                            		$html = '';
                            		$albums_default = array();
                            		foreach ( $arr['vals'] as $val ) {
                            			// Initialize the data array if on a <item> element
                            			if ( $val['tag'] == 'ITEM' && $val['type'] == 'open' && $val['level'] == 2 ) {
                            				$albums_default = array();
                            			}

                            			// Add the element to the data array if the right element
                            			if ( $val['type'] == 'complete' && $val['level'] == 3 ) {
                            				$value = ( isset( $val['value'] ) ? $val['value'] : 'unknown' );
                            				$albums_default[strtolower($val['tag'])] = $value;
                            			}

                            			// On the </item>, build the html
                            			if ( $val['tag'] == 'ITEM' && $val['type'] == 'close' && $val['level'] == 2 ) {
                            				$albumid = $albums_default[$aid];
                            				//$anchor = '<a href="'. base_url( "$main/setdefault/$albumid" ) . '" class="btn btn-sm ' . ( $albumid == $default ? 'disabled' : 'btn-primary' ) . '">Set</a>';
                                  ?>
                                    <a class="dropdown-item" href="<?= site_url("$main/viewalbumglobal/$albums_default[$aid]"); ?>"><?= $albums_default[$atitle]; ?></a>
                            			<?php
                                  }
                                }
                          		}
                             ?>
                       </div>
                     </div>
                   </div></div>
           </li>

           <li style="float:right">
                 <div class="page-header">
                   <h1>Global Media</h1>
                 </div>

                 <div class="row">
                   <div class="col-md-6">
                     <div class="dropdown show">
                       <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         View Globals
                       </a>
                       <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuLink" role=menu>
                           <?php
                             if ( sizeof($albums_global['vals']) == 1 ) {
                               echo "<a class='dropdown-item' href='#'>No albums</a>";
                             } else {
                               $arr = $albums_global;
                               // initialize the storage variables
                               $html = '';
                               $albums_global = array();
                               foreach ( $arr['vals'] as $val ) {
                                 // Initialize the data array if on a <item> element
                                 if ( $val['tag'] == 'ITEM' && $val['type'] == 'open' && $val['level'] == 2 ) {
                                   $albums_global = array();
                                 }

                                 // Add the element to the data array if the right element
                                 if ( $val['type'] == 'complete' && $val['level'] == 3 ) {
                                   $value = ( isset( $val['value'] ) ? $val['value'] : 'unknown' );
                                   $albums_global[strtolower($val['tag'])] = $value;
                                 }

                                 // On the </item>, build the html
                                 if ( $val['tag'] == 'ITEM' && $val['type'] == 'close' && $val['level'] == 2 ) {
                                   $albumid = $albums_global[$aid];
                                   //$anchor = '<a href="'. base_url( "$main/setdefault/$albumid" ) . '" class="btn btn-sm ' . ( $albumid == $default ? 'disabled' : 'btn-primary' ) . '">Set</a>';
                                 ?>
                                   <a class="dropdown-item" href="<?= site_url("$main/viewalbumglobal/$albums_global[$aid]"); ?>"><?= $albums_global[$atitle]; ?></a>
                                 <?php
                                 }
                               }
                             }
                            ?>
                      </div>
                    </div>
                  </div>
                 </div>
           </li>
      </ul>



      <div class="row">
        <div class="col-md-6">
          <?= '<a class="btn btn-secondary" href="' . base_url("$main/addalbum/") . '">Add Album</a>'; ?>
        </div>
      </div>

      <br>
      <br>

      <ul>
          <li style="float:left">
              <div class="page-header">
                <h1>Field Media</h1>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="dropdown show" >
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      View Fields
                    </a>

                    <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuLink" role=menu>
                      <?php foreach($fields as $f) : ?>
                        <a class="dropdown-item" href="<?= site_url("$main/viewalbum/$field/$f->id"); ?>"><?= $f->title; ?></a>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
          </li>

          <li style="float:right">
              <div class="page-header">
                <h1>Umbrella Media</h1>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="dropdown show">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      View Umbrellas
                    </a>

                    <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuLink" role=menu>
                      <?php foreach($umbrellas as $u) : ?>
                        <a class="dropdown-item" href="<?= site_url("$main/viewalbum/$umbrella/$u->id"); ?>"><?= $u->title; ?></a>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
          </li>
      </ul>
