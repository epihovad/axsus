<?
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/PHPMailer-master/PHPMailerAutoload.php');

class Mailer extends PHPMailer {
	public function __construct() {

		$this->isSMTP();
		$this->CharSet = 'utf-8';
		$this->Port = '25';
		$this->SMTPAuth = true;
		$this->SMTPDebug = 0;
		$this->Debugoutput = 'html';
		$this->isHTML(true);
		$this->Host = 'smtp.mail.ru';
		$this->Username = '';
		$this->Password = 'P@ssw0rd';
		$this->setFrom('info@axsus.ru', 'АКСИС ПРОЕКТЫ');
	}

	// $emails - массив адресатов array('test1@mail.ru'=>'Тест Петрович','test2@mail.ru'=>'Тест Иванович')
	public function mailTo($to,$subject,$body){
		$this->Subject = $subject;
		$this->Body = $body;
		foreach ($to as $email){
			$this->addAddress($email);
		}
		return $this->send();
	}
}