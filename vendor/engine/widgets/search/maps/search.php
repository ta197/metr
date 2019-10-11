<?php
    /** 
    * 
    */
	return array(
		'company' => array(
						'table' => '`companies` AS c',
						'search_in' => array('c.company', 
											'p.city',
											'centres.name_center',
											'centres.address',
											'c.shop',
											'p.street',
											'c.name_legal',
											'legal.name',
											'p.house',
											'p.unit_floor',
											'p.tel',
											'p.addtel',
											'p.cell',),
						'fields' => array('c.company', 'c.company_id', 'p.street', 'p.house',
											'company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name',
											"GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floor, p.unit_not),
                       							phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                        						SEPARATOR '~~') 
                        			AS full_places"),
						'where' => "archive IS NULL",
						'join' => '`places` AS p ON (p.company_id =  c.company_id)
									LEFT JOIN `legal` ON (legal.id = c.legal)
									LEFT JOIN `centres` ON (p.centre = centres.id)',
						'group_by' => 'c.company_id',
						'order_by' => 'c.company',
						'title' => 'компании',
						//'view_section' => ROOT.'/vendor/engine/widgets/search/view/org.php',
						),
		//'address' => array(
						//'search_in' => array('street', 'house', 'unit_floor', 'tel', 'addtel', 'cell', 'add_cell'),
						//'fields' => array('place_id', 'street', 'house', 'detail'),
						//'left_join' => '`centres` ON (places.centre =  centres.id)',
						//'title' => "адреса",
						//),
		'centre' => array(
							'search_in' => array('name_center', 'address'),
							'fields' => array('id', 'name_center', 'address'),
							//'join' => '`places` ON (places.centre = centres.id)',
							'title' => "центры",
							),
		'category' => array(
						'search_in' => array('name'),
						'fields' => array('name', 'cat_id', ),
						'where' => "visible = 1",
						'title' => 'категории',
						),
		'legal' => array(
						'search_in' => array('name', 'decoding'),
						'fields' => array('name', 'decoding', ),
						'title' => 'формы собственности',
						),
		'goods' => array(
						'search_in' => array('name'),
						'fields' => array('name', 'goods_id'),
						'title' => 'товары',
						),								
	);
