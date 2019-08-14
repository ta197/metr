<?php
namespace application\models;
use  engine\core\base\DB, engine\core\Model;

class Goods extends Model
{
    static public $table = 'goods';
    protected $pk = 'goods_id';
     
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    //public function __construct(){
        
    //}
    
/////////////////////////////////////////////////////////////////////
    /**
     * товары одной компании одной категории (вложенные не берутся)
    */
    public function getGoodsCompanyByCat($c, $cat){
        $sql  = "SELECT
            g.goods_id, 
            g.name AS goods, 
            g.date, 
            g.short_description,
            g.long_description, 
            places_goods.price AS price,
            places_goods.unit,
            cats.parent_id,
            GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(
                                                        p.city, 
                                                        p.street, 
                                                        p.house, 
                                                        centres.address, 
                                                        centres.name_center, 
                                                        p.detail, 
                                                        p.unit_floor, 
                                                        p.unit_not),
                       	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                        SEPARATOR '~~') 
                        AS addresses
            FROM `goods` AS g
            LEFT JOIN `places_goods` ON places_goods.goods_id = g.goods_id
            LEFT JOIN `places` AS p ON p.place_id = places_goods.place_id
                JOIN `companies` AS c ON (p.company_id =  c.company_id)
                LEFT JOIN `centres` ON (p.centre = centres.id)
            LEFT JOIN `cats` ON g.cat_id = cats.cat_id
            WHERE p.company_id = ? AND g.cat_id = ?
            GROUP BY g.goods_id
            ORDER BY goods";
            
            return $data = DB::prepare($sql)->execute([$c, $cat])->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

/////////////////////////////////////////////////////////////////////
    /**
     * товары одной компании и всех категорий-детей от указанной
    */
    public function getGoodsByCompanyAndChildCat($c, $lft, $rgt){
        $sql  = "SELECT
            g.goods_id, 
            g.name AS goods, 
            g.date, 
            g.short_description,
            g.long_description, 
            places_goods.price AS price,
            places_goods.unit,
            cats.parent_id,
            GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(
                                                        p.city, 
                                                        p.street, 
                                                        p.house, 
                                                        centres.address, 
                                                        centres.name_center, 
                                                        p.detail, 
                                                        p.unit_floor, 
                                                        p.unit_not),
                       	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                        SEPARATOR '~~') 
                        AS addresses
            FROM `goods` AS g
            LEFT JOIN `places_goods` ON places_goods.goods_id = g.goods_id
            LEFT JOIN `places` AS p ON p.place_id = places_goods.place_id
                JOIN `companies` AS c ON (p.company_id =  c.company_id)
                LEFT JOIN `centres` ON (p.centre = centres.id)
            LEFT JOIN `cats` ON g.cat_id = cats.cat_id
            WHERE p.company_id = ? AND cats.lft>=? AND cats.rgt<=?
            GROUP BY g.goods_id
            ORDER BY goods";
            
            return $data = DB::prepare($sql)->execute([$c, $lft, $rgt])->fetchAll(\PDO::FETCH_CLASS, self::class);
    }    

     
