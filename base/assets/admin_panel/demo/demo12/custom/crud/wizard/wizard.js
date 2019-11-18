var WizardDemo = function () {
    $("#m_wizard");
    var e,
        r,
        i = $("#m_form");
    return {
        init: function () {
            var n;
            $("#m_wizard"),
                i = $("#m_form"),
                (r = new mWizard("m_wizard", {
                    startStep: 1
                }
                )).on("beforeNext", function (r) {
                    !0 !== e.form() && r.stop()
                }
                ),
                r.on("change", function (e) {
                    mUtil.scrollTop()
                }
                ),
                e = i.validate({
                    ignore: ":hidden", rules: {
                        selectpicker: {
                            required: !0
                        }
                        , summernote: {
                            required: !0
                        }
                        , subject: {
                            required: !0, minlength: 8
                        }
                        , textarea: {
                            required: !0
                        }
                        , accept: {
                            required: !0
                        }
                    }
                    , messages: {

                        accept: {
                            required: "You must accept the Terms and Conditions agreement!"
                        }
                    }
                    , invalidHandler: function (e, r) {
                        mUtil.scrollTop(), swal({
                            title: "", text: "There are some errors in your submission. Please correct them.", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        }
                        )
                    }
                    , submitHandler: function (e) { }
                }
                ),
                (n = i.find('[data-wizard-action="submit"]')).on("click", function (r) {
                    r.preventDefault(), e.form() && (mApp.progress(n), i.ajaxSubmit({
                        success: function () {
                            mApp.unprogress(n), swal({
                                title: "", text: "The application has been successfully submitted!", type: "success", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                            }
                            )
                        }
                    }
                    ))
                }
                )
        }
    }
}

    ();
jQuery(document).ready(function () {
    WizardDemo.init()
}

);