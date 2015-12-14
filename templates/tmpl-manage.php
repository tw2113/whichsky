<?php $this->layout( 'tmpl-page', [ 'title' => 'Whichsky Whisky Management' ] ) ?>

<div class="pure-u-1-1">
    <h1>This page will be where you manage inventory.</h1>

    <?php if ( isset( $error ) ) : ?>
    <p>There was an error processing the whisky.</p>
    <?php endif; ?>

    <?= $form ?>
</div>
