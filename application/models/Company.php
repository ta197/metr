<?php
namespace application\models;
use  engine\core\db\DB, engine\core\base\Model, engine\core\ToString;

class Company extends ToString
{
    static public $pk = 'company_id';
    static public $table = 'companies';
    
    public $company;
    public $company_name;
    public $quotes;
    public $shop;
    public $legal;
    public $name_legal;
    public $site;
    public $about;
    public $face;
    public $archive;
    public $year;
    public $company_extend;
    
    public $addresses;
    public $full_places;
    static public $sql;

    static public $page_link = [
        'one' => 'company/card/name/',
    ];
    
    static public $string = ['primary_key'];
    
/////////////////////////////////////////////////////////////////////
     /**
     * 
     */   
    public function __construct()
    {
        parent::__construct();

        if($this->full_places){
            $places = explode("~~", $this->full_places);
            foreach ($places as $place){
            $place = ltrim($place, " | ");
                if($place){
                    $this->arrPlaces[] = (new Place())->setFullPlace($place);
                }
            }
        }
    }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
  // public function __toString()
   // {
       //$arrString = $this->arrProps();
    //var_dump( $arrString); die;
      //return implode(static::$delim, $arrString);
      //return $str = $arrString['company_name'].$arrString['street']. $arrString['house'];
     //return $arrString['street'].', '. $arrString['house'];

   // }

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    /**
     * 
     */ 
  // public function __toString()
   // {
       //$arrString = $this->arrProps();
    //var_dump( $arrString); die;
      //return implode(static::$delim, $arrString);
      //return $str = $arrString['company_name'].$arrString['street']. $arrString['house'];
     //return $arrString['street'].', '. $arrString['house'];

   // }

/////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    // public function getCompaniesByName($archive = 'IS NULL')
    // {
    //     static::$sql  = "SELECT
    //         LEFT(c.company, 1) AS ancor,

    //         c.company, c.company_id, c.site, legal.name, 
    //         company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name,
            
    //         GROUP_CONCAT(CONCAT_WS('', a.ul, a.phone)
    //                     SEPARATOR '~~') 
    //                     AS addresses
    //         FROM `address` AS a
    //         RIGHT JOIN `companies` AS c ON (a.company_id =  c.company_id)
    //         LEFT JOIN `legal` ON (legal.id = c.legal)
    //         WHERE c.archive $archive
    //         GROUP BY c.company_id
    //         ORDER BY c.company";
            
    //     return $this;
    // }

/////////////////////////////////////////////////////////////////////
    /**
     * 
     */
    public function getCompanies($ancor, $where, $order)
    {
        static::$sql = "SELECT
            $ancor AS ancor,

            c.company, c.company_id, c.site, legal.name, 
            company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name,
            
            GROUP_CONCAT(CONCAT_WS('', a.ul, a.phone)
                        SEPARATOR '~~') 
                        AS addresses
            FROM `address` AS a
            RIGHT JOIN `companies` AS c ON (a.company_id =  c.company_id)
            LEFT JOIN `legal` ON (legal.id = c.legal)

            WHERE $where

            GROUP BY c.company_id

            ORDER BY $order";
            
        return $this;
    }

    
    
/////////////////////////////////////////////////////////////////////
    // /**
    //  * 
    //  */
    // public function getCompaniesByYears($archive = 'IS NULL')
    // {
    //     static::$sql = "SELECT
    //         c.year AS ancor,
    //         c.company, c.company_id, c.site, legal.name, 
    //         company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name,
            
    //         GROUP_CONCAT(CONCAT_WS('', a.ul, a.phone)
    //                     SEPARATOR '~~') 
    //                     AS addresses
    //         FROM `address` AS a
    //         RIGHT JOIN `companies` AS c ON (a.company_id =  c.company_id)
    //         LEFT JOIN `legal` ON (legal.id = c.legal)
    //         WHERE c.archive $archive AND  c.year >= ?
    //         GROUP BY c.company_id
    //         ORDER BY c.year DESC, c.company ASC";
            
    //     return $this;
    // }

    
/////////////////////////////////////////////////////////////////////
 /**
  *  представленние address //  SQL_NO_CACHE 
  
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

    
///////////////////////////////////////////////////////////////////// 
// /**
//  * список компаний по категории (без информации о наличии каталога этой категории у компании)
//  */     
//     public function getCompaniesByCategory($id){    
//         return self::$db->queryEach(
//             "SELECT
//             p.place_id,
//             c.company, LEFT(c.company, 1) AS letter, c.company_id, c.site, 
//             company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name, 
//             GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not),
//                        	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
//                         SEPARATOR '~~') 
//                         AS addresses
//             FROM `places` AS p
//             LEFT JOIN `places_cats` ON (places_cats.place_id = p.place_id)
//             JOIN `companies` AS c ON (p.company_id =  c.company_id)
//             LEFT JOIN `centres` ON (p.centre = centres.id)
//             LEFT JOIN `legal` ON (legal.id = c.legal)
//             WHERE c.archive IS NULL AND places_cats.cat_id = ?
//             GROUP BY c.company_id
//             ORDER BY c.company",
//             [$id]);
//     }


///////////////////////////////////////////////////////////////////// 
/**
 * список компаний по категории (с информацией о наличии каталога этой категории у компании)
 */      
    public function getCompaniesByCategoryAndGoods(){
        //$arr[] = $this->clearInt($id);
        
        static::$sql  = "SELECT
            p.place_id,
            c.company, LEFT(c.company, 1) AS letter, c.company_id, c.site, COUNT(goods.goods_id) as cat_catalog,
            company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name, 
            GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not),
                       	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                        SEPARATOR '~~') 
                        AS addresses
            FROM `places` AS p
            LEFT JOIN `places_cats` ON (places_cats.place_id = p.place_id)
            JOIN `companies` AS c ON (p.company_id =  c.company_id)
            LEFT JOIN `centres` ON (p.centre = centres.id)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            LEFT JOIN `places_goods` ON (places_goods.place_id = places_cats.place_id)
            LEFT JOIN `goods` ON (goods.goods_id = places_goods.goods_id AND goods.cat_id = places_cats.cat_id)
            WHERE  c.archive IS NULL AND  places_cats.cat_id = ?
            GROUP BY c.company_id
            ORDER BY c.company";
        return $this;
    }
   
///////////////////////////////////////////////////////////////////// 
/**
 * 
 */   
       public function getCompaniesByGoods($goods){
        $goods = $this->clearInt($goods);
            $sql  = "SELECT
            p.place_id, places_goods.price, places_goods.date, places_goods.unit,
            c.company, c.company_id,
            company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name, 
            GROUP_CONCAT(CONCAT_WS('', places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not),
                       	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                        SEPARATOR '~~') 
                        AS addresses
            FROM `goods` AS g
            JOIN `places_goods` ON (places_goods.goods_id = g.goods_id)
            JOIN `places` AS p ON (p.place_id = places_goods.place_id)
            LEFT JOIN `companies` AS c ON (p.company_id =  c.company_id)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            LEFT JOIN `centres` ON (p.centre = centres.id)
            WHERE  c.archive IS NULL AND  g.goods_id = ?
            GROUP BY p.place_id
            ORDER BY c.company";
            
            return  $data = DB::prepare($sql)->execute([$goods])->fetchAll();
       }

///////////////////////////////////////////////////////////////////// 
/**
 * 
 */   
    public function countCompaniesByCategory(){
        static::$sql = "SELECT count(DISTINCT(c.company_id))
            FROM `places` AS p
            LEFT JOIN `places_cats` ON (places_cats.place_id = p.place_id)
            JOIN `companies` AS c ON (p.company_id =  c.company_id)
            WHERE  c.archive IS NULL AND  places_cats.cat_id = ?";
        return  $this;
    }

///////////////////////////////////////////////////////////////////// 
///////////////////////////////////////////////////////////////////// 
/**
 * 
 */   
public function getCompaniesByCentre(){
   // $id = $this->clearInt($id);
    static::$sql = "SELECT
        c.company, c.company_id, c.site, legal.name, 
        p.unit_floor, p.unit_not,
        phones_to_string(p.tel, p.addtel, p.cell, p.add_cell) AS phones,
        company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name
    FROM `companies` AS c
    LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
    LEFT JOIN `legal` ON (legal.id = c.legal)
    LEFT JOIN `centres` ON (centres.id = p.centre)
    WHERE centres.id = ?
    GROUP BY c.company_id
    ORDER BY c.company";
    return  $this;
}

///////////////////////////////////////////////////////////////////// 
/**
 * 
 */       
    public function getTitleCompanyById($id)
        {
            $sql  = "SELECT
                c.company, c.quotes, c.company_id, c.site, c.about, c.face, c.archive,
                company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name
                FROM `companies` AS c
                LEFT JOIN `legal` ON (legal.id = c.legal)  
                WHERE  c.company_id = ?";
            return $data = DB::prepare($sql)->execute([$id])->fetchObject(self::class);

        }

/////////////////////////////////////////////////////////////////////
/**
 * все компаниии по фильтру раздела компании
 */   
    public function getCompaniesByFilters($where='WHERE c.archive IS NULL ', $order = 'c.company', $sort = 'ASC')
    {
        static::$sql  = "SELECT
            c.company, LEFT(c.company, 1) AS letter, c.company_id, c.site, c.rating,
            company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name,
            
            GROUP_CONCAT(CONCAT_WS('', p.ul, p.phone)
                        SEPARATOR '~~') 
                        AS addresses
            FROM `address_business` AS p
            RIGHT JOIN `companies` AS c ON (p.company_id =  c.company_id)
            LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            $where
            GROUP BY c.company_id
            ORDER BY $order $sort";

        //return $data = DB::prepare($sql)->execute()->fetchAll();
        return $this;
    }

/////////////////////////////////////////////////////////////////////
}

