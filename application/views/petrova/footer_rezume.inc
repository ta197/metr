<footer>
    <div class="footer__content">
        <div class="side-content">
           
<?php
if(empty ($navStatus['rezume'])){
echo <<<HEREDOC
    <ul class="footer__column">
        <li class="footer__column-item"><a href="/petrova/rezume/develop" class="footer__nav-item">разработка</a></li><br/>
        <li class="footer__column-item"><a href="/petrova/rezume/design" class="footer__nav-item">дизайн</a></li><br/>
        <li class="footer__column-item"> <a href="/petrova/rezume/proofs" class="footer__nav-item">корректура</a></li>
    </ul>
    <ul class="footer__column">
        <li class="footer__column-item"><a href="/petrova/rezume/education" class="footer__nav-item">образование</a></li><br/>
        <li class="footer__column-item"><a href="/petrova/rezume/experience" class="footer__nav-item">опыт работы</a></li><br/>
        <li class="footer__column-item"> <a href="/petrova/rezume/add" class="footer__nav-item">дополнительно</a></li>
    </ul>
    <ul class="footer__column">
        <li class="footer__column-item"><a  href="/petrova">главная</a></li><br/>
    </ul>
HEREDOC;
}else{
echo <<<HEREDOC
    <ul class="footer__column">
        <li class="footer__column-item"><a href="/petrova/rezume/develop" class="footer__nav-item{$navStatus['rezume']['DevelopActiv']}{$navStatus['rezume']['DevelopDisabled']}">разработка</a></li><br/>
        <li class="footer__column-item"><a href="/petrova/rezume/design" class="footer__nav-item{$navStatus['rezume']['DesignActiv']}{$navStatus['rezume']['DesignDisabled']}">дизайн</a></li><br/>
        <li class="footer__column-item"> <a href="/petrova/rezume/proofs" class="footer__nav-item{$navStatus['rezume']['ProofsActiv']}{$navStatus['rezume']['ProofsDisabled']}">корректура</a></li>
    </ul>
    <ul class="footer__column">
        <li class="footer__column-item"><a href="/petrova/rezume/education" class="footer__nav-item{$navStatus['rezume']['EducationActiv']}{$navStatus['rezume']['EducationDisabled']}">образование</a></li><br/>
        <li class="footer__column-item"><a href="/petrova/rezume/experience" class="footer__nav-item{$navStatus['rezume']['ExperienceActiv']}{$navStatus['rezume']['ExperienceDisabled']}">опыт работы</a></li><br/>
        <li class="footer__column-item"> <a href="/petrova/rezume/add" class="footer__nav-item{$navStatus['rezume']['AddActiv']}{$navStatus['rezume']['AddDisabled']}">дополнительно</a></li>
    </ul>
    <ul class="footer__column">
        <li class="footer__column-item"><a  href="/petrova" class="footer__nav-item{$navStatus['rezume']['IndexRezumeActiv']}{$navStatus['rezume']['IndexRezumeDisabled']}">главная</a></li><br/>
    </ul>
HEREDOC;
}
?>

    </div>
</div> <!--закрытие footer__content-->
        
</footer>
        
<div id ="updown">
    <a href="#">
        <div class="updown up"> </div>
    </a>
</div>
    <!-- <script type="text/javascript" src="/js/updown.js" type="text/javascript"></script> -->