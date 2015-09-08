<?php

function wp_ajax_crp_get_portfolio(){
    global $wpdb;
    $response = new stdClass();

    if(!isset($_GET['id'])){
        $response->status = 'error';
        $response->errormsg = 'Invalid portfolio identifier!';
        crp_ajax_return($response);
    }

    $pid = $_GET['id'];
    $query = @$wpdb->prepare("SELECT * FROM ".CRP_TABLE_PORTFOLIOS." WHERE id='{$pid}'");
    $res = $wpdb->get_results( $query , OBJECT );

    if(count($res)){
        $portfolio = $res[0];

        $query = @$wpdb->prepare("SELECT * FROM ".CRP_TABLE_PROJECTS." WHERE pid='{$pid}'");
        $res = $wpdb->get_results( $query , OBJECT );

        $projects = array();
        foreach($res as $project){
            if(!empty($project->categories)) {
                $project->categories = explode(',', $project->categories);
            } else {
                $project->categories = array();
            }

            $projects[$project->id] = $project;
        }
        $portfolio->projects = $projects;
        $portfolio->corder = explode(',',$portfolio->corder);
        $portfolio->options = json_decode( str_replace('\"', '"', $portfolio->options), true);

        $response->status = 'success';
        $response->portfolio = $portfolio;
    }else{
        $response->status = 'error';
        $response->errormsg = 'Unknown portfolio identifier!';
    }

    crp_ajax_return($response);
}

function wp_ajax_crp_save_portfolio() {
    global $wpdb;
    $response = new stdClass();

    if(!isset($_POST['portfolio'])){
        $response->status = 'error';
        $response->errormsg = 'Invalid portfolio passed!';
        crp_ajax_return($response);
    }

    //Convert to stdClass object
    $portfolio = json_decode( str_replace('\"','"',$_POST['portfolio']), true);
    $pid = isset($portfolio['id']) ? $portfolio['id'] : 0;
    $corder = isset($portfolio['corder']) ? implode(',',$portfolio['corder']) : "";

    //Insert if portfolio is draft yet
    if(isset($portfolio['isDraft']) && $portfolio['isDraft']){
        $title = isset($portfolio['title']) ? $portfolio['title'] : "";

        $wpdb->insert(
            CRP_TABLE_PORTFOLIOS,
            array(
                'title' => $title,
            ),
            array(
                '%s',
            )
        );

        //Get real identifier and use it instead of draft identifier for tmp usage
        $pid = $wpdb->insert_id;
    }

    $projects = isset($portfolio['projects']) ? $portfolio['projects'] : array();
    foreach($projects as $id => $project){

        $title = isset($project['title']) ? $project['title'] : "";
        $cover = isset($project['cover']) ? $project['cover'] : "";
        $description = isset($project['description']) ? $project['description'] : "";
        $url = isset($project['url']) ? $project['url'] : "";
        $pics = isset($project['pics']) ? $project['pics'] : "";
        $cats = isset($project['categories']) ? implode(',',$project['categories']) : "";

        if(isset($project['isDraft']) && $project['isDraft']){
            $wpdb->insert(
                CRP_TABLE_PROJECTS,
                array(
                    'title' => $title,
                    'pid' => $pid,
                    'cover' => $cover,
                    'description' => $description,
                    'url' => $url,
                    'pics' => $pics,
                    'categories' => $cats
                ),
                array(
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                )
            );

            $realProjId = $wpdb->insert_id;
            $corder = str_replace($id,$realProjId,$corder);
        }else{
            $wpdb->update(
                CRP_TABLE_PROJECTS,
                array(
                    'title' => $title,
                    'cover' => $cover,
                    'description' => $description,
                    'url' => $url,
                    'pics' => $pics,
                    'categories' => $cats
                ),
                array( 'id' => $id ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                ),
                array( '%d' )
            );
        }
    }

    $deletions = isset($portfolio['deletions']) ? $portfolio['deletions'] : array();
    foreach($deletions as $deletedProjectId) {
        // Default usage.
        $wpdb->delete( CRP_TABLE_PROJECTS, array( 'id' => $deletedProjectId ) );
    }

    $title = isset($portfolio['title']) ? $portfolio['title'] : "";
    $wpdb->update(
        CRP_TABLE_PORTFOLIOS,
        array(
            'title' => $title,
            'corder' => $corder
        ),
        array( 'id' => $pid ),
        array(
            '%s',
            '%s'
        ),
        array( '%d' )
    );

    $response->status = 'success';
    $response->pid = $pid;
    crp_ajax_return($response);
}

//Helper functions
function crp_ajax_return( $response ){
    echo  json_encode( $response );
    die();
}
