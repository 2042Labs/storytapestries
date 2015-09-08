<?php
    global $crp_portfolio;

    //Setup ordered projects array
    $crp_portfolio->projects = getOrderedProjects($crp_portfolio);
?>


<?php
    //Validation goes here
    if($crp_portfolio) {
        require_once(CRP_FRONT_VIEWS_DIR_PATH . "/layouts/crp-front-tiled-layout-lightgallery.php");
    }else{
        echo "Ooooops!!! Short-code related portfolio wasn't found in your database!";
    }


function getOrderedProjects($crp_portfolio){
    $orderedProjects = array();

    if(isset($crp_portfolio->projects) && isset($crp_portfolio->corder)){
        foreach($crp_portfolio->corder as $pid){
            $orderedProjects[] = $crp_portfolio->projects[$pid];
        }
    }

    return $orderedProjects;
}
