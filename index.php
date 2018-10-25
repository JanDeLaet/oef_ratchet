<?php

include_once('./classes/PageBuilder.php');


$page=new PageBuilder();

?>

    <head>
        <?php echo $page->printHead();?>
    </head>

    <body>
        <div class="col col-md-6">
            <div><?php echo $page->printToetsenbord();?></div>
        </div>
        <div class="col col-md-6">
            <div><?php echo $page->printZoekVeld();?></div>
            <div><?php echo $page->printResultaat();?></div>
        </div>
        <?php echo $page->printFooter();?>
    </body>
