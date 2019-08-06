<?php
$componentLinkBRC = (!empty($componentLinkBRC)) ? $componentLinkBRC : "";
foreach ($brc as $breadcrumb){
    if(!empty($breadcrumb['name']))
echo <<<HEREDOC
 | <a href = "$componentLinkBRC{$breadcrumb['cat_id']}">{$breadcrumb['name']}</a>
HEREDOC;
}

        