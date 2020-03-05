<?= $header; ?>
<!-- CONTENT
=================================-->
<?php $totSegments = $this->uri->total_segments();
if (!is_numeric($this->uri->segment($totSegments))) {
	$offset = 0;
} else if (is_numeric($this->uri->segment($totSegments))) {
	$offset = $this->uri->segment($totSegments);
}
$limit = 1;
?>

<div class="container content-padding">
	<?php echo $page['pageContentHTML']; ?>
	<div class="row">
		<div class="col-md-3">
			<div class="row">
				<div class="col-md-12">
					<h3>Latest News:</h3><?php getLatestNewsSidebar(); ?>
				</div>
				<!-- <div class="col-md-12"><h3>Categories:</h3><?php getCategories(); ?></div> -->
			</div>
		</div>
		<div class="col-md-9">
			<div class="news-boxes">
				<?php getLatestNews($limit, $offset); ?>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php getPrevBtn($limit, $offset); ?>
					<?php getNextBtn($limit, $offset); ?>
				</div>
			</div>
			<div class="col-md-12 text-center">
				<p class="meta"><?php countPosts($limit, $offset); ?></p>
			</div>
		</div>
	</div>
</div>
<!-- /CONTENT ============-->

<?php echo $footer; ?>