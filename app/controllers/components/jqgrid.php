<?php
class JqgridComponent extends Object {
  function getStart($params, $model_name) {
    $page = $params['url']['page']; 
    $limit = $params['url']['rows']; 
    $sidx = $params['url']['sidx']; 
    $sord = $params['url']['sord']; 

    if(!$sidx) $sidx =1;
    $modelInstance = ClassRegistry::init($model_name);
    $count = $modelInstance->find('count');
    if( $count >0 ) {
    	$total_pages = ceil($count/$limit);
    } else {
    	$total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit;
    return $start; 
  }
  
  function getLimit($params, $model_name) {
    $page = $params['url']['page']; 
    $limit = $params['url']['rows']; 
    $sidx = $params['url']['sidx']; 
    $sord = $params['url']['sord']; 

    if(!$sidx) $sidx =1;
    $modelInstance = ClassRegistry::init($model_name);
    $count = $modelInstance->find('count');
    if( $count >0 ) {
    	$total_pages = ceil($count/$limit);
    } else {
    	$total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit;
    return $limit; 
  }

  function getPage($params, $model_name) {
    $page = $params['url']['page']; 
    $limit = $params['url']['rows']; 
    $sidx = $params['url']['sidx']; 
    $sord = $params['url']['sord']; 

    if(!$sidx) $sidx =1;
    $modelInstance = ClassRegistry::init($model_name);
    $count = $modelInstance->find('count');
    if( $count >0 ) {
    	$total_pages = ceil($count/$limit);
    } else {
    	$total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit;
    return $page; 
  }
  
  function getTotalPages($params, $model_name) {
    $page = $params['url']['page']; 
    $limit = $params['url']['rows']; 
    $sidx = $params['url']['sidx']; 
    $sord = $params['url']['sord']; 

    if(!$sidx) $sidx =1;
    $modelInstance = ClassRegistry::init($model_name);
    $count = $modelInstance->find('count');
    if( $count >0 ) {
    	$total_pages = ceil($count/$limit);
    } else {
    	$total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit;
    return $total_pages; 
  }
  
  function getCount($params, $model_name) {
    $page = $params['url']['page']; 
    $limit = $params['url']['rows']; 
    $sidx = $params['url']['sidx']; 
    $sord = $params['url']['sord']; 

    if(!$sidx) $sidx =1;
    $modelInstance = ClassRegistry::init($model_name);
    $count = $modelInstance->find('count');
    if( $count >0 ) {
    	$total_pages = ceil($count/$limit);
    } else {
    	$total_pages = 0;
    }
    if ($page > $total_pages) $page=$total_pages;
    $start = $limit*$page - $limit;
    return $count; 
  }
}
?>