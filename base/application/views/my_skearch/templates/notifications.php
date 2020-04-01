<?php if ($this->session->flashdata('error')) : ?>
    <div align="center" class="m-alert m-alert--outline alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>
<?php if (validation_errors() or $this->session->flashdata('alert')) : ?>
    <div align="center" class="m-alert m-alert--outline alert-warning">
        <?= validation_errors() ?>
        <?= $this->session->flashdata('alert') ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('success')) : ?>
    <div align="center" class="m-alert m-alert--outline alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>