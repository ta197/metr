<nav>
    <a href="/" class="nav__icon nav__icon_logo">главная</a>
<?php
if(empty ($navStatus['metr'])){
echo <<<HEREDOC
    <a href="/category" class="nav__icon nav__icon_routing">категории</a>
    <a href="/company" class="nav__icon nav__icon_lists">компании</a>
    <a href="/search" class="nav__icon nav__icon_search">поиск</a>
HEREDOC;
}else{
echo <<<HEREDOC
    <a href="/category" class="nav__icon{$navStatus['metr']['CategoryActiv']}{$navStatus['metr']['CategoryDisabled']} nav__icon_routing">категории</a>
    <a href="/company" class="nav__icon{$navStatus['metr']['CompanyActiv']}{$navStatus['metr']['CompanyDisabled']} nav__icon_lists">компании</a>
    <a href="/search" class="nav__icon{$navStatus['metr']['SearchActiv']}{$navStatus['metr']['SearchDisabled']} nav__icon_search">поиск</a>
HEREDOC;
}

?>
</nav>