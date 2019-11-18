<!DOCTYPE html>
<html lang="en">

  <!-- We let the header know what page we are on to set the title -->
  <?php $this -> view( 'base/head', $head ); ?>

  <body role="document" role="main">

    <?php $this -> view( 'base/nav' ); ?>

      <br>

      <div class="container">

        <br>

        <?php $this -> view( $file, $data ); ?>

        <br>

      </div><!-- /.container -->

    <?php $this -> view( 'base/foot', $foot ); ?>

    </body>
</html>
