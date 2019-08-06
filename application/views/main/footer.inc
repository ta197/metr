<footer>
    <div class="footer__content">
        <div class="side-content">
           
<?php
if(empty ($navStatus['about'])){
echo <<<HEREDOC
    <ul class="footer__column">
        <li class="footer__column-item"><a href="/about" class="footer__nav-item"> о проекте</a></li><br/>
        <li class="footer__column-item"><a href="/about/contacts" class="footer__nav-item">как с нами связаться</a></li><br/>
        <li class="footer__column-item"> <a href="/about/partners" class="footer__nav-item">рекламодателям</a></li>
    </ul>
HEREDOC;
}else{
echo <<<HEREDOC
    <ul class="footer__column">
        <li class="footer__column-item"><a href="/about" class="footer__nav-item{$navStatus['about']['AboutActiv']}{$navStatus['about']['AboutDisabled']}"> о проекте</a></li><br/>
        <li class="footer__column-item"><a href="/about/contacts" class="footer__nav-item{$navStatus['about']['ContactsActiv']}{$navStatus['about']['ContactsDisabled']}">как с нами связаться</a></li><br/>
        <li class="footer__column-item"> <a href="/about/partners" class="footer__nav-item{$navStatus['about']['PartnersActiv']}{$navStatus['about']['PartnersDisabled']}">рекламодателям</a></li>
    </ul>
HEREDOC;
}
?>

 <!--   <ul class="footer__column">
        <li class="footer__column-item"><a  href="/admin/login">регистрация</a></li><br/>
        <li class="footer__column-item"><a  href="/admin/login">вход</a></li>
    </ul>
-->
    <ul class="footer__column">
        <li class="footer__column-item"><a  href="/petrova">&copy; Петрова Т.В., 2017-2018</a></li>
    </ul>
    </div>
</div> <!--закрытие footer__content-->
        
</footer>
        
<div id ="updown">
    <a href="#">
        <div class="updown up"> </div>
    </a>
</div>
    <!-- <script type="text/javascript" src="/js/updown.js" type="text/javascript"></script> -->