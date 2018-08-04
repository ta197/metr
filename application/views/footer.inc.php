<footer>

<?php
if(empty ($navStatus)){
echo <<<HEREDOC
        <div class="footer__nav">
            <a href="/about" class="footer__nav-item"> о проекте</a>
            <a href="/about/contacts" class="footer__nav-item">как с нами связаться</a>
            <a href="/about/partners" class="footer__nav-item">рекламодателям</a>
        </div>
HEREDOC;
}else{
echo <<<HEREDOC
        <div class="footer__nav">
            <a href="/about" class="footer__nav-item{$navStatus['AboutActiv']}{$navStatus['AboutDisabled']}"> о проекте</a>
            <a href="/about/contacts" class="footer__nav-item{$navStatus['ContactsActiv']}{$navStatus['ContactsDisabled']}">как с нами связаться</a>
            <a href="/about/partners" class="footer__nav-item{$navStatus['PartnersActiv']}{$navStatus['PartnersDisabled']}">рекламодателям</a>
        </div>       
HEREDOC;
}
?>

        <div class="footer__content">
            <div class="side-content">
                <ul class="footer__column">
                    <li class="footer__column-item">Нашли ошибку?</li>
                    <li class="footer__column-item">Напишите нам:</li>
                    <li class="footer__column-item"><a  href="/about/contact/email">адрес почты</a></li>
                </ul>

                <ul class="footer__column">
                    <li class="footer__column-item"><a  href="/admin/login">регистрация</a></li><br/>
                    <li class="footer__column-item"><a  href="/admin/login">вход</a></li>
                </ul>

                <ul class="footer__column">
                       <li class="footer__column-item">&copy; Петрова Т.В., 2017-2018</li>
                </ul>
            </div><!--закрытие footer_indent-side-->
        </div> <!--закрытие footer__content-->
    
        
    </footer>
        
    <div id ="updown">
        <a href="#">
            <div class="updown up"> </div>
        </a>
    </div>
    <!-- <script type="text/javascript" src="/js/updown.js" type="text/javascript"></script> -->