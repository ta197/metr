<?php
namespace application\controllers\petrova;

use engine\core\base\Controller;

class ParentPetrovaController extends Controller
{
    public $base_title = 'Петрова Т.В.';
    public $file_layout = 'petrova';

    public function __construct($fc){
        parent::__construct($fc);
            //$this->isRole();
        
    }


}