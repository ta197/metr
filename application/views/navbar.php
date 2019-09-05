<!--
	$count - общее количество записей
	$on_page - количество записей на странице
	$page_num - номер текущей страницы
	$url_self - url адрес от корня без номера с страницы
-->
<? extract($pagination); ?>
<? if($max_page > 1):?>
<div class="pagination">
  <ul>
	<? if($page_num <= 1): ?>
    	<li><span>Начало</span></li>
		<li><span>Пред.</span></li>
	<? else: ?>
		<li><a href="<?=$url_self?>">Начало</a></li>
		<li><a href="<?=$url_self .'/page/'. ($page_num - 1)?>#pagination">Пред.</a></li>
	<? endif; ?>
	<? for($i = $left; $i <= $right; $i++):?>
			<? if($i <1 || $i > $max_page) continue;?>
			<? if($i == $page_num): ?>
    			<li><span><strong><?=$i?></strong></span></li>
			<? else: ?>
				<li><a href="<?=$url_self .'/page/'. $i?>#pagination"><?=$i?></a></li>
			<? endif; ?>
	<? endfor; ?>
	
	<? if($page_num * $on_page >= $count): ?>
    	<li><span>След.</span></li>
		<li><span>Конец</span></li>
	<? else: ?>
		<li><a href="<?=$url_self .'/page/'.($page_num + 1)?>#pagination">След.</a></li>
		<li><a href="<?=$url_self .'/page/'. $max_page?>#pagination">Конец</a></li>
	<? endif; ?>
  </ul>
</div>
<? endif; ?>