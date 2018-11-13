<?
// МЕНЮ (ОСНОВНОЕ)
function main()
{
	global $prx, $mainID;

	?><ul class="rd-navbar-nav"><?

	$mas = getTree("SELECT * FROM {$prx}pages WHERE status=1 AND is_main=1 ORDER BY sort,id");

  if(sizeof($mas)){

		$old_lvl = $lvl = 0;
		foreach($mas as $vetka){
			$row = $vetka['row'];
			$lvl = $vetka['level'];

			$id = $row['id'];
			$link = $row['type']=='link' ? $row['link'] : ($row['link']=='/' ? '/' : "/{$row['link']}.htm");
			$childs = getIdChilds("SELECT * FROM {$prx}pages WHERE status=1 AND is_main=1", $id);
			$has_childs = sizeof($childs) > 1;
			$parents = getArrParents("SELECT id,id_parent FROM {$prx}pages WHERE id='%s'", $id);
			$cur = array_search($mainID, $parents) !== false || ($_SERVER['REQUEST_URI'] == '/' && $link == '/') ? true : false;

			if($old_lvl && !$lvl){
				?></ul></li><?
			}

			if(!$lvl){
				if(!$has_childs){
					?><li class="<?=$cur?'active':''?>"><a href="<?=$link?>"><?=$row['name']?></a></li><?
				} else {
					?>
          <li class="<?=$cur?'active':''?>"><a href="<?=$link?>"><?=$row['name']?></a>
          <ul class="rd-navbar-dropdown">
					<?
				}
			} else {
				?><li class="<?=$cur?'active':''?>"><a href="<?=$link?>"><?=$row['name']?></a></li><?
			}
			$old_lvl = $lvl;
		}

		if($lvl){
			?></ul></div></li><?
		}
  }

	?><li class="rd-navbar-cta">
    <a href="callto:<?=preg_replace('/[^0-9]*/', '', set('phone'));?>"><span class="icon text-white icon-xs fas fa-phone"></span><?=set('phone')?></a>
  </li>
  </ul><?
}
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