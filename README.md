## NamedScope Behavior for CakePHP

This NamedScope behavior for CakePHP allows you to define named scopes for a model,
and then apply them to any find call. It will automagically create a model method,
and a method for use with the _findMethods property of the model.

Get it from [http://github.com/joelmoss/cakephp-namedscope](http://github.com/joelmoss/cakephp-namedscope) or [http://developwithstyle.com](http://developwithstyle.com)

Borrowed from an original idea found in Ruby on Rails, and a first attempted for Cake
by Michał Szajbe [http://github.com/netguru/namedscopebehavior](http://github.com/netguru/namedscopebehavior)


### Example:
 
I have a User model and want to return only those which are active. So I define this in my model:

    var $actsAs = array(
        'NamedScope' => array(
            'active' => array(
                'conditions' => array(
                    'User.is_active' => true
                )
            )
        )
    );

Then call this in my User controller:

    $active_users = $this->User->active('all');

or this:

    $active_users = $this->User->find('active');

You can even pass in the standard find params to both calls:

    $active_users = $this->User->active('all', array(
        'conditions' => array(
            'User.created' => '2008-01-01'
        ),
        'order' => 'User.name ASC'
    ));
    
or:

    $active_users = $this->User->find('active', array(
        'conditions' => array(
            'User.created' => '2008-01-01'
        ),
        'order' => 'User.name ASC'
    ));