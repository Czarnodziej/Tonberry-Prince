<?php
App::uses('MyModel', 'Tools.Model');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

class MyModelTest extends MyCakeTestCase {

	public $Model;

	public $App;

	public $modelName = 'User';

	public $fixtures = array('core.user', 'core.post', 'core.author');

	public function setUp() {
		parent::setUp();

		$this->Model = ClassRegistry::init('Post');

		$this->App = ClassRegistry::init('User');
	}

	public function testObject() {
		$this->Model = ClassRegistry::init('MyModel');
		$this->assertTrue(is_object($this->Model));
		$this->assertInstanceOf('MyModel', $this->Model);
	}

	public function testGet() {
		$record = $this->Model->get(2);
		$this->assertEquals(2, $record['Post']['id']);

		$record = $this->Model->get(2, array('fields'=>'id', 'created'));
		$this->assertEquals(2, count($record['Post']));

		$record = $this->Model->get(2, array('fields'=>'id', 'title', 'body'), array('Author'));
		$this->assertEquals(3, $record['Author']['id']);

	}

	public function testEnum() {
		$array = array(
			1 => 'foo',
			2 => 'bar',
		);

		$res = AppTestModel::enum(null, $array, false);
		$this->assertEquals($array, $res);

		$res = AppTestModel::enum(2, $array, false);
		$this->assertEquals('bar', $res);

		$res = AppTestModel::enum('2', $array, false);
		$this->assertEquals('bar', $res);

		$res = AppTestModel::enum(3, $array, false);
		$this->assertFalse($res);
	}

	/**
	 * more tests in MyModel Test directly
	 */
	public function testGetFalse() {
		$this->App->order = array();
		$is = $this->App->get('xyz');
		$this->assertSame(array(), $is);
	}

	/**
	 * test auto inc value of the current table
	 */
	public function testGetNextAutoIncrement() {
		$this->out($this->_header(__FUNCTION__));
		$is = $this->App->getNextAutoIncrement();
		$this->out(returns($is));

		$schema = $this->App->schema('id');
		if ($schema['length'] == 36) {
			$this->assertFalse($is);
		} else {
			$this->assertTrue(is_int($is));
		}
	}

	public function testDeconstruct() {
		$data = array('year'=>'2010', 'month'=>'10', 'day'=>11);
		$res = $this->App->deconstruct('User.dob', $data);
		$this->assertEquals('2010-10-11', $res);

		$res = $this->App->deconstruct('User.dob', $data, 'datetime');
		$this->assertEquals('2010-10-11 00:00:00', $res);
	}

	/**
	 * test that strings are correctly escaped using '
	 */
	public function testEscapeValue() {
		$res = $this->App->escapeValue(4);
		$this->assertSame(4, $res);

		$res = $this->App->escapeValue('4');
		$this->assertSame('4', $res);

		$res = $this->App->escapeValue('a');
		$this->assertSame('\'a\'', $res);

		$res = $this->App->escapeValue(true);
		$this->assertSame(1, $res);

		$res = $this->App->escapeValue(false);
		$this->assertSame(0, $res);

		$res = $this->App->escapeValue(null);
		$this->assertSame(null, $res);

		# comparison to cakes escapeField here (which use ` to escape)
		$res = $this->App->escapeField('dob');
		$this->assertSame('`User`.`dob`', $res);
	}

	/**
	 * test truncate
	 */
	public function testTruncate() {
		$is = $this->App->find('count');
		$this->assertEquals(4, $is);

		$is = $this->App->getNextAutoIncrement();
		$this->assertEquals(5, $is);

		$is = $this->App->truncate();
		$is = $this->App->find('count');
		$this->assertEquals(0, $is);

		$is = $this->App->getNextAutoIncrement();
		$this->assertEquals(1, $is);
	}

	public function testValidateIdentical() {
		$this->out($this->_header(__FUNCTION__));
		$this->App->data = array($this->App->alias=>array('y'=>'efg'));
		$is = $this->App->validateIdentical(array('x'=>'efg'), 'y');
		$this->assertTrue($is);

		$this->App->data = array($this->App->alias=>array('y'=>'2'));
		$is = $this->App->validateIdentical(array('x'=>2), 'y');
		$this->assertFalse($is);

		$this->App->data = array($this->App->alias=>array('y'=>'3'));
		$is = $this->App->validateIdentical(array('x'=>3), 'y', array('cast'=>'int'));
		$this->assertTrue($is);

		$this->App->data = array($this->App->alias=>array('y'=>'3'));
		$is = $this->App->validateIdentical(array('x'=>3), 'y', array('cast'=>'string'));
		$this->assertTrue($is);
	}


