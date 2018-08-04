<?php
namespace application\controllers;

use application\models\View, application\models\Search;

class SearchController extends ParentController implements IController
{
  public function indexAction()
  {
    $fc = FrontController::getInstance();
    $this->view->navStatus = $this->view->navStatus('SearchActiv', 'SearchDisabled');
    $output = $this->view->render(DEFAULT_SEARCH_FILE);
    $fc->setBody($output);
  }

  public function responseAction()
  {
    $fc = FrontController::getInstance();
    $query = $fc->getParams()["search"];
    $this->view->navStatus = $this->view->navStatus('SearchActiv', 'SearchDisabled');

    $search = (new Search());
    $this->view->clearQuery = $search->clearQuery($query);
    $this->view->errQuery = $search->errorQueryExecution($this->view->clearQuery);
    if(!$this->view->errQuery){
      $this->view->arrWords = $search->toWords($this->view->clearQuery);
      $this->view->query = $this->view->clearQuery;
      if($this->view->arrWords){
        $rawDataArr = $search->getSearch($this->view->arrWords);
        //var_dump($rawDataArr);
          if($rawDataArr){
            $this->view->bySort = $search->BySort($rawDataArr);
          } else  $this->view->bySort = 0;
      } else  $this->view->bySort = 0;
    } else  $this->view->bySort = 0;
        
    
    $output = $this->view->render(RESPONSE_BY_SEARCH_FILE);
    $fc->setBody($output);
  }

}
