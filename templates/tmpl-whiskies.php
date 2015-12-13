<?php $this->layout( 'tmpl-page', [ 'title' => 'Whichsky Whiskies' ] ) ?>

<div class="pure-u-1-1">
    <h1>This page will list your taste/purchased/etc whiskies.</h1>

    <?php if ( $th && $whiskies ) : ?>
    <table class="pure-table pure-table-horizontal pure-table-striped">
        <thead><tr>
        <?php foreach ($th as $head) : ?>
            <th><?= $this->e( $head ) ?></th>
        <?php endforeach ?>
        </tr></thead>
        <?php foreach ($whiskies as $whisky) : ?>
        <tr>
            <?php foreach ($whisky as $sip) : ?>
                <td><?= $this->e( $sip ) ?></td>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>
    </table>
    <?php else : ?>
        <p>No whiskies to display</p>
    <?php endif; ?>
</div>