	public function testValidateKey() {
		$this->out($this->_header(__FUNCTION__));
		//$this->App->data = array($this->App->alias=>array('y'=>'efg'));
		$testModel = new AppTestModel();

		$is = $testModel->validateKey(array('id'=>'2'));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('id'=>2));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('id'=>'4e6f-a2f2-19a4ab957338'));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('id'=>'4dff6725-f0e8-4e6f-a2f2-19a4ab957338'));
		$this->assertTrue($is);

		$is = $testModel->validateKey(array('id'=>''));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('id'=>''), array('allowEmpty'=>true));
		$this->assertTrue($is);


		$is = $testModel->validateKey(array('foreign_id'=>'2'));
		$this->assertTrue($is);

		$is = $testModel->validateKey(array('foreign_id'=>2));
		$this->assertTrue($is);

		$is = $testModel->validateKey(array('foreign_id'=>2.3));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('foreign_id'=>-2));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('foreign_id'=>'4dff6725-f0e8-4e6f-a2f2-19a4ab957338'));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('foreign_id'=>0));
		$this->assertFalse($is);

		$is = $testModel->validateKey(array('foreign_id'=>0), array('allowEmpty'=>true));
		$this->assertTrue($is);
	}


	public function testValidateEnum() {
		$this->out($this->_header(__FUNCTION__));
		//$this->App->data = array($this->App->alias=>array('y'=>'efg'));
		$testModel = new AppTestModel();
		$is = $testModel->validateEnum(array('x'=>'1'), true);
		$this->assertTrue($is);

		$is = $testModel->validateEnum(array('x'=>'4'), true);
		$this->assertFalse($is);

		$is = $testModel->validateEnum(array('x'=>'5'), true, array('4', '5'));
		$this->assertTrue($is);

		$is = $testModel->validateEnum(array('some_key'=>'3'), 'x', array('4', '5'));
		$this->assertTrue($is);
	}

	public function testGuaranteeFields() {
		$this->out($this->_header(__FUNCTION__));
		$res = $this->App->guaranteeFields(array());
		debug($res);
		$this->assertTrue(empty($res));

		$res = $this->App->guaranteeFields(array('x', 'y'));
		debug($res);
		$this->assertTrue(!empty($res));
		$this->assertEquals($res, array($this->modelName=>array('x'=>'', 'y'=>'')));

		$res = $this->App->guaranteeFields(array('x', 'OtherModel.y'));
		debug($res);
		$this->assertTrue(!empty($res));
		$this->assertEquals($res, array($this->modelName=>array('x'=>''), 'OtherModel'=>array('y'=>'')));
	}

	public function testSet() {
		$this->out($this->_header(__FUNCTION__));
		$data = array($this->modelName=>array('x'=>'hey'), 'OtherModel'=>array('y'=>''));
		$this->App->data = array();

		$res = $this->App->set($data, null, array('x', 'z'));
		$this->out($res);
		$this->assertTrue(!empty($res));
		$this->assertEquals($res, array($this->modelName=>array('x'=>'hey', 'z'=>''), 'OtherModel'=>array('y'=>'')));

		$res = $this->App->data;
		$this->out($res);
		$this->assertTrue(!empty($res));
		$this->assertEquals($res, array($this->modelName=>array('x'=>'hey', 'z'=>''), 'OtherModel'=>array('y'=>'')));
	}

	public function testValidateWithGuaranteeFields() {
		$this->out($this->_header(__FUNCTION__));
		$data = array($this->modelName=>array('x'=>'hey'), 'OtherModel'=>array('y'=>''));

		$data = $this->App->guaranteeFields(array('x', 'z'), $data);
		$this->out($data);
		$this->assertTrue(!empty($data));
		$this->assertEquals(array($this->modelName=>array('x'=>'hey', 'z'=>''), 'OtherModel'=>array('y'=>'')), $data);

		$res = $this->App->set($data);
		$this->out($res);
		$this->assertTrue(!empty($res));
		$this->assertEquals($res, array($this->modelName=>array('x'=>'hey', 'z'=>''), 'OtherModel'=>array('y'=>'')));
	}

	// not really working?
	public function testBlacklist() {
		$this->out($this->_header(__FUNCTION__));
		$data = array($this->modelName=>array('name'=>'e', 'x'=>'hey'), 'OtherModel'=>array('y'=>''));

		$schema = $this->App->schema();

		$data = $this->App->blacklist(array('x', 'z'));
		$this->out($data);
		if (!empty($schema)) {
			$this->assertTrue(!empty($data));
		} else {
			$this->assertTrue(empty($data));
		}

		//$this->assertEquals($data, array($this->modelName=>array('x'=>'hey', 'z'=>''), 'OtherModel'=>array('y'=>'')));
	}


	public function testAppInvalidate() {
		$this->out($this->_header(__FUNCTION__));
		$this->App->create();
		$this->App->invalidate('fieldx', __('e %s f', 33));
		$res = $this->App->validationErrors;
		$this->out($res);
		$this->assertTrue(!empty($res));

		$this->App->create();
		$this->App->invalidate('Model.fieldy', __('e %s f %s g', 33, 'xyz'));
		$res = $this->App->validationErrors;
		$this->out($res);
		$this->assertTrue(!empty($res) && $res['Model.fieldy'][0] == 'e 33 f xyz g');

		$this->App->create();
		$this->App->invalidate('fieldy', __('e %s f %s g %s', true, 'xyz', 55));
		$res = $this->App->validationErrors;
		$this->out($res);
		$this->assertTrue(!empty($res) && $res['fieldy'][0] == 'e 1 f xyz g 55');

		$this->App->create();
		$this->App->invalidate('fieldy', array('valErrMandatoryField'));
		$res = $this->App->validationErrors;
		$this->out($res);
		$this->assertTrue(!empty($res));

		$this->App->create();
		$this->App->invalidate('fieldy', 'valErrMandatoryField');
		$res = $this->App->validationErrors;
		$this->out($res);
		$this->assertTrue(!empty($res));

		$this->App->create();
		$this->App->invalidate('fieldy', __('a %s b %s c %s %s %s %s %s h %s', 1, 2, 3, 4, 5, 6, 7, 8));
		$res = $this->App->validationErrors;
		$this->out($res);
		$this->assertTrue(!empty($res) && $res['fieldy'][0] == 'a 1 b 2 c 3 4 5 6 7 h 8');

	}

	public function testAppValidateDate() {
		$this->out($this->_header(__FUNCTION__));
		$data = array('field' => '2010-01-22');
		$res = $this->App->validateDate($data);
		debug($res);
		$this->assertTrue($res);

		$data = array('field' => '2010-02-29');
		$res = $this->App->validateDate($data);
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-22'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDate($data, array('after'=>'after'));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-24 11:11:11'));
		$data = array('field' => '2010-02-23');
		$res = $this->App->validateDate($data, array('after'=>'after'));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-25'));
		$data = array('field' => '2010-02-25');
		$res = $this->App->validateDate($data, array('after'=>'after'));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-25'));
		$data = array('field' => '2010-02-25');
		$res = $this->App->validateDate($data, array('after'=>'after', 'min'=>1));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-24'));
		$data = array('field' => '2010-02-25');
		$res = $this->App->validateDate($data, array('after'=>'after', 'min'=>2));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-24'));
		$data = array('field' => '2010-02-25');
		$res = $this->App->validateDate($data, array('after'=>'after', 'min'=>1));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-24'));
		$data = array('field' => '2010-02-25');
		$res = $this->App->validateDate($data, array('after'=>'after', 'min'=>2));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('before'=>'2010-02-24'));
		$data = array('field' => '2010-02-24');
		$res = $this->App->validateDate($data, array('before'=>'before', 'min'=>1));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('before'=>'2010-02-25'));
		$data = array('field' => '2010-02-24');
		$res = $this->App->validateDate($data, array('before'=>'before', 'min'=>1));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('before'=>'2010-02-25'));
		$data = array('field' => '2010-02-24');
		$res = $this->App->validateDate($data, array('before'=>'before', 'min'=>2));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('before'=>'2010-02-26'));
		$data = array('field' => '2010-02-24');
		$res = $this->App->validateDate($data, array('before'=>'before', 'min'=>2));
		debug($res);
		$this->assertTrue($res);
	}

	public function testAppValidateDatetime() {
		$this->out($this->_header(__FUNCTION__));
		$data = array('field' => '2010-01-22 11:11:11');
		$res = $this->App->validateDatetime($data);
		debug($res);
		$this->assertTrue($res);

		$data = array('field' => '2010-01-22 11:61:11');
		$res = $this->App->validateDatetime($data);
		debug($res);
		$this->assertFalse($res);

		$data = array('field' => '2010-02-29 11:11:11');
		$res = $this->App->validateDatetime($data);
		debug($res);
		$this->assertFalse($res);

		$data = array('field' => '');
		$res = $this->App->validateDatetime($data, array('allowEmpty'=>true));
		debug($res);
		$this->assertTrue($res);

		$data = array('field' => '0000-00-00 00:00:00');
		$res = $this->App->validateDatetime($data, array('allowEmpty'=>true));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-22 11:11:11'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDatetime($data, array('after'=>'after'));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-24 11:11:11'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDatetime($data, array('after'=>'after'));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-23 11:11:11'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDatetime($data, array('after'=>'after'));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-23 11:11:11'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDatetime($data, array('after'=>'after', 'min'=>1));
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-23 11:11:11'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDatetime($data, array('after'=>'after', 'min'=>0));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-23 11:11:10'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDatetime($data, array('after'=>'after'));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-23 11:11:12'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateDatetime($data, array('after'=>'after'));
		debug($res);
		$this->assertFalse($res);

	}

	public function testAppValidateTime() {
		$this->out($this->_header(__FUNCTION__));
		$data = array('field' => '11:21:11');
		$res = $this->App->validateTime($data);
		debug($res);
		$this->assertTrue($res);

		$data = array('field' => '11:71:11');
		$res = $this->App->validateTime($data);
		debug($res);
		$this->assertFalse($res);

		$this->App->data = array($this->App->alias=>array('before'=>'2010-02-23 11:11:12'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateTime($data, array('before'=>'before'));
		debug($res);
		$this->assertTrue($res);

		$this->App->data = array($this->App->alias=>array('after'=>'2010-02-23 11:11:12'));
		$data = array('field' => '2010-02-23 11:11:11');
		$res = $this->App->validateTime($data, array('after'=>'after'));
		debug($res);
		$this->assertFalse($res);
	}

	public function testAppValidateUrl() {
		$this->out($this->_header(__FUNCTION__));
		$data = array('field' => 'www.dereuromark.de');
		$res = $this->App->validateUrl($data, array('allowEmpty'=>true));
		$this->assertTrue($res);

		$data = array('field' => 'www.xxxde');
		$res = $this->App->validateUrl($data, array('allowEmpty'=>true));
		$this->assertFalse($res);

		$data = array('field' => 'www.dereuromark.de');
		$res = $this->App->validateUrl($data, array('allowEmpty'=>true, 'autoComplete'=>false));
		$this->assertFalse($res);

		$data = array('field' => 'http://www.dereuromark.de');
		$res = $this->App->validateUrl($data, array('allowEmpty'=>true, 'autoComplete'=>false));
		$this->assertTrue($res);

		$data = array('field' => 'www.dereuromark.de');
		$res = $this->App->validateUrl($data, array('strict'=>true));
		$this->assertTrue($res); # aha

		$data = array('field' => 'http://www.dereuromark.de');
		$res = $this->App->validateUrl($data, array('strict'=>false));
		$this->assertTrue($res);


		$this->skipIf(empty($_SERVER['HTTP_HOST']), 'No HTTP_HOST');

		$data = array('field' => 'http://xyz.de/some/link');
		$res = $this->App->validateUrl($data, array('deep'=>false, 'sameDomain'=>true));
		$this->assertFalse($res);

		$data = array('field' => '/some/link');
		$res = $this->App->validateUrl($data, array('deep'=>false, 'autoComplete'=>true));
		$this->assertTrue($_SERVER['HTTP_HOST'] === 'localhost' ? !$res : $res);

		$data = array('field' => 'http://'.$_SERVER['HTTP_HOST'].'/some/link');
		$res = $this->App->validateUrl($data, array('deep'=>false));
		$this->assertTrue($_SERVER['HTTP_HOST'] === 'localhost' ? !$res : $res);

		$data = array('field' => '/some/link');
		$res = $this->App->validateUrl($data, array('deep'=>false, 'autoComplete'=>false));
		$this->assertTrue((env('REMOTE_ADDR') !== '127.0.0.1') ? !$res : $res);

		//$this->skipIf(strpos($_SERVER['HTTP_HOST'], '.') === false, 'No online HTTP_HOST');

		$data = array('field' => '/some/link');
		$res = $this->App->validateUrl($data, array('deep'=>false, 'sameDomain'=>true));
		$this->assertTrue($_SERVER['HTTP_HOST'] === 'localhost' ? !$res : $res);

		$data = array('field' => 'https://github.com/');
		$res = $this->App->validateUrl($data, array('deep'=>false));
		$this->assertTrue($res);

		$data = array('field' => 'https://github.com/');
		$res = $this->App->validateUrl($data, array('deep'=>true));
		$this->assertTrue($res);
	}

}

class Post extends MyModel {

	public $belongsTo = 'Author';

}

class User extends MyModel {

}

class AppTestModel extends MyModel {

	public $useTable = false;

	protected $_schema = array(
		'id' => array (
			'type' => 'string',
			'null' => false,
			'default' => '',
			'length' => 36,
			'key' => 'primary',
			'collate' => 'utf8_unicode_ci',
			'charset' => 'utf8',
		),
		'foreign_id' => array (
			'type' => 'integer',
			'null' => false,
			'default' => '0',
			'length' => 10,
		),
	);
	public static function x() {
		return array('1'=>'x', '2'=>'y', '3'=>'z');
	}

}