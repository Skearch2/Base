<?php if (validation_errors() OR $this->ion_auth->errors() OR $this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <?= validation_errors(); ?>
        <?= $this->ion_auth->errors(); ?>
        <?= $this->session->flashdata('error') ?>					  					  						  	
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('alert')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <?= $this->session->flashdata('alert'); ?>					  	
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <?= $this->session->flashdata('success'); ?>					  	
    </div>
<?php endif; ?>