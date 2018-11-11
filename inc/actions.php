<?
@session_start();

$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../');
require($_SERVER['DOCUMENT_ROOT'].'/inc/db.php');
require($_SERVER['DOCUMENT_ROOT'].'/inc/utils.php');
require($_SERVER['DOCUMENT_ROOT'].'/inc/spec.php');

if(isset($_GET['action'])){

	// защита от спама
	$refererUrlArr = parse_url($_SERVER['HTTP_REFERER']);
	if($refererUrlArr['host'] != $_SERVER['HTTP_HOST'])
		exit;

	foreach($_POST as $k=>$v)
		$$k = clean($v);

	switch($_GET['action']){

		// -------------------
		case 'fb-save':
			// проверка имени клиента
			if(!$name){
				jAlert('Пожалуйста, укажите Ваше имя');
			}
			if(!$firma){
				jAlert('Пожалуйста, укажите название Вашей организации');
			}
			// проверка телефона
			$phone = substr(preg_replace("/\D/",'',$phone), -10);
			if(strlen($phone) != 10){
				jAlert('Некорректный номер телефона');
			}
			// проверим Email
			if(!check_mail($email)){
				jAlert('Некорректный Email');
			}
      //
			if(!$pdata = (int)$pdata){
				jAlert('Пожалуйста, примите согласасие на<br>обработку Ваших персональных данных');
			}

			$mailto = array();

			ob_start();
			?>
      <b>Имя</b>: <?=$name?><br />
      <b>Организация</b>: <?=$firma?><br />
      <b>Телефон</b>: +7<?=$phone?><br />
      <b>E-mail</b>: <?=$email?><br />
      <b>Сообщение</b>: <?=nl2br($text)?>
			<?
			$mailto['text'] = ob_get_clean();

			$set = "name = '{$name}',
			        firma = '{$firma}',
			        phone = '{$phone}',
			        email = '{$email}',
			        text = " . ($text ? "'{$text}'" : 'NULL');

			if(!$id = update('msg', $set)){
				$alert = 'Во время отправки данных произошла ошибка.<br>Администрация сайта приносит Вам свои извинения.<br>Мы уже знаем об этой проблеме и работаем над её устранением.';
				$mailto['theme'] = "AXSUS.ru - ошибка при отправке данных в форме обратной связи";
				// журнал
				update('log', "type = 'ошибка при сохранении данных в форме обратной связи', notes = '".clean($set)."'");
			} else {
				$alert = 'Уважаемый(ая) '.$name.'!<br>Ваше сообщение успешно отправлено.<br>Мы обязательно с Вами свяжемся.';
				$mailto['theme'] = '«Перезвоните мне»';
				// журнал
				update('log', "type = 'новое сообщение', link = 'msg.php?red={$id}'");
			}

			// мылим админу
			//mailTo(array(set('admin_mail')), $mailto['theme'], $mailto['text']);

			?><script>
      top.jQuery(document).jAlert('show','alert','<?=cleanJS($alert)?>',function(){
        top.jQuery('.fb-form').find("input[type=text], textarea").val('');
        top.jQuery.arcticmodal('close');
      });
      </script><?

			break;
	}
	exit;
}

if(!isset($_GET['show'])) exit;

switch($_GET['show'])
{
  case 'fb-form':

		?>
		<style>
			#fb-form { width:400px;}
			#fb-form .form-control {
				display: block;
				width: 100%;
				padding: 8px 20px 9px;
				font-size: 15px;
				line-height: 1;
				color: #2c2c2c;
				font-family:font-family: Verdana, Geneva, sans-serif;
				background-color: #ffffff;
				background-image: none;
				background-clip: padding-box;
				border: 1px solid #ced4da;
				border-radius: 25px;
			}
			#fb-form textarea.form-control { height:100px;}
			#fb-form .form-control::placeholder { color:#a0a0a0;}
      #fb-form .checkbox { padding:10px 0 20px 0;}
      #fb-form .checkbox label { color: #546e7a; font-size: 13px; line-height: 14px; }
      #fb-form .checkbox input { vertical-align: top; margin-right: 2px;}
    </style>
		<script>
			$(function () {
        Inputmask({mask: '+7 (999) 999-99-99',showMaskOnHover: false}).mask($('#fb-form input[name="phone"]'));
      })
		</script>
		<form id="fb-form" action="/inc/actions.php?action=fb-save" class="fb-form" target="ajax" method="post">
			<div class="form-group">
				<input class="form-control" type="text" name="name" placeholder="Ваше имя">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="firma" placeholder="Название организации">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="phone" placeholder="Телефон">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<textarea class="form-control" type="text" name="text" placeholder="Ваше сообщение (необязательно для заполнения)"></textarea>
			</div>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="pdata" value="1" checked> Я согласен(на) на обработку <a href="#" target="_blank">моих персональных данных</a>
        </label>
      </div>
			<div class="text-right"><button class="btn btn-primary" type="submit">Отправить</button></div>
		</form>
		<?

    break;
}