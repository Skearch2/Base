<?php if ($this->session->flashdata('error')) : ?>
    <div align="center" class="alert alert-danger alert-dismissible fade show m-alert m-alert--air m-alert--outline">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>
<?php if (validation_errors() or $this->session->flashdata('alert')) : ?>
    <div align="center" class="alert alert-warning alert-dismissible fade show m-alert m-alert--air m-alert--outline">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
        <?= validation_errors() ?>
        <?= $this->session->flashdata('alert') ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')) : ?>
    <div align="center" class="alert alert-success alert-dismissible fade show m-alert m-alert--air m-alert--outline">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>