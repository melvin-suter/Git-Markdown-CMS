<html>
    <head>
        <title>Some Page - <?=$page->meta['title'];?></title>
        <link href="<?=$app->sanitize->url('assets/style.css');?>" rel="stylesheet"/>
    </head>
    <body>
        <!-- Page Naviagtion -->
        <?= $app->viewer->generateMenuList($page->menu);?>
