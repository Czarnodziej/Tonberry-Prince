<?php
/* Role Fixture generated on: 2011-11-20 21:59:33 : 1321822773 */

/**
 * RoleFixture
 *
 */
class RoleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'default_role' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => 'set at register'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'collate' => NULL, 'comment' => ''),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '2',
			'name' => 'Admin',
			'description' => 'Zuständig für die Verwaltung der Seite und Mitglieder, Ahndung von Missbrauch und CO',
			'alias' => 'admin',
			'default_role' => 0,
			'created' => '2010-01-07 03:36:33',
			'modified' => '2010-01-07 03:36:33',
			'sort' => '6',
			'active' => 1
		),
		array(
			'id' => '4',
			'name' => 'User',
			'description' => 'Standardrolle jedes Mitglieds (ausreichend für die meisten Aktionen)',
			'alias' => 'user',
			'default_role' => 1,
			'created' => '2010-01-07 03:36:33',
			'modified' => '2010-01-07 03:36:33',
			'sort' => '1',
			'active' => 1
		),
		array(
			'id' => '6',
			'name' => 'Partner',
			'description' => 'Partner',
			'alias' => 'partner',
			'default_role' => 0,
			'created' => '2010-01-07 03:36:33',
			'modified' => '2010-01-07 03:36:33',
			'sort' => '0',
			'active' => 1
		),
		array(
			'id' => '1',
			'name' => 'Super-Admin',
			'description' => 'Zuständig für Programmierung, Sicherheit, Bugfixes, Hosting und CO',
			'alias' => 'superadmin',
			'default_role' => 0,
			'created' => '2010-01-07 03:36:33',
			'modified' => '2010-01-07 03:36:33',
			'sort' => '7',
			'active' => 1
		),
	);
}