<?php $this->layout( 'tmpl-page', [ 'title' => 'Whichsky Whiskies' ] ) ?>

<div class="pure-u-1-1">
    <h1>This page will list your taste/purchased/etc whiskies.</h1>

    <ul>
        <?php
        foreach ($whiskies as $sip) {
            echo '<li>' . $this->e( $sip ) . '</li>';
        }
        ?>
    </ul>
</div>
