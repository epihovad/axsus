<?
require('inc/common.php');

$h1 = 'Вендоры';
$h = 'Общий список';
$title .= ' :: ' . $h1;
$navigate = '<span></span>Общий список';
$tbl = 'vendors';

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET['action']))
{
	$id = (int)@$_GET['id'];

	switch($_GET['action'])
	{
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

			$set = "name = '{$name}',
			        text = '{$text}',
			        in_slider = '{$in_slider}',
							status = '{$status}'";
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
		case 'in_slider':
    case 'status':
			update_flag($tbl,$_GET['action'],$id);
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
			<?=show_tr_images($id,'Изображение','Для корректного отображения,<br>рекомендуется загружать изображение размером не более 200x200 пискелей',1,$tbl,$tbl)?>
      <tr>
        <th></th>
        <th>Описание</th>
        <td><?=showCK('text', $row['text'])?></td>
      </tr>
      <tr>
        <th><?=help('отображать логотип вендора на главной странице')?></th>
        <th>На главную</th>
        <td><?=dll(array('0'=>'нет','1'=>'да'),'name="in_slider"',isset($row['in_slider'])?$row['in_slider']:0)?></td>
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
// -----------------ПРОСМОТР-------------------
else
{
	$cur_page = (int)$_GET['page'] ?: 1;
	$fl['search'] = stripslashes($_GET['fl']['search']);

	$where = '';
	if($fl['search'] != ''){
		$sf = array('name','link','text');
		$w = '';
		foreach ($sf as $field){
			$w .= ($w ? ' OR' : '') . "\r\n`{$field}` LIKE '%{$fl['search']}%'";
		}
		$where .= "\r\n AND ({$w}\r\n)";
	}

	$query .= "SELECT * FROM {$prx}{$tbl}\r\nWHERE 1{$where}";

	$r = sql($query);
	$count_obj = @mysqli_num_rows($r); // кол-во объектов в базе
	$count_obj_on_page = 30; // кол-во объектов на странице
	$count_page = ceil($count_obj/$count_obj_on_page); // количество страниц

	// проверяем текущую сортировку и формируем соответствующий запрос
	if($fl['sort']){
		foreach ($fl['sort'] as $f => $t){
			$query .= "\r\nORDER BY {$f} {$t}";
			break;
		}
	} else {
		$query .= "\r\nORDER BY name";
	}

	$query .= "\r\nLIMIT " . ($count_obj_on_page * $cur_page - $count_obj_on_page) . ',' . $count_obj_on_page;

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
      <div class="item search">
        <label>Контекстный поиск</label><br>
        <div><?=input('text', 'fl[search]', $fl['search'])?></div>
      </div>
      <button class="btn btn-danger" onclick="setFilters()"><i class="fas fa-search"></i>Поиск</button>
    </div>
  </div>

	<?=pagination($count_page, $cur_page, true, 'padding:0 0 10px;')?>
  <form name="red_frm" method="post" target="ajax">
  <table class="table-list">
    <thead>
    <tr>
      <th style="width:1%"><input type="checkbox" name="check_del" id="check_del" /></th>
      <th style="width:1%">№</th>
      <th style="width:1%; text-align:center;"><img src="img/image.png" title="изображение" /></th>
      <th width="50%"><?=SortColumn('Название','name')?></th>
      <th width="50%"><?=SortColumn('Ссылка','link')?></th>
      <th nowrap><?=SortColumn('На главную','s.in_slider')?> <?=help('отображать логотип вендора на главной странице')?></th>
      <th nowrap><?=SortColumn('Статус','status')?></th>
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
        <tr id="item-<?=$row['id']?>">
          <th><input type="checkbox" name="del[<?=$id?>]"></th>
          <th nowrap><?=$i++?></th>
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
          <td class="sp"><a href="?red=<?=$id?>"><?=$row['name']?></a></td>
          <td class="sp">/vendors/#<a href="/vendors/#<?=$row['link']?>" class="clr-green" target="_blank"><?=$row['link']?></a></td>
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