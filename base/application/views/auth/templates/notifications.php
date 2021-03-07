<?php if ($this->session->flashdata('error')) : ?>
    <div class="m-form__content">
        <div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
            <div class="m-alert__icon">
                <i class="la la-warning"></i>
            </div>
            <div class="m-alert__text">
                <?= $this->session->flashdata('error') ?>
            </div>
            <div class="m-alert__close">
                <button type="button" class="close" data-close="alert" aria-label="Close">
                </button>
            </div>
        </div>
    </div>
<?php elseif (validation_errors() or $this->session->flashdata('alert')) : ?>
    <div class="m-form__content">
        <div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
            <div class="m-alert__icon">
                <i class="la la-warning"></i>
            </div>
            <div class="m-alert__text">
                <?= validation_errors() ?>
                <?= $this->session->flashdata('alert') ?>
            </div>
            <div class="m-alert__close">
                <button type="button" class="close" data-close="alert" aria-label="Close">
                </button>
            </div>
        </div>
    </div>
<?php elseif ($this->session->flashdata('success')) : ?>
    <div class="m-form__content">
        <div class="m-alert m-alert--icon alert alert-success m--show" role="alert">
            <div class="m-alert__icon">
                <i class="la la-check"></i>
            </div>
            <div class="m-alert__text">
                <?= $this->session->flashdata('success') ?>
            </div>
            <div class="m-alert__close">
                <button type="button" class="close" data-close="alert" aria-label="Close">
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="m-form__content">
    <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_msg">
        <div class="m-alert__icon">
            <i class="la la-warning"></i>
        </div>
        <div class="m-alert__text">
            There are some errors found in the form, please check and try submitting again!
        </div>
        <div class="m-alert__close">
            <button type="button" class="close" data-close="alert" aria-label="Close">
            </button>
        </div>
    </div>
</div>