<?php 
class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'email' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'is_active' => array('type'=>'boolean', 'null'=>false, 'default'=>1),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(
	    array(
			'name' => 'Joel Moss',
			'email' => 'joel@developwithstyle.com',
			'is_active' => true,
			'created' => '2008-09-12 12:05:58',
			'modified' => '2008-09-12 12:05:58'
		),
	    array(
			'name' => 'Faith Moss',
			'email' => 'faith@developwithstyle.com',
			'is_active' => true,
			'created' => '2008-09-12 12:05:58',
			'modified' => '2008-09-12 12:05:58'
		),
	    array(
			'name' => 'Ashley Moss',
			'email' => 'ash@developwithstyle.com',
			'is_active' => false,
			'created' => '2008-09-12 12:05:58',
			'modified' => '2008-09-12 12:05:58'
		),
	    array(
			'name' => 'Elijah Moss',
			'email' => 'elijah@developwithstyle.com',
			'is_active' => false,
			'created' => '2008-09-12 12:05:58',
			'modified' => '2008-09-12 12:05:58'
		),
	    array(
			'name' => 'Eve Moss',
			'email' => 'eve@developwithstyle.com',
			'is_active' => false,
			'created' => '2008-09-12 12:05:58',
			'modified' => '2008-09-12 12:05:58'
		)
	);
}