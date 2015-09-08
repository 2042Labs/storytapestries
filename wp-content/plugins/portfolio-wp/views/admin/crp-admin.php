<div class="crp-background">
</div>
<div id="crp-wrap" class="crp-wrap">

<script>
    CRP_AJAX_URL = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
    CRP_IMAGES_URL = '<?php echo CRP_IMAGES_URL ?>';
</script>

<?php

abstract class CRPTabType{
    const Dashboard = 'dashboard';
    const Settings = 'settings';
    const Help = 'help';
    const Terms = 'terms';
}

$crp_tabs = array(
    CRPTabType::Dashboard => 'All Portfolios',
    CRPTabType::Settings => 'General Settings',
    CRPTabType::Help => 'User Manual',
);

$crp_adminPage = CRP_ADMIN_VIEWS_DIR_PATH.'/crp-admin.php';
$crp_currentTab = isset ( $_GET['tab'] ) ? $_GET['tab'] : CRPTabType::Dashboard;
$crp_action = isset ( $_GET['action'] ) ? $_GET['action'] : null;

include_once(CRP_ADMIN_VIEWS_DIR_PATH."/crp-admin-modal-spinner.php");
include_once(CRP_ADMIN_VIEWS_DIR_PATH."/crp-admin-header.php");

if($crp_action == 'create' || $crp_action == 'edit'){
    include_once(CRP_ADMIN_VIEWS_DIR_PATH."/crp-admin-portfolio.php");
}else if ($crp_action == 'options'){
    include_once(CRP_ADMIN_VIEWS_DIR_PATH."/crp-admin-portfolio-options.php");
}else{
    //Tabs are not fully developed yet, that's why we have disabled them in this version
    //crp_renderAdminTabs($crp_currentTab, $crp_adminPage, $crp_tabs);

    if($crp_currentTab == CRPTabType::Dashboard){
        include_once(CRP_ADMIN_VIEWS_DIR_PATH."/crp-admin-dashboard.php");
    }else if($crp_currentTab == CRPTabType::Settings){
        include_once(CRP_ADMIN_VIEWS_DIR_PATH."/crp-admin-settings.php");
    }else if($crp_currentTab == CRPTabType::Help){
        include_once(CRP_ADMIN_VIEWS_DIR_PATH."/crp-admin-help.php");
    }
}

function crp_renderAdminTabs( $current, $page, $tabs = array()){
    //Hardcoded style for removing dynamically added bottom-border
    echo '<h2 class="nav-tab-wrapper crp-admin-nav-tab-wrapper" style="border: 0px">';

    foreach ($tabs as $tab => $name) {
        $class = ($tab == $current) ? 'nav-tab-active' : '';
        echo "<a class='nav-tab $class' href='?page=$page&tab=$tab'>$name</a>";
    }
    echo '</h2>';
}

?>

</div>

