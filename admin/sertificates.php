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

			$set = "id_vendor = '{$id_vendor}',
							name = '{$name}',
							`date` = " . ($date ? ("'" . formatDateTime($date) . "'") : 'NULL') . ",
							`date_expiration` = " . ($date_expiration ? ("'" . formatDateTime($date_expiration) . "'") : 'NULL') . ",
							text = ".($text?"'{$text}'":"NULL").",
							type = '{$type}',
							in_slider = '{$in_slider}',
							status = '{$status}'";

			if(!$id = update($tbl,$set,$id))
				jAlert('Во время сохранения данных произошла ошибка.');

			// загружаем картинку
			if(sizeof((array)$_FILES[$tbl]['name'])){
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
		case 'in_slider':
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
			<?=show_tr_images($id,'Изображение','Для корректного отображения,<br>рекомендуется загружать изображение размером не более 1000x1000 пискелей',1,$tbl,$tbl)?>
      <tr>
        <th><?=help('необязательное для заполнения')?></th>
        <th>Название</th>
        <td><?=input('text', 'name', $row['name'])?></td>
      </tr>
      <tr>
        <th><?=help('Дата получения сертификата')?></th>
        <th>Дата получения</th>
        <td><?=input('date', 'date', isset($row['date']) ? date('d.m.Y', strtotime($row['date'])) : null)?></td>
      </tr>
      <tr>
        <th><?=help('Дата истечения срока действия сертификата')?></th>
        <th>Дата истечения</th>
        <td><?=input('date', 'date_expiration', isset($row['date_expiration']) ? date('d.m.Y', strtotime($row['date_expiration'])) : null)?></td>
      </tr>
      <tr>
        <th></th>
        <th>Вендор</th>
        <td><?=dll("SELECT * FROM {$prx}vendors ORDER BY name",'name="id_vendor"',$row['id_vendor'],array('null'=>'-- без привязки --'))?></td>
      </tr>
      <tr>
        <th></th>
        <th>Тип</th>
        <td><?=dllEnum($tbl, 'type', 'name="type"', $row['type'])?></td>
      </tr>
      <tr>
        <th></th>
        <th>В слайдер</th>
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
// -----------------СПИСОК-------------------
else {

	$cur_page = (int)$_GET['page'] ?: 1;

	$get_prm = array('vendors','type','day_start','day_end','day_exp_start','day_exp_end','sort');
	foreach ($get_prm as $k){
		$fl[$k] = $_GET['fl'][$k];
	}
	$fl['search'] = stripslashes($_GET['fl']['search']);

	$filters['vendors'] = "выбор сертификатов по вендору";
	$filters['type'] = "выбор сертификатов по типу";
	$filters['day_start'] = "выбор сертификатов по Дате (С даты)";
	$filters['day_end'] = "выбор сертификатов по Дате (ПО дату)";

	$args = array();
	$where = '';

	$filtersArr = array(
	  'vendors' => 'v.name',
		'type' => 's.type',
	);
	foreach ($filtersArr as $type => $field){
    $w = '';
    $vals = explode(',', $fl[$type]);
    foreach ($vals as $val){
      if($val && $val !== 'null'){
        $w .= ($w ? ' OR' : '') . "\r\n{$field} = ?";
        $args[] = $val;
      }
    }
    if($w){
      $where .= "\r\nAND ({$w}\r\n)";
    }
	}
	//
	if($fl['day_start']){     $where .= "\r\nAND s.date >= '" . date('Y-m-d', strtotime($fl['day_start'])) . "'"; }
	if($fl['day_end']){       $where .= "\r\nAND s.date < '" . date('Y-m-d', strtotime($fl['day_end'] . '+1 days')) . "'"; }
	if($fl['day_exp_start']){ $where .= "\r\nAND s.date_expiration >= '" . date('Y-m-d', strtotime($fl['day_exp_start'])) . "'"; }
	if($fl['day_exp_end']){   $where .= "\r\nAND s.date_expiration < '" . date('Y-m-d', strtotime($fl['day_exp_end'] . '+1 days')) . "'"; }

	$query  = "SELECT s.*, v.name as vendor\r\n";
	$query .= "FROM {$prx}{$tbl} s\r\n";
	$query .= "LEFT JOIN {$prx}vendors v ON v.id = s.id_vendor\r\n";
	$query .= "WHERE 1{$where}";

	/*$r = sql($query);
	$count_obj = @mysqli_num_rows($r); // кол-во объектов в базе
	$count_obj_on_page = 2; // кол-во объектов на странице
	$count_page = ceil($count_obj/$count_obj_on_page); // количество страниц
*/
	if($fl['sort']){
		foreach ($fl['sort'] as $f => $t){
			$query .= "\r\nORDER BY {$f} {$t}";
			break;
		}
	} else {
		$query .= "\r\nORDER BY s.sort,s.id";
	}

  //$query .= "\r\nLIMIT " . ($count_obj_on_page * $cur_page - $count_obj_on_page) . ',' . $count_obj_on_page;

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
				<?=dllEnum($tbl, 'type', 'name="fl[type]"', $fl['type']?explode(',',$fl['type']):null, array('null'=>'-- неважно --'))?>
      </div>
      <div class="item">
        <label>Дата получения сертификата</label>
        <div>с <?=input('date',"fl[day_start]",$fl['day_start'])?> по <?=input('date',"fl[day_end]",$fl['day_end'])?></div>
      </div>
      <div class="item">
        <label>Дата истечения срока действия сертификата</label>
        <div>с <?=input('date',"fl[day_exp_start]",$fl['day_exp_start'])?> по <?=input('date',"fl[day_exp_end]",$fl['day_exp_end'])?></div>
      </div>
      <div class="item search">
        <label>Контекстный поиск</label><br>
        <div><?=input('text', 'fl[search]', $fl['search'])?></div>
      </div>
      <button class="btn btn-danger" onclick="setFilters()"><i class="fas fa-search"></i>Поиск</button>
    </div>
  </div>

	<?//=pagination($count_page, $cur_page, true, 'padding:0 0 10px;')?>
  <form id="ftl" method="post" target="ajax">
    <table class="table-list" tbl="<?=$tbl?>">
      <thead>
      <tr>
        <th><input type="checkbox" name="del" /></th>
        <th>№</th>
				<? if(!$fl['sort']) { ?><th nowrap><?=help('параметр с помощью которого можно изменить<br>порядок вывода объектов в клиентской части сайта')?></th><? }?>
				<th style="text-align:center"><img src="img/image.png" title="Фото" /></th>
        <th width="33%"><?=SortColumn('Вендор','v.name')?></th>
        <th width="33%"><?=SortColumn('Название','s.name')?></th>
				<th width="33%"><?=SortColumn('Тип','s.type')?></th>
        <th nowrap><?=SortColumn('Дата получения','s.date')?> <?=help('Дата получения сертификата')?></th>
        <th nowrap><?=SortColumn('Дата истечения','s.date_expiration')?> <?=help('Дата истечения срока действия сертификата')?></th>
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
            <th nowrap align="center"><?=$row['date']?date('d.m.Y', strtotime($row['date'])):null?></th>
            <th nowrap align="center"><?=$row['date_expiration']?date('d.m.Y', strtotime($row['date_expiration'])):null?></th>
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