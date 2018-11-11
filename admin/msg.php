<?
require('inc/common.php');

$h1 = 'Сообщения';
$h = 'Общий список';
$title .= ' :: ' . $h1;
$navigate = '<span></span>' . $h;
$tbl = 'msg';

// ------------------- СОХРАНЕНИЕ ------------------------
if(isset($_GET['action']))
{
	$id = (int)@$_GET['id'];
	
	switch($_GET['action'])
	{
		// ----------------- сохранение
		case 'save':
			if(!$id) exit;
			$notes = clean($_POST['notes']);
			if(!$id = update($tbl,"notes=".($notes?"'{$notes}'":"NULL"),$id))
				jAlert('Во время сохранения данных произошла ошибка.');

			?><script>top.location.href = '<?=sgp($HTTP_REFERER, 'id', $id, 1)?>';</script><?
			break;
		// ----------------- удаление
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
	}
	exit;
}
// ------------------ РЕДАКТИРОВАНИЕ --------------------
elseif(isset($_GET['red']))
{
	if(!$id = (int)$_GET['red']) { header("Location: {$script}"); exit; }
	if(!$row = gtv($tbl,'*',$id)) { header("Location: {$script}"); exit; }

	$title .= " :: {$row['email']} (редактирование)";
	$h = "{$row['email']} <small>(редактирование)</small>";
	$navigate = '<span></span><a href="' . $script . '">' . $h1 . '</a><span></span>' . $row['email'];

	ob_start();
	?>
  <form action="?action=save&id=<?=$id?>" method="post" target="ajax">
    <input type="hidden" name="HTTP_REFERER" value="<?=$_SERVER['HTTP_REFERER']?>">
    <table class="table-edit">
      <tr>
        <th></th>
        <th>Дата</th>
        <td><?=date('d.m.Y H:i',strtotime($row['date']))?></td>
      </tr>
      <tr>
        <th></th>
        <th>Имя</th>
        <td><?=$row['name']?></td>
      </tr>
      <tr>
        <th></th>
        <th>Организация</th>
        <td><?=$row['firma']?></td>
      </tr>
      <tr>
        <th></th>
        <th>Телефон</th>
        <td>+7<?=$row['phone']?></td>
      </tr>
      <tr>
        <th></th>
        <th>Email</th>
        <td><?=$row['email']?></td>
      </tr>
      <tr>
        <th></th>
        <th>Сообщение</th>
        <td><?=nl2br($row['text'])?></td>
      </tr>
      <tr>
        <th></th>
        <th>Примечание</th>
        <td><?=input('textarea','note',$row['note'])?></td>
      </tr>
    </table>
    <div class="frm-btns">
      <input type="submit" value="<?=($id ? 'Сохранить' : 'Добавить')?>" class="btn btn-success btn-sm" onclick="loader(true)" />&nbsp;
      <input type="button" value="Отмена" class="btn btn-default btn-sm" onclick="location.href='<?=$script?>'" />
    </div>
  </form>
  <?
  $content = ob_get_clean();
}
// -----------------ПРОСМОТР-------------------
else
{
	$cur_page = (int)$_GET['page'] ?: 1;
	$fl['sort'] = $_GET['fl']['sort'];
	$fl['search'] = stripslashes($_GET['fl']['search']);
	
	$where = '';
	if($fl['search'] != ''){
		$sf = array('name','firma','phone','email','text','notes');
		$w = '';
		foreach ($sf as $field){
			$w .= ($w ? ' OR' : '') . "\r\n`{$field}` LIKE '%{$fl['search']}%'";
		}
		$where .= "\r\n AND ({$w}\r\n)";
	}
	if($f_context) $where .= " AND (name LIKE '%{$f_context}%' OR
																	firma LIKE '%{$f_context}%' OR
																	phone LIKE '%{$f_context}%' OR
	                                email LIKE '%{$f_context}%' OR
																	text LIKE '%{$f_context}%' OR
																	notes LIKE '%{$f_context}%')";

	$query = "SELECT * FROM {$prx}{$tbl} WHERE 1{$where}";

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
		$query .= "\r\nORDER BY id DESC";
	}

	$query .= "\r\nLIMIT " . ($count_obj_on_page * $cur_page - $count_obj_on_page) . ',' . $count_obj_on_page;

	ob_start();

	show_listview_btns('Удалить');
	ActiveFilters();
	?>

	<div class="clearfix"></div>

  <div id="filters" class="panel-white">
    <h4 class="heading">Фильтры
      <a href="#"<?//=$show_filters?' class="active"':''?>>
        <i class="fas fa-eye" title="показать фильтры">
        </i><i class="fas fa-eye-slash" title="скрыть фильтры"></i>
      </a>
    </h4>
    <div class="fbody<?//=$show_filters?' active':''?>">
      <div class="form-group search">
        <label>Контекстный поиск</label><br>
        <input class="form-control input-sm" type="text" value="<?=htmlspecialchars($fl['search'])?>">
        <button type="button" class="btn btn-danger btn-xs"><i class="fas fa-search"></i>найти</button>
      </div>
    </div>
  </div>

	<?=pagination($count_page, $cur_page, true, 'padding:0 0 10px;')?>

  <form id="ftl" method="post" target="ajax">
    <table class="table-list">
      <thead>
      <tr>
        <th nowrap style="text-align:center"><input type="checkbox" name="del" /></th>
        <th>№</th>
        <th width="15%"><?=SortColumn('Название','name')?></th>
        <th width="15%"><?=SortColumn('Организация','firma')?></th>
        <th width="15%"><?=SortColumn('Телефон','phone')?></th>
        <th width="15%"><?=SortColumn('Email','email')?></th>
        <th width="40%"><?=SortColumn('Сообщение','text')?></th>
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
            <td class="sp" nowrap><a href="?red=<?=$id?>"><?=$row['name']?></a></td>
            <td class="sp" nowrap><a href="?red=<?=$id?>"><?=$row['firma']?></a></td>
            <td class="sp" nowrap><a href="?red=<?=$id?>"><?=$row['phone']?></a></td>
            <td class="sp" nowrap><a href="?red=<?=$id?>"><?=$row['email']?></a></td>
            <td class="sp"><?=nl2br($row['text'])?></td>
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
							<?=help('нет ни одной записи отвечающей критериям вашего запроса,<br>возможно Вы установили неверные фильтры')?>
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