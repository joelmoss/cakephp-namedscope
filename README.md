## NamedScope Behavior for CakePHP

This NamedScope behavior for CakePHP allows you to define named scopes for a model,
and then apply them to any find call. It will automagically create a model method,
and a method for use with the _findMethods property of the model.

NamedScope is now packaged as a plugin, so as to allow easier management - particularly with Git submodules - and to support tests.

Get it from [http://github.com/joelmoss/cakephp-namedscope](http://github.com/joelmoss/cakephp-namedscope) or [http://developwithstyle.com](http://developwithstyle.com)

Borrowed from an original idea found in Ruby on Rails, and a first attempted for Cake
by Michał Szajbe [http://github.com/netguru/namedscopebehavior](http://github.com/netguru/namedscopebehavior)


### Install:

Just create a 'named_scope' directory in your app/plugins directory, and drop these files and directories into it.

If your application is managed via Git, you can use NamedScope as a submodule. Just cd into your app directory, and run:

    git submodule add git://github.com/joelmoss/cakephp-namedscope.git plugins/named_scope
    
Once the submodule is added we need to register this submodule using `init`:

    git submodule init
    
From now on we can update all the submodules using the following command:

    git submodule update
    

### Example:
 
I have a User model and want to return only those which are active. So I define this in my model:

    var $actsAs = array(
        'NamedScope.NamedScope' => array(
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