<?php
App::import('Core', array('AppModel', 'Model'));

/**
 * Test MOdel class
 *
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs.model
 */
class User extends CakeTestModel {
/**
 * name property
 *
 * @var string 'User'
 * @access public
 */
	var $name = 'User';
/**
 * actsAs parameter
 *
 * @var array
 */
	var $actsAs = array(
		'NamedScope.NamedScope'
	);
}

/**
 * NamedScopeTest class
 */
class NamedScopeTest extends CakeTestCase {
/**
 * Fixtures associated with this test case
 *
 * @var array
 * @access public
 */
	var $fixtures = array(
		'plugin.named_scope.user'
	);
/**
 * Method executed before each test
 *
 * @access public
 */
	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}
/**
 * Method executed after each test
 *
 * @access public
 */
	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}
 
    function testFindScoped() {    
        $this->User->Behaviors->attach('NamedScope', array(
            'active' => array(
                'conditions' => array(
                    'is_active' => true
                )
            )
        ));
        $r = $this->User->find('active');
        $this->assertTrue(Set::matches('/User[id=2]', $r));
        $this->assertFalse(Set::matches('/User[id=3]', $r));
        
        $this->User->Behaviors->attach('NamedScope', array(
            'active' => array(
                'conditions' => array(
                    'is_active' => false
                ),
                'limit' => 2
            )
        ));
        $r = $this->User->find('active');
        $this->assertTrue(Set::matches('/User[id=3]', $r));
        $this->assertTrue(Set::matches('/User[id=4]', $r));
        $this->assertEqual(count($r), 2);
    }
    
    function testFindScopedOverwrite() {    
        $this->User->Behaviors->attach('NamedScope', array(
            'active' => array(
                'conditions' => array(
                    'is_active' => false
                ),
                'limit' => 2
            )
        ));
        
        $r = $this->User->find('active', array(
            'limit' => 1
        ));
        $this->assertTrue(Set::matches('/User[id=3]', $r));
        $this->assertEqual(count($r), 1);
    }
    
    function testFindScopedWithoutSettings() {
        $this->User->Behaviors->attach('NamedScope', array(
            'active'
        ));
        $r = $this->User->find('active');
        $this->assertTrue(Set::matches('/User[id=5]', $r));
        $this->assertEqual(count($r), 5);
    }

    function testMethodScoped() {   
        $this->User->Behaviors->attach('NamedScope', array(
            'active' => array(
                'conditions' => array(
                    'is_active' => true
                )
            )
        ));
        $r = $this->User->active('all');
        $this->assertTrue(Set::matches('/User[id=1]', $r));
        $this->assertTrue(Set::matches('/User[id=2]', $r));
        $this->assertEqual(count($r), 2);
    }
    
    function testMethodScopedOverwrite() {    
        $this->User->Behaviors->attach('NamedScope', array(
            'active' => array(
                'conditions' => array(
                    'is_active' => false
                ),
                'limit' => 2
            )
        ));
        
        $r = $this->User->active('all', array(
            'limit' => 1
        ));
        $this->assertTrue(Set::matches('/User[id=3]', $r));
        $this->assertEqual(count($r), 1);
    }
    
    function testMethodScopedWithoutSettings() {
        $this->User->Behaviors->attach('NamedScope', array(
            'active'
        ));
        $r = $this->User->active('all');
        $this->assertTrue(Set::matches('/User[id=5]', $r));
        $this->assertEqual(count($r), 5);
    }
    
}