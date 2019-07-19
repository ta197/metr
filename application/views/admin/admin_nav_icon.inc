<nav>
    
<?php
if(empty ($navStatus['admin'])){
echo <<<HEREDOC
    <a href="/admin" class="nav__icon nav__icon_logo">главная</a>
    <a href="/admin/category" class="nav__icon nav__icon_routing">категории</a>
    <a href="/admin/company" class="nav__icon nav__icon_lists">компании</a>
    <a href="/admin/catalog" class="nav__icon nav__icon_search">каталог</a>
HEREDOC;
}else{
echo <<<HEREDOC
    <a href="/admin" class="nav__icon{$navStatus['admin']['IndexActiv']}{$navStatus['admin']['IndexDisabled']} nav__icon_logo">главная</a>
    <a href="/admin/category" class="nav__icon{$navStatus['admin']['CategoryActiv']}{$navStatus['admin']['CategoryDisabled']} nav__icon_routing">категории</a>
    <a href="/admin/company" class="nav__icon{$navStatus['admin']['CompanyActiv']}{$navStatus['admin']['CompanyDisabled']} nav__icon_lists">компании</a>
    <a href="/admin/catalog" class="nav__icon{$navStatus['admin']['CatalogActiv']}{$navStatus['admin']['CatalogDisabled']} nav__icon_search">каталог</a>
HEREDOC;
}

?>
</nav>