<?
// СТРОКА НАВИГАЦИИ
function navigate()
{
	global $navigate;
	if(!$navigate) return;
	$sep = '<span>/</span>';
	?><div id="navigate"><a href="/">Главная страница</a><?=$sep?><?=$navigate?><?=$sep?></div><?
}

function num2str($count,$txt='товар')
{
	$pat = array(
		'страница' => array('страница','страницы','страниц')
	);

	$count = $count%100;
	if($count>19) $count = $count%10;
	switch($count)
	{
		case 1:  return($pat[$txt][0]);
		case 2: case 3: case 4:  return($pat[$txt][1]);
		default: return($pat[$txt][2]);
	}
}