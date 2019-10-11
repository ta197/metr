<?php  if(substr($obj->company_name, 0, 7) === "&laquo;") 
                            $indent = ' listing__company-name_quote-indent'; 
                ?>
                    <dt class="listing__company-name<?= $indent; ?>"><?php echo $obj->company_name; ?></dt>
                    <?php 
                        foreach ($obj as $key => $item){
                            if($key == 'arrPlaces' ){
                                foreach($item as $place){
                                    echo '<dd class="listing__company-address">'.$place->full_place.'</dd>';
                                }
                            }
                        }
                    ?>
                     <dd class="listing__link">
                        <a href="<?= $this->route['prefix'] ?><?= $obj::$page_link['one'] ?><?= $obj->primary_key ?>">
                            подробнее
                        </a>
                    </dd>