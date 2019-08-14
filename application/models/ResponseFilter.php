<?php
namespace application\models;
use engine\core\Model;

class ResponseFilter extends Model
{
    public $business =[];
    public $legal = [];
    public $progression = [];
    
/////////////////////////////////////////////////////////////////////
     public function __construct($business, $legal, $progression){
        //parent::__construct();
        $this->business = $business;
        $this->legal = $legal;
        $this->progression = $progression;
    }
    
/////////////////////////////////////////////////////////////////////    
}
