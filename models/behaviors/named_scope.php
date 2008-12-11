<?php
/**
 * NamedScope Behavior for CakePHP 1.2
 * 
 * @copyright     Copyright 2008, Joel Moss (http://developwithstyle.com)
 * @link          http://github.com/joelmoss/cakephp-namedscope
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 * 
 * 
 * This NamedScope behavior for CakePHP allows you to define named scopes for a model,
 * and then apply them to any find call. It will automagically create a model method,
 * and a method for use with the _findMethods property of the model.
 * 
 * Borrowed from an original idea found in Ruby on Rails, and a first attempted for Cake
 * by Michał Szajbe (http://github.com/netguru/namedscopebehavior)
 * 
 * Example:
 *  
 *  I have a User model and want to return only those which are active. So I define
 *  this in my model:
 * 
 *      var $actsAs = array(
 *          'NamedScope' => array(
 *              'active' => array(
 *                  'conditions' => array(
 *                      'User.is_active' => true
 *                  )
 *              )
 *          )
 *      );
 * 
 *  Then call this in my User controller:
 * 
 *      $active_users = $this->User->active('all');
 * 
 *  or this:
 * 
 *      $active_users = $this->User->find('active');
 * 
 *  You can even pass in the standard find params to both calls.
 * 
 */
class NamedScopeBehavior extends ModelBehavior
{
    
    /**
     * An array of settings set by the $actsAs property
     */
    var $_settings = array();

    /**
     * Instantiates the behavior and sets the magic methods
     * 
     * @param object $model The Model object
     * @param array $settings Array of scope properties
     */
    function setup($model, $settings = array())
    {
        $settings = (array)$settings;
        foreach ($settings as $named => $options) {
            if (!is_array($options)) {
                unset($settings[$named]);
                $settings[$options] = array();
                $named = $options;
            }
            $model->_findMethods[$named] = true;
            $this->mapMethods['/find' . $named . '/'] = '_findScoped';
            $this->mapMethods['/' . $named . '/'] = '_methodScoped';
        }
        $this->_settings[$model->alias] = $settings;
    }

    /**
     * Defines a find method as found in the _findMethods property of the model, assigning the
     * scope properties passed to $actsAs. This allows you to call Model::find('method')
     * 
     * @param object $model The model object
     * @param string $method The name of the _findMethod called
     * @param string $state Whether the method is called before or after the find call
     * @param array $params The find params
     * @param array $results The find results (only passed when $state == after)
     * 
     * @return array The find params if $state == before, else the find results
     */
    function _findScoped($model, $method, $state, $params = array(), $results = array())
    {
        if ($state == 'before') {        
            preg_match('/^_find(\w+)/', $method, $matches);
            return $this->_mergeParams($model, $params, $matches[1]);
        } elseif ($state == 'after') {
			return $results;
        }
    }
    
    /**
     * Defines a model method that runs Model::find() using the scope properties passed to $actsAs.
     * 
     * @param object $model The model object
     * @param string $method The method name
     * @param[..] Copied from the Model::find() method.
     * 
     * @return array Find results
     */
    function _methodScoped($model, $method, $conditions = null, $fields = array(), $order = null, $recursive = null)
    {
		if (!is_string($conditions) || (is_string($conditions) && !array_key_exists($conditions, $model->_findMethods))) {
			$conditions = 'first';
			$fields = array_merge(compact('conditions', 'fields', 'order', 'recursive'), array('limit' => 1));
		}
        $fields = $this->_mergeParams($model, $fields, $method);
        return $model->dispatchMethod('find', array($conditions, $fields));
    }
    
    /**
     * Merges params, to ensure that all required params are set. The params passed to the find call
     * always take precedence, over those set in the behavior settings.
     * 
     * @param object $model The model object
     * @param array $params The params passed to the find call
     * @param string $method Method name called
     * 
     * @return array Merged params
     */
    function _mergeParams($model, $params, $method)
    {
        foreach ($this->_settings[$model->alias][$method] as $key => $value) {
            if (is_array($value)) {
                $params[$key] = isset($params[$key]) ? Set::merge($params[$key], $value) : $value;
            } else {
                if (!isset($params[$key]) || empty($params[$key])) {
                    $params[$key] = $value;
                }
            }
        }
        return $params;
    }
  
}