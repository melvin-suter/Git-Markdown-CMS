<html>
    <head>
        <title>Some Page - <?=$page->meta['title'];?></title>
    </head>
    <body>
    <!-- Page Naviagtion -->
    <?= $app->viewer->generateMenuList($page->menu);?>