/////////////////////////////////////////////////////////////////////   
    /** 
     * например из главная | категории | материалы для чистовой отделки | напольные покрытия | линолеум | каталог
     * надо перейти на название товара->«Новосел», магазин
    */
    
    public function getGoodsCompanyByCatExGoods($company, $cat, $g){ 
        
        $sql  = "SELECT
            g.goods_id, 
            g.name AS goods, 
            g.date, 
            g.short_description,
            g.long_description, 
            places_goods.price AS price,
            cats.parent_id,
         GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(
                                                     p.city, 
                                                     p.street, 
                                                     p.house, 
                                                     centres.address, 
                                                     centres.name_center, 
                                                     p.detail, 
                                                     p.unit_floor, 
                                                     p.unit_not),
                        phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                     SEPARATOR '~~') 
                     AS addresses
            FROM `goods` AS g
            LEFT JOIN `places_goods` ON places_goods.goods_id = g.goods_id
            LEFT JOIN `places` AS p ON p.place_id = places_goods.place_id
                JOIN `companies` AS c ON (p.company_id =  c.company_id)
                LEFT JOIN `centres` ON (p.centre = centres.id)
            LEFT JOIN `cats` ON g.cat_id = cats.cat_id
            WHERE p.company_id = $company AND g.cat_id = $cat AND g.goods_id !=$g
            GROUP BY g.goods_id
            ORDER BY goods";
        
         return $data = DB::prepare($sql)->execute()->fetchAll(\PDO::FETCH_CLASS, self::class);   
    }
    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function getGoodsByCompanyGoods($company, $g){
        $sql  = "SELECT
            g.goods_id, 
            g.name AS goods, 
            g.date, 
            g.short_description,
            g.long_description, 
            places_goods.price AS price,
            places_goods.unit,
            GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(
                                                        p.city, 
                                                        p.street, 
                                                        p.house, 
                                                        centres.address, 
                                                        centres.name_center, 
                                                        p.detail, 
                                                        p.unit_floor, 
                                                        p.unit_not),
                       	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                        SEPARATOR '~~') 
                        AS addresses
            FROM `goods` AS g
            LEFT JOIN `places_goods` ON (places_goods.goods_id = g.goods_id AND g.goods_id = $g)
            LEFT JOIN `places` AS p ON p.place_id = places_goods.place_id
                JOIN `companies` AS c ON (p.company_id =  c.company_id)
                LEFT JOIN `centres` ON (p.centre = centres.id)
            
            WHERE p.company_id = $company
            GROUP BY g.goods_id";

        return $data = DB::prepare($sql)->execute([$g, $company])->fetchObject(self::class);
    }
    
