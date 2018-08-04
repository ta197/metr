<?php
namespace application\models;

class Address extends Model
{
    const TABLE = 'places';
    
    public $company;
    public $street;
    public $tel;
    public $cell;
    public $addtel;
    public $add_cell;

    public $addresses;
    public $categories;
    
    public function __construct(){
        parent::__construct();  
    }
   
    public function getPlacesByCompanyId($id)
    {
        return self::$db->queryALLClass(
            "SELECT 
            p.place_id, GROUP_CONCAT(DISTINCT places_goods.goods_id) AS goods,
            places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not) AS addresses, 
            phones_to_string(p.tel, p.addtel, p.cell, p.add_cell) AS phones, 
            GROUP_CONCAT(DISTINCT CONCAT(cats.name,' | ' ,cats.cat_id,' | ' ,cats.level) ORDER BY cats.lft
                    SEPARATOR '~~') 
                    AS categories,
            p.work_mode, p.email
            FROM `places` AS p
            LEFT JOIN `places_cats` ON (places_cats.place_id = p.place_id)
            LEFT JOIN `places_goods` ON (places_goods.place_id = p.place_id)
            LEFT JOIN `cats` ON (cats.cat_id = places_cats.cat_id AND cats.visible IS NOT NULL AND cats.activated IS NOT NULL)
            LEFT JOIN `centres` ON (p.centre = centres.id)
            WHERE p.company_id = $id
            GROUP BY p.place_id
            ORDER BY addresses", self::class
        );
    }

    public function getPlaceById($place)
    {
        return self::$db->queryClass(
            "SELECT
            c.company, c.quotes, c.company_id, c.site, p.place_id,
            places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not) AS address, 
            phones_to_string(p.tel, p.addtel, p.cell, p.add_cell) AS phones, 
            company_to_string(c.name_type, c.shop, c.legal, c.name_legal, c.quotes, c.company) AS company_name 
            FROM `places` AS p
            JOIN `companies` AS c ON (p.company_id =  c.company_id)
            LEFT JOIN `centres` ON (p.centre = centres.id)
            WHERE p.place_id = $place", 
            self::class
        );
    }

}

