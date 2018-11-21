<?
require('inc/common.php');

$h1 = 'Статьи «Полезно знать»';
$h = 'Общий список';
$title .= ' :: ' . $h1;
$navigate = '<span></span>' . $h;
$tbl = 'articles';

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET['action'])){

	$id = (int)@$_GET['id'];

	switch($_GET['action'])
	{
	  // ----------------- сохранение
		case 'saveall':
			updateSitemap();
			jAlert('Данные успешно сохранены');
			break;
		// ----------------- сохранение
		case 'save':
			foreach($_POST as $key=>$val)
				$$key = clean($val);

			if(!$name) jAlert('Укажите название');

			$updateLink = false;
			$where = $id ? " and id<>{$id}" : "";

			if($link){
				if(getField("SELECT id FROM {$prx}{$tbl} WHERE link='{$link}'{$where}"))
					$updateLink = true;
			} else {
				$link = makeUrl($name);
				if(getField("SELECT id FROM {$prx}{$tbl} WHERE link='{$link}'{$where}"))
					$updateLink = true;
			}

			$set = "name='{$name}',
							preview='{$preview}',
							text='{$text}',
							status='{$status}',
							title=".($title?"'{$title}'":"NULL").",
							keywords=".($keywords?"'{$keywords}'":"NULL").",
							description=".($description?"'{$description}'":"NULL");
			if(!$updateLink) $set .= ",link='{$link}'";

			if(!$id = update($tbl,$set,$id))
				jAlert('Во время сохранения данных произошла ошибка.');

			if($updateLink)
				update($tbl,"link='".($link.'_'.$id)."'",$id);

			// загружаем картинку
			if(sizeof((array)$_FILES[$tbl]['name'])){
				foreach($_FILES[$tbl]['name'] as $num=>$null){
					if(!$_FILES[$tbl]['name'][$num]) continue;

					remove_img($id, $tbl);
					$path = $_SERVER['DOCUMENT_ROOT']."/uploads/{$tbl}/{$id}.jpg";
					@move_uploaded_file($_FILES[$tbl]['tmp_name'][$num],$path);
					@chmod($path,0644);

					break;
				}
			}

			?><script>top.location.href = '<?=sgp($HTTP_REFERER, 'id', $id, 1)?>';</script><?
			break;
		// ----------------- обновление статуса
		case 'status':
			update_flag($tbl,'status',$id);
			break;
		// ----------------- удаление банера
		case 'del':
			remove_object($id);
			?><script>top.location.href = top.url()</script><?
			break;
		// ----------------- удаление нескольких записей
		case 'multidel':
			foreach($_POST['del'] as $id=>$v)
				remove_object($id);
			?><script>top.location.href = top.url()</script><?
			break;
		// ----------------- удаление изображения
		case 'img_del':
			remove_img($id,$tbl);
			?><script>top.location.href = '<?=$script?>?red=<?=$id?>'</script><?
			break;
	}
	exit;
}
// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET['red']))
{
	$row = gtv($tbl,'*',(int)$_GET['red']);
	$id = $row['id'];

	$title .= ' :: ' . ($id ? $row['name'] . ' (редактирование)' : 'Добавление');
	$h = $id ? $row['name'] . ' <small>(редактирование)</small>' : 'Добавление';
	$navigate = '<span></span><a href="' . $script . '">' . $h1 . '</a><span></span>' . ($id ? $row['name'] : 'Добавление');

	ob_start();
	?>
  <form action="?action=save&id=<?=$id?>" method="post" enctype="multipart/form-data" target="ajax">
    <input type="hidden" name="HTTP_REFERER" value="<?=$_SERVER['HTTP_REFERER']?>">
    <table class="table-edit">
      <tr>
        <th></th>
        <th>Название</th>
        <td><?=input('text', 'name', $row['name'])?></td>
      </tr>
			<tr>
        <th><?=help('ссылка формируется автоматически,<br>значение данного поля можно изменить')?></th>
        <th>Ссылка</th>
        <td><?=input('text', 'link', $row['link'])?></td>
      </tr>
			<?=show_tr_images($id,'Изображение','Для корректного отображения,<br>рекомендуется загружать изображение размером не более 500x500 пискелей',1,$tbl,$tbl)?>
      <tr>
        <th></th>
        <th>Краткое<br />описание</th>
        <td><?=showCK('preview',$row['preview'],'basic')?></td>
      </tr>
      <tr>
        <th></th>
        <th>Текст</th>
        <td><?=showCK('text',$row['text'])?></td>
      </tr>
      <tr>
        <th></th>
        <th>Статус</th>
        <td><?=dll(array('0'=>'заблокировано','1'=>'активно'),'name="status"',isset($row['status'])?$row['status']:1)?></td>
      </tr>
      <tr>
        <th><?=help('используется вместо названия в &lt;h1&gt;')?></th>
        <th>Заголовок</th>
        <td><?=input('text', 'h1', $row['h1'])?></td>
      </tr>
			<? foreach (array('title','keywords','description') as $v){?>
        <tr>
          <th></th>
          <th><?=$v?></th>
          <td><?=input($v == 'description' ? 'textarea' : 'text', $v, $row[$v])?></td>
        </tr>
			<?}?>
    </table>
    <div class="frm-btns">
      <input type="submit" value="<?=($id ? 'Сохранить' : 'Добавить')?>" class="btn btn-success btn-sm" onclick="loader(true)" />&nbsp;
      <input type="button" value="Отмена" class="btn btn-default btn-sm" onclick="location.href='<?=$script?>'" />
    </div>
  </form>
	<?
	$content = arr($h, ob_get_clean());
}
// -----------------ПРОСМОТР-------------------
else
{
	$cur_page = (int)$_GET['page'] ?: 1;
	$fl['sitemap'] = isset($_GET['fl']['sitemap']);
	$fl['search'] = stripslashes($_GET['fl']['search']);

	$where = '';

	//
	if($fl['search'] != ''){
		$sf = array('A.name','A.link','A.preview','A.text','A.h1','A.title','A.keywords','A.description');
		$w = '';
		foreach ($sf as $field){
			$w .= ($w ? ' OR' : '') . "\r\n{$field} LIKE '%" . $fl['search'] . "%'";
		}
		$where .= "\r\nAND ({$w}\r\n)";
	}

	$query = "SELECT A.*%s FROM {$prx}{$tbl} A";
	if($fl['sitemap']){
		$query  = sprintf($query,',S.lastmod,S.changefreq,S.priority');
		$query .= "\r\nLEFT JOIN (SELECT * FROM {$prx}sitemap WHERE `type`='{$tbl}') S ON A.id=S.id_obj";
	}	else{
		$query  = sprintf($query,'');
	}

	$query .= "\r\nWHERE 1{$where}";

	// проверяем текущую сортировку и формируем соответствующий запрос
	if($fl['sort']){
		foreach ($fl['sort'] as $f => $t){
			$query .= "\r\nORDER BY {$f} {$t}";
			break;
		}
	} else {
		$query .= "\r\nORDER BY A.sort, A.id";
	}

	ob_start();

	show_listview_btns(($fl['sitemap'] ? 'Сохранить::' : '') . 'Добавить::Удалить');
	ActiveFilters();

	if(!$fl['sitemap']){ ?>
    <div style="padding:10px 0 10px 0;">Отобразить <a href="" class="clr-orange" onclick="changeURI({'fl[sitemap]':''});return false;">Sitemap поля</a></div>
	<? } ?>

  <div class="clearfix"></div>

  <div id="filters" class="panel-white">
    <h4 class="heading">Фильтры
      <a href="#">
        <i class="fas fa-eye" title="показать фильтры">
        </i><i class="fas fa-eye-slash" title="скрыть фильтры"></i>
      </a>
    </h4>
    <div class="fbody">
      <div class="item search">
        <label>Контекстный поиск</label><br>
        <div><?=input('text', 'fl[search]', $fl['search'])?></div>
      </div>
      <button class="btn btn-danger" onclick="setFilters()"><i class="fas fa-search"></i>Поиск</button>
    </div>
  </div>

  <form name="red_frm" method="post" target="ajax">
  <table class="table-list" tbl="<?=$tbl?>">
    <thead>
    <tr>
      <th style="width:1%"><input type="checkbox" name="del" /></th>
      <th style="width:1%">№</th>
			<? if(!$fl['sort']) { ?><th nowrap><?=help('параметр с помощью которого можно изменить<br>порядок вывода объектов в клиентской части сайта')?></th><? }?>
      <th style="width:1%; text-align:center;"><img src="img/image.png" title="изображение" /></th>
      <th width="50%"><?=SortColumn('Название','A.name')?></th>
      <? if($sitemap){?>
        <th nowrap><?=SortColumn('lastmod','S.lastmod')?></th>
        <th nowrap><?=SortColumn('changefreq','S.changefreq')?></th>
        <th nowrap><?=SortColumn('priority','S.priority')?></th>
      <? }?>
      <th nowrap width="50%"><?=SortColumn('Ссылка','link');?></th>
      <th nowrap><?=SortColumn('Статус','status');?></th>
      <th style="padding:0 30px;"></th>
    </tr>
    </thead>
    <tbody>
    <?
    $res = sql($query);
    if(mysqli_num_rows($res)){
      $i=1;
      while($row = mysqli_fetch_assoc($res)){
        $id = $row['id'];
        ?>
        <tr id="item-<?=$id?>" oid="<?=$id?>" par="0">
          <th><input type="checkbox" name="del[<?=$id?>]"></th>
          <th nowrap><?=$i++?></th>
					<? if(!$fl['sort']){ ?><th nowrap align="center"><i class="fas fa-sort"></i></th><? }?>
          <th>
						<?
						$src = '/uploads/no_photo.jpg';
						$big_src = '/uploads/no_photo.jpg';
						if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/{$tbl}/{$id}.jpg")){
							$src = "/{$tbl}/60x60/{$id}.jpg";
							$big_src = "/{$tbl}/{$id}.jpg";
						}
						?>
            <a href="<?=$big_src?>" class="blueimp" title="<?=htmlspecialchars($row['name'])?>">
              <img src="<?=$src?>" align="absmiddle" style="max-height:60px; max-width:60px;" class="img-rounded">
            </a>
          </th>
          <td class="sp" nowrap><a href="?red=<?=$id?>"><?=$row['name']?></a></td>
          <? if($sitemap){?>
            <th class="sitemap sm-lastmod"><input type="text" class="form-control input-sm datepicker" name="lastmod[<?=$id?>]" value="<?=(isset($row['lastmod'])?date('d.m.Y',strtotime($row['lastmod'])):date("d.m.Y"))?>" /></th>
            <th class="sitemap sm-changefreq"><?=dll(array('always'=>'always','hourly'=>'hourly','daily'=>'daily','weekly'=>'weekly','monthly'=>'monthly','yearly'=>'yearly','never'=>'never'),'name="changefreq['.$id.']"',$row['changefreq']?$row['changefreq']:'monthly')?></th>
            <th class="sitemap sm-priority"><input type="text" class="form-control input-sm" name="priority[<?=$id?>]" value="<?=$row['priority']?$row['priority']:'0.5'?>" maxlength="3" /></th>
          <? }?>
          <td class="sp">/articles/<a href="/articles/<?=$row['link']?>.htm" class="clr-green" target="_blank"><?=$row['link']?></a>.htm</td>
          <th><?=btn_flag($row['status'],$id,'action=status&id=')?></th>
          <th nowrap><?=btn_edit($id)?></th>
        </tr>
        <?
      }
    } else {
      ?>
      <tr class="nofind">
        <td colspan="10">
          <div class="bg-warning">
            по вашему запросу ничего не найдено.
            <?=help('нет ни одной записи отвечающей критериям вашего запроса,<br>возможно вы установили неверные фильтры')?>
          </div>
        </td>
      </tr>
      <?
    }
    ?>
    </tbody>
  </table>
  </form>
	<?
	$content = arr($h, ob_get_clean());
}
require('tpl/template.php');