/////////////////////////////////////////////////////////////////////
    /**
     * Выводит все товары одной категории с указанием адреса, где купить
     */
    public static function getGoodsByCategory($cat){
        $sql  = "SELECT
            g.goods_id, 
            g.name AS goods, 
            g.date, 
            g.short_description,
            g.long_description,
            AVG(places_goods.price) AS price, 
            GROUP_CONCAT(DISTINCT CONCAT_WS('^', 
                    company_to_string(c.name_type, c.shop, 
                    legal.name, c.name_legal, c.quotes, c.company), 
                    c.company_id,
                    places_to_string(
                            p.city, 
                            p.street, 
                            p.house, 
                            centres.address, 
                            centres.name_center, 
                            p.detail, 
                            p.unit_floor, 
                            p.unit_not),
                                                   
                    phones_to_string(
                           p.tel, p.addtel, p.cell, p.add_cell))
                    SEPARATOR '~~') 
                    AS addresses
            
            FROM `goods` AS g
            INNER JOIN `places_goods` ON places_goods.goods_id = g.goods_id
                INNER JOIN `places` AS p ON p.place_id = places_goods.place_id
                JOIN `companies` AS c ON (p.company_id =  c.company_id)
                LEFT JOIN `centres` ON (p.centre = centres.id)
                LEFT JOIN `legal` ON (legal.id = c.legal)
            WHERE c.archive IS NULL and g.cat_id = ?
            GROUP BY g.goods_id
            ORDER BY goods";
        
        return $data = DB::prepare($sql)->execute([$cat])->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    
/////////////////////////////////////////////////////////////////////  
     /**
     * Выводит все товары одной компании
     */
    public function getGoodsByCompany($name){
        $sql  = "SELECT
            g.goods_id, 
            g.name AS goods, 
            g.date,
            g.short_description,
            g.long_description, 
            places_goods.price AS price,
            p.place_id, 
            cats.name AS category,
            cats.cat_id,
            cats.parent_id,
            GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(
                                                        p.city, 
                                                        p.street, 
                                                        p.house, 
                                                        centres.address, 
                                                        centres.name_center, 
                                                        p.detail, 
                                                        p.unit_floor, 
                                                        p.unit_not),
                       	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                        SEPARATOR '~~') 
                        AS addresses
            FROM `goods` AS g
            LEFT JOIN `places_goods` ON places_goods.goods_id = g.goods_id
            LEFT JOIN `places` AS p ON p.place_id = places_goods.place_id
            JOIN `companies` AS c ON (p.company_id =  c.company_id)
            LEFT JOIN `centres` ON (p.centre = centres.id)
            LEFT JOIN `cats` ON g.cat_id = cats.cat_id
            WHERE p.company_id = ?
            GROUP BY g.goods_id
            ORDER BY goods";

            return $data = DB::prepare($sql)->execute([$name])->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     * Выводит все товары одного местоположения
     */
    public function getGoodsByPlace($p){
     
        $sql  = "SELECT
        g.goods_id, 
        g.name AS goods, 
        g.date,
        g.short_description,
        g.long_description, 
        places_goods.price AS price,
        p.place_id, 
        cats.name AS category,
        cats.cat_id,
        cats.parent_id,
        GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(
                                                    p.city, 
                                                    p.street, 
                                                    p.house, 
                                                    centres.address, 
                                                    centres.name_center, 
                                                    p.detail, 
                                                    p.unit_floor, 
                                                    p.unit_not),
                   	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                    SEPARATOR '~~') 
                    AS addresses
        FROM `goods` AS g
        LEFT JOIN `places_goods` ON places_goods.goods_id = g.goods_id
        LEFT JOIN `places` AS p ON p.place_id = places_goods.place_id
        JOIN `companies` AS c ON (p.company_id =  c.company_id)
        LEFT JOIN `centres` ON (p.centre = centres.id)
        LEFT JOIN `cats` ON g.cat_id = cats.cat_id
        WHERE c.archive IS NULL and p.place_id = ?
        GROUP BY g.goods_id
        ORDER BY goods";
    return  $data = DB::prepare($sql)->execute([$p])->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     * Выводит один товар
     */
    public function getGoods($goods){

        $sql  = "SELECT
            g.goods_id, 
            g.name AS name, 
            g.date,
            g.short_description,
            g.long_description, 
            g.link_photo,
            cats.name AS category,
            cats.cat_id,
            cats.parent_id,
            cats.lft,
            cats.rgt,
            AVG(places_goods.price) AS price 
            FROM `goods` AS g
            LEFT JOIN `places_goods` ON places_goods.goods_id = g.goods_id
            LEFT JOIN `cats` ON g.cat_id = cats.cat_id
            WHERE g.goods_id = ?
            GROUP BY g.goods_id
            ORDER BY name";
        
        return $goods = DB::prepare($sql)->execute([$goods])->fetchObject(self::class);
    }
    
    
/////////////////////////////////////////////////////////////////////
    /**
     * 
     * Выводит количество товаров одной категории по её id
     */
    public function countGoodsByCat($id){
        return $this->countRowIdByField('goods_id', 'cat_id', $id);
      }
    
    
    
/////////////////////////////////////////////////////////////////////
    /* Компания - адесная информация
    SELECT companies.company, places.*
FROM `places`
JOIN `companies` ON (companies.id = places.company_id)
ORDER BY companies.company
    */

   
    
/////////////////////////////////////////////////////////////////////
               /* представленние address //  SQL_NO_CACHE 
               CREATE VIEW address
AS
SELECT company_id,
places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, null, p.unit_not)
AS ul,
CONCAT_WS('^', company_id, places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, null, p.unit_not)) 
AS id_ul,
SUBSTRING_INDEX(GROUP_CONCAT(phones_to_string(p.tel, p.addtel, p.cell, p.add_cell) SEPARATOR ', '), ', ', 2)
AS phone
FROM `places` AS p
LEFT JOIN `centres` ON (p.centre = centres.id)
GROUP BY id_ul
            */ 


    /*
    public function getPlacesByCompanyId($id)
        {
            return $this->db->queryALLClass(
                "SELECT 
                p.id,
                places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not) AS addresses, 
                p.tel, p.addtel, p.cell, p.add_cell, 
                GROUP_CONCAT(CONCAT_WS(' | ' , cats.name, cats.id, cats.level) ORDER BY cats.lft
                        SEPARATOR '~~') 
                        AS categories
                FROM `places` AS p
                LEFT JOIN `places_cats` ON (places_cats.place_id = p.id)
                LEFT JOIN `cats` ON (cats.id = places_cats.cat_id  AND cats.activated = 0)
                LEFT JOIN `centres` ON (p.centre = centres.id)
                WHERE p.company_id = $id
                GROUP BY p.id
                ORDER BY addresses", self::class
            );
        }
    */

}