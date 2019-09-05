<?php
namespace application\controllers\main;
use 
  engine\core\base\View, 
  application\models\Search;
use  engine\core\App,  engine\core\IController, engine\core\Page, engine\core\Menu;

class SearchController extends ParentController implements IController
{
    
/////////////////////////////////////////////////////////////////////  
  public function indexAction()
  {
    
  }

/////////////////////////////////////////////////////////////////////
/**
 * http://metrkv1/search/response/search/?search=%D0%BE%D0%B1%D0%BE%D0%B8
 * странца ответа на запрос из формы поиска
 */
  public function responseAction()
  {
    $query = $this->fc->getParams()["search"];
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

  }
  /////////////////////////////////////////////////////////////////////

}
