<!doctype html>
<!--[if lte IE 8]><html class="no-js ie7 lte8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if !(IE)]><html class="no-js" lang="en"><![endif]-->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $title; ?></title>
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" href="/templates/assets/css/style.css">
<body>
<div id="wrap" class="pure-g">
<header id="branding" role="banner" class="pure-u-1-1">
    <nav id="access" role="navigation">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/whiskies/">Whiskies</a></li>
            <li><a href="/wishlist/">Wishlist</a></li>
            <li><a href="/manage/">Manage</a></li>
            <li><a href="/options/">Options</a></li>
        </ul>
    </nav>
</header>

<?php echo $this->section('content'); ?>

<footer id="colophon" role="contentinfo" class="pure-u-1-1">
    <p><small>&copy;<?php echo date('Y'); ?> Whichsky</small> - <a href="/">Home</a> | <a href="/whiskies/">Whiskies</a> | <a href="/wishlist/">Wishlist</a> | <a href="/manage/">Manage</a> | <a href="/options/">Options</a>.</p>
</footer>
</div>
<script src="/templates/assets/js/whichsky.min.js"></script>
</body>
</html>
