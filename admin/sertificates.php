<?
require('inc/common.php');

$h1 = 'Сертификаты';
$h = 'Общий список';
$title .= ' :: ' . $h1;
$navigate = '<span></span>' . $h;
$tbl = 'sertificates';

// ------------------- СОХРАНЕНИЕ ------------------------
if(isset($_GET['action']))
{
	$id = (int)$_GET['id'];

	switch($_GET['action'])
	{
		// ----------------- сохранение
		case 'save':
			foreach($_POST as $key=>$val)
				$$key = clean($val);

			$updateLink = false;
			$where = $id ? " AND id<>'{$id}'" : '';

			if($link){
				if(getField("SELECT id FROM {$prx}{$tbl} WHERE link='{$link}'{$where}"))
					$updateLink = true;
			} else {
				$link = makeUrl($name);
				if(getField("SELECT id FROM {$prx}{$tbl} WHERE link='{$link}'{$where}"))
					$updateLink = true;
			}

			// полная ссылка на фото
			$rb = gtv('gallery_catalog','*',$id_catalog);
			$url = getCatUrl($rb,false,'gallery_catalog','gallery');

			$set = "id_catalog = '{$id_catalog}',
			        url = '{$url}',
							name = '{$name}',
							text = ".($text?"'{$text}'":"NULL").",
							status = '{$status}',
							`date` = '" . ($date ? formatDateTime($date) : date('Y-m-d')) . "'";
			if(!$updateLink) $set .= ",link='{$link}'";

			if(!$id = update($tbl,$set,$id))
				jAlert('Во время сохранения данных произошла ошибка.');

			if($updateLink)
				update($tbl,"link='".($link.'_'.$id)."'",$id);

			// загружаем картинку
			if(sizeof((array)$_FILES[$tbl]['name']))
			{
				foreach($_FILES[$tbl]['name'] as $num=>$null)
				{
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
		// ----------------- статус
		case 'status':
			update_flag($tbl,$_GET['action'],$id);
			break;
		// ----------------- удаление одной записи
		case 'del':
			remove_object($id);
			?><script>top.location.href = top.url()</script><?
			break;
		// ----------------- удаление нескольких записей
		case 'multidel':
			foreach($_POST['del'] as $id=>$v) {
				remove_object($id);
			}
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
// ------------------ РЕДАКТИРОВАНИЕ --------------------
elseif(isset($_GET['red']))
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
        <th>Рубрика</th>
        <td><?=dllTree("SELECT * FROM {$prx}gallery_catalog ORDER BY sort,id",'name="id_catalog"',$row['id_catalog'],array('0'=>'без подчинения'),$id)?></td>
      </tr>
      <tr>
        <th></th>
        <th>Название</th>
        <td><?=input('text', 'name', $row['name'])?></td>
      </tr>
      <tr>
        <th><?=help('при отсутствии значения в данном поле<br>ссылка формируется автоматически')?></th>
        <th>Ссылка</th>
        <td><?=input('text', 'link', $row['link'])?></td>
      </tr>
			<?=show_tr_images($id,'Фото','',1,$tbl,$tbl)?>
      <tr>
        <th><?=help('При добавлении/изменении объекта, если поле пустое,<br>дата формируется автоматически (присваивается текущая дата).<br>Дата служит для сортировки объектов в клиентской части сайта.')?></th>
        <th>Дата добавления</th>
        <td><?=input('date', 'date', isset($row['date']) ? date('d.m.Y', strtotime($row['date'])) : date('d.m.Y'))?></td>
      </tr>
      <tr>
        <th></th>
        <th>Описание</th>
        <td><?=showCK('text',$row['text'], 'basic')?></td>
      </tr>
      <tr>
        <th></th>
        <th>Статус</th>
        <td><?=dll(array('0'=>'заблокировано','1'=>'активно'),'name="status"',isset($row['status'])?$row['status']:1)?></td>
      </tr>
    </table>
    <div class="frm-btns">
      <input type="submit" value="<?=($id ? 'Сохранить' : 'Добавить')?>" class="btn btn-success btn-sm" onclick="loader(true)" />&nbsp;
      <input type="button" value="Отмена" class="btn btn-default btn-sm" onclick="location.href='<?=$script?>'" />
    </div>
  </form>
	<?
	$content = arr($h, ob_get_clean());
}
// -----------------СПИСОК-------------------
else {

	$cur_page = (int)$_GET['page'] ?: 1;
	$fl['vendors'] = (int)$_GET['fl']['vendors'];
	$fl['search'] = stripslashes($_GET['fl']['search']);

	$filters['vendors'] = "выбор сертификатов по вендору";
	$filters['type'] = "выбор сертификатов по типу";

	$where = '';
	if($fl['vendors']){
		$where .= "\r\nAND CONCAT(',',s.id_vendor,',') LIKE '%,{$fl['id_vendors']},%'";
	}
	if($fl['search'] != ''){
		$sf = array('name','text');
		$w = '';
		foreach ($sf as $field){
			$w .= ($w ? ' OR' : '') . "\r\n`{$field}` LIKE '%{$fl['search']}%'";
		}
		$where .= "\r\n AND ({$w}\r\n)";
	}

	$query = "SELECT s.*, v.name as vendor
	          FROM {$prx}{$tbl} s
	          JOIN {$prx}vendors v ON v.id = s.id_vendor
	          WHERE 1{$where}";

	$r = sql($query);
	$count_obj = @mysqli_num_rows($r); // кол-во объектов в базе
	$count_obj_on_page = 30; // кол-во объектов на странице
	$count_page = ceil($count_obj/$count_obj_on_page); // количество страниц

  $query .= "\r\nORDER BY s.sort,s.id LIMIT " . ($count_obj_on_page * $cur_page - $count_obj_on_page) . ',' . $count_obj_on_page;

  ob_start();
	//pre($query);

	show_listview_btns('Добавить::Удалить');
	ActiveFilters();
	?>

  <div class="clearfix"></div>

  <div id="filters" class="panel-white">
    <h4 class="heading">Фильтры
      <a href="#">
        <i class="fas fa-eye" title="показать фильтры">
        </i><i class="fas fa-eye-slash" title="скрыть фильтры"></i>
      </a>
    </h4>
    <div class="fbody">
      <div class="item">
        <label>Вендор</label>
				<?=dll("SELECT * FROM {$prx}vendors ORDER BY name", 'name="fl[vendors]" multiple data-placeholder="-- неважно --"', $fl['vendors']?explode(',',$fl['vendors']):null, null, 'chosen')?>
      </div>
      <div class="item">
        <label>Тип сертификата</label>
				<?=dllEnum($tbl, 'type', 'name="fl[type]"', $fl['type']?explode(',',$fl['type']):null, array('-- неважно --'))?>
      </div>
      <div class="item search">
        <label>Контекстный поиск</label><br>
        <div><?=input('text', 'fl[search]', $fl['search'])?></div>
      </div>
      <button class="btn btn-danger" onclick="setFilters()"><i class="fas fa-search"></i>Поиск</button>
    </div>
  </div>

	<?=pagination($count_page, $cur_page, true, 'padding:0 0 10px;')?>
  <form id="ftl" method="post" target="ajax">
    <table class="table-list">
      <thead>
      <tr>
        <th><input type="checkbox" name="del" /></th>
        <th>№</th>
				<? if(!$fl['sort']) { ?><th nowrap><?=help('параметр с помощью которого можно изменить<br>порядок вывода объектов в клиентской части сайта')?></th><? }?>
				<th style="text-align:center"><img src="img/image.png" title="Фото" /></th>
        <th width="50%"><?=SortColumn('Вендор','v.name')?></th>
        <th width="50%"><?=SortColumn('Название','s.name')?></th>
				<th nowrap><?=SortColumn('Тип','s.type')?></th>
        <th nowrap><?=SortColumn('В слайдер','s.in_slider')?> <?=help('отображать сертификат в слайдере')?></th>
        <th nowrap><?=SortColumn('Статус','s.status')?></th>
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
						<th style="padding:3px 5px;">
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
            <td class="sp" nowrap><?=$row['vendor']?></td>
            <td class="sp" nowrap><a href="?red=<?=$id?>"><?=$row['name']?></a></td>
            <td class="sp" nowrap><?=$row['type']?></td>
            <th><?=btn_flag($row['in_slider'],$id,'action=in_slider&id=')?></th>
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
	<?=pagination($count_page, $cur_page, true, 'padding:10px 0 0;')?>
	<?
	$content = arr($h, ob_get_clean());
}
require('tpl/template.php');