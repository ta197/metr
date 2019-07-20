<?php
namespace application\controllers;
use 
  application\models\View, 
  application\models\Search;

class SearchController 
  extends ParentController 
  implements IController
{
    
/////////////////////////////////////////////////////////////////////  
  public function indexAction()
  {
    $this->view->navStatus = $this->view->navStatus(['metr'], 'SearchActiv', 'SearchDisabled');
    $this->view->title = 'поиск';
    $this->view->h1 = 'Поиск по сайту';
    $output = $this->view->render(DEFAULT_SEARCH_FILE);
    $this->fc->setBody($output);
  }

/////////////////////////////////////////////////////////////////////
/**
 * http://metrkv1/search/response/search/?search=%D0%BE%D0%B1%D0%BE%D0%B8
 * странца ответа на запрос из формы поиска
 */
  public function responseAction()
  {
    $query = $this->fc->getParams()["search"];
    $this->view->navStatus = $this->view->navStatus(['metr'], 'SearchActiv', 'SearchDisabled');
    $this->view->title = 'поиск';
    $this->view->h1 = 'Результат поиска';
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
    $this->fc->setBody($output);
  }
  /////////////////////////////////////////////////////////////////////

}
