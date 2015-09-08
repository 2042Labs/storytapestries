<?php

require_once( CRP_CLASSES_DIR_PATH.'/CRPDashboardListTable.php');

//Create an instance of our package class...
$listTable = new CRPDashboardListTable();
$listTable->prepare_items();

?>

<div id="crp-dashboard-wrapper">
    <div id = "crp-dashboard-add-new-wrapper">
        <a id = "add-portfolio-button" class='button-secondary add-portfolio-button' href="<?php echo "?page={$crp_adminPage}&action=create" ?>" title='Add New'>+ Add New Portfolio</a>
    </div>

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $crp_adminPage ?>" />
        <!-- Now we can render the completed list table -->
        <?php $listTable->display() ?>
    </form>

</div>