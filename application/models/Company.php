<?php
namespace application\models;

//use application\models\Helper;

class Company extends Model
{
    const TABLE = 'company';
    
    //public $db;
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
    
    public $addresses =[];
    
    public function __construct(){
        parent::__construct();  
    }


    public function getEachCompanies($fildAncor, $where = 'WHERE c.archive IS NULL', $andWhere = '', $order = 'c.company', $q = [])
    {
        return self::$db->queryEach(
            "SELECT

           $fildAncor AS ancor,

            c.company, c.company_id, c.site, legal.name, 
            company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name,
            
            GROUP_CONCAT(CONCAT_WS('', a.ul, a.phone)
                        SEPARATOR '~~') 
                        AS addresses
            FROM `address` AS a
            RIGHT JOIN `companies` AS c ON (a.company_id =  c.company_id)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            $where 
            $andWhere
            GROUP BY c.company_id
            ORDER BY $order", 
            $q);
    }


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


 // получаем весь список неуникальных анкоров -- это либо перв.буква либо год создания -- по выбору $fildAncor

    public function getAncors($fildAncor, $where = 'WHERE c.archive IS NULL ', $sort = 'ASC', $andWhere ='', $q = []) //список начальных букв, включая латиницу и цифры // не уникальные, а все, чтобы посчитав знать кол-во компаний
    {
        return self::$db->queryAll(
            "SELECT
            $fildAncor AS ancor
            FROM `companies` AS c
            LEFT JOIN `places` AS p ON (p.company_id =  c.company_id)
            LEFT JOIN `shop` AS sh ON (sh.id =  p.shop)
            LEFT JOIN `legal` ON (legal.id = c.legal)
            $where $andWhere
            GROUP BY c.company_id
            ORDER BY ancor $sort", $q
        );
    }

// группировка под одним подзаголовком -- буква или год
    
    public function uniqueAncors($letters, $order='c.company')
    {
        if($order === "c.rating DESC, c.company ") return '';
        $letters = array_column($letters, 'ancor');
        $letters = array_unique($letters);
        if(is_array($letters))
            return $letters;
        return false;
    }


    public function isCyrillicAlphabet($arr)
    {
        if(!is_array($arr)) return;
        $isCyrillicAlphabet = [];
        foreach ($arr as $value){
            if( preg_match("/^[А-Яа-я]/", $value))
                $isCyrillicAlphabet[] = $value;
        }
        if(is_array($isCyrillicAlphabet))
        return $isCyrillicAlphabet;
    }


// список компаний по категории (без информации о наличии каталога этой категории у компании)
    
    public function getCompaniesByCategory($id){
        //$arr[] = $this->clearInt($id);
        return self::$db->queryEach(
            "SELECT
            p.place_id,
            c.company, LEFT(c.company, 1) AS letter, c.company_id, c.site, 
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
            WHERE c.archive IS NULL AND places_cats.cat_id = ?
            GROUP BY c.company_id
            ORDER BY c.company",
            [$id]);
    }

// список компаний по категории (с информацией о наличии каталога этой категории у компании)
    
    public function getCompaniesByCategoryAndGoods($id){
        //$arr[] = $this->clearInt($id);
        return self::$db->queryEach(
            "SELECT
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
            ORDER BY c.company",
            [$id]);
    }
   

    public function getCompaniesByGoods($goods){
        $arr[] = $this->clearInt($goods);
        return self::$db->queryAll(
            "SELECT
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
            ORDER BY c.company", $arr);
       }


    public function countCompaniesByCategory($id){
        return self::$db->queryAll(
            "SELECT
            LEFT(c.company, 1) AS letter, c.company_id
            FROM `places` AS p
            LEFT JOIN `places_cats` ON (places_cats.place_id = p.place_id)
            JOIN `companies` AS c ON (p.company_id =  c.company_id)
            WHERE  c.archive IS NULL AND  places_cats.cat_id = ?
            GROUP BY c.company_id
            ORDER BY letter",
            [$id]);
    }
      
    public function getTitleCompanyById($id)
        {
            return self::$db->queryClass(
                "SELECT
                c.company, c.quotes, c.company_id, c.site, c.about, c.face, c.archive,
                company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name
                FROM `companies` AS c
                LEFT JOIN `legal` ON (legal.id = c.legal)  
                WHERE  c.company_id = $id", 
                self::class
            );
        }

//  все компаниии по фильтру раздела компании ---------------

    public function getCompaniesByFilters($where='WHERE c.archive IS NULL ', $order = 'c.company', $sort = 'ASC')
    {
        return self::$db->queryAll(
            "SELECT
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
            ORDER BY $order $sort");
    }


}

