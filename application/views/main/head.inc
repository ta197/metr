<!DOCTYPE html>
<html lang="ru-Ru">
<head>
    <meta charset="UTF-8">
    <? if(isset($this->page->title)):?>
    <title><?= $this->page->title; ?></title>
    <? endif; ?>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css" />
        <?php if(isset($this->page->styles)):?>
            <? foreach($this->page->styles as $style): ?>
                <link rel="stylesheet" href="/public/css/<?=$style; ?>.css" type="text/css" />
            <? endforeach; ?>
    <? endif; ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php if(!empty($this->page->scripts)):
            foreach($this->page->scripts as $script):
                echo '<script type="text/javascript" src="/public/js/'. $script. '.js" type="text/javascript"></script>';
            endforeach;
    endif; ?>
    
    <script type="text/javascript" src="/public/js/smoothscroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="/public/js/updown.js" type="text/javascript" defer></script>
    
</head>
