<?php

// Set DocType and declare HTML protocol
$this->load->view('frontend/templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('frontend/templates/head');

// Start body element
$this->load->view('frontend/templates/startbody');

// Load appropriate header (logged in, admin options, etc.)
$this->load->view('frontend/templates/header');

?>

<!-- Display All Umbrellas and its fields -->
<section class="field-main">
    <div class="container">
        <div class="row">
            <div class="main-box">
                <div class="box">
                    <h3>Tips</h3>
                </div>
                <div class="middle-inner browse-inner table-responsive">
                    <?php if (empty($crypto_wallets)) : ?>
                        There are no crypto wallets listed to receive tips.
                    <?php else : ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Wallet Address</th>
                                    <th scope=" col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($crypto_wallets as $wallet) : ?>
                                    <tr>
                                        <th class="lead" scope="row">
                                            <pre><?= $wallet->coin_name ?></pre>
                                        </th>
                                        <td class="lead">
                                            <pre><?= $wallet->coin_wallet_address ?></pre>
                                        </td>
                                        <td><button type="button" class="btn btn-default fa fa-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy=<?= $wallet->coin_wallet_address ?> title="Copy to clipboard"></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

// Load default footer.
$this->load->view('frontend/templates/footer');
?>

<!-- Page Scripts -->
<script>
    function copyToClipboard(text, element) {
        var copyTest = document.queryCommandSupported('copy');
        var elOriginalText = element.attr('data-original-title');

        if (copyTest === true) {
            var copyTextArea = document.createElement("textarea");
            copyTextArea.value = text;
            document.body.appendChild(copyTextArea);
            copyTextArea.select();
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'Copied!' : 'Whoops, not copied!';
                element.attr('data-original-title', msg).tooltip('show');
            } catch (err) {
                console.log('Unable to copy');
            }
            document.body.removeChild(copyTextArea);
            element.attr('data-original-title', elOriginalText);
        } else {
            // Fallback if browser doesn't support .execCommand('copy')
            window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
        }
    }

    $(document).ready(function() {
        $('.js-tooltip').tooltip();
        $('.js-copy').click(function() {
            var text = $(this).attr('data-copy');
            var element = $(this);
            copyToClipboard(text, element);
        });
    });
</script>

<?php

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>