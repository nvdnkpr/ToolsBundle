COil\ToolsBundle
================

The **ToolsBundle** provides some tools and debugging functions, it is especially
useful to debug Doctrine entities or collections.

----

Installation
------------

*The commands accompanying each step assume that you are versioning your project
using git and you manage your vendors as submodules or with deps files. If not you
can ignore them.*

If you use a `deps` file, add:

    [ToolsBundle]
        git=git@github.com:COil/ToolsBundle.git
        target=bundles/COil/ToolsBundle

If you use git submodules, copy the `ToolsBundle` source in the `vendor/bundles/COil/ToolsBundle`
directory:

    git submodule add git@github.com:COil/ToolsBundle.git vendor/bundles/COil/ToolsBundle

Then, you can register both source directories in your autoloader:

    $loader->registerNamespaces(array(
        ...
        'COil'                        => __DIR__.'/../vendor/bundles',

Finally, you can enable it in your kernel:

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            new COil\ToolsBundle\ToolsBundle(),

----

Usage
-----

The bundle registers 2 service:

### The `debug` service:

 - the `coil.tools.debug` service allows you to dump and debug Doctrine entities, collections and variables.

  * `dump()`: Dumps an array or object. Displays, dies or returns the result.
Note that Doctrine objects are automatically detected.
  * `dumpConsole()`: Same function as dump() but more suitable and readable for a console debug.

#### dump():

This function accepts 5 parameters, only the first one is mandatory:

* `$var`: Variable to dump
* `$name`: Name of the var to dump (optional, default 'var')
* `$die`: Tells the function to stop the process or not (optional, default: 'false')
* `$maxDepth`: Max depth allowed when debugging objects (optional, default: 2)
* `$returnBuffer`: Boolean that tells if the debug must be returned as a string (optional, default: false)

##### Example 1:

In your controller:

``` php
<?php
// Dump `$categories` using default maxDepth of 2 then die()
$this->get('coil.tools.debug')->dump($categories, '$categories', true);
```

Will output and die:

    $categories :

    array
      0 =>
        object(stdClass)[4165]
          public '__CLASS__' => string 'COil\Jobeet2Bundle\Entity\Category' (length=34)
          public 'id' => string '157' (length=3)
          public 'name' => string 'Design' (length=6)
          public 'slug' => string 'design' (length=6)
          public 'createdAt' => string 'DateTime' (length=8)
          public 'updatedAt' => string 'DateTime' (length=8)
          public 'jobs' => string 'Array(1)' (length=8)
          public 'affiliate' => string 'Array(0)' (length=8)
          public 'activeJobs' => null
          public 'countActiveJobs' => null
      1 =>
        object(stdClass)[4153]
          public '__CLASS__' => string 'COil\Jobeet2Bundle\Entity\Category' (length=34)
          public 'id' => string '158' (length=3)
          public 'name' => string 'Programming' (length=11)
          public 'slug' => string 'programming' (length=11)
          public 'createdAt' => string 'DateTime' (length=8)
          public 'updatedAt' => string 'DateTime' (length=8)
          public 'jobs' => string 'Array(33)' (length=9)
          public 'affiliate' => string 'Array(0)' (length=8)
          public 'activeJobs' => null
          public 'countActiveJobs' => null
    Process stopped by COil\ToolsBundle\Lib\Debug
    » file     : /Users/coil/Sites/jobeet2/src/COil/Jobeet2Bundle/Controller/HomeController.php
    » line     : 27
    » class    : COil\Jobeet2Bundle\Controller\HomeController
    » function : indexAction

##### Example 2:

Same as 1) but with a depth of 1:


``` php
<?php
$this->get('coil.tools.debug')->dump($categories, '$categories', true, 1);
```

Will output and die:

    $categories :

    array
      0 => string 'COil\Jobeet2Bundle\Entity\Category' (length=34)
      1 => string 'COil\Jobeet2Bundle\Entity\Category' (length=34)
    Process stopped by COil\ToolsBundle\Lib\Debug
    » file     : /Users/coil/Sites/jobeet2/src/COil/Jobeet2Bundle/Controller/HomeController.php
    » line     : 27
    » class    : COil\Jobeet2Bundle\Controller\HomeController
    » function : indexAction

##### Example 3:

This time we will use a maxDepth of 3, the function will not die but will return the output

``` php
<?php
$debug = $this->get('coil.tools.debug')->dump($categories, '$categories', false, 3, true);
```

The `$debug` variable will contain:

$categories:

    array
      0 =>
        object(stdClass)[4165]
          public '__CLASS__' => string 'COil\Jobeet2Bundle\Entity\Category' (length=34)
          public 'id' => string '157' (length=3)
          public 'name' => string 'Design' (length=6)
          public 'slug' => string 'design' (length=6)
          public 'createdAt' => string '2012-01-20T02:12:35+01:00' (length=25)
          public 'updatedAt' => string '2012-01-20T02:12:35+01:00' (length=25)
          public 'jobs' =>
            array
              0 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
          public 'affiliate' =>
            array
              empty
          public 'activeJobs' => null
          public 'countActiveJobs' => null
      1 =>
        object(stdClass)[4153]
          public '__CLASS__' => string 'COil\Jobeet2Bundle\Entity\Category' (length=34)
          public 'id' => string '158' (length=3)
          public 'name' => string 'Programming' (length=11)
          public 'slug' => string 'programming' (length=11)
          public 'createdAt' => string '2012-01-20T02:12:35+01:00' (length=25)
          public 'updatedAt' => string '2012-01-20T02:12:35+01:00' (length=25)
          public 'jobs' =>
            array
              0 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              1 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              2 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              3 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              4 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              5 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              6 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              7 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              8 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              9 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              10 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              11 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              12 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              13 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              14 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              15 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              16 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              17 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              18 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              19 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              20 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              21 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              22 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              23 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              24 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              25 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              26 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              27 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              28 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              29 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              30 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              31 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
              32 => string 'COil\Jobeet2Bundle\Entity\Job' (length=29)
          public 'affiliate' =>
            array
              empty
          public 'activeJobs' => null
          public 'countActiveJobs' => null

----

Tips
----

Add a shortcut to your main controller so you don't have to call the service itself:

``` php
<?php
/**
 * Shortcut.
 */
protected function dump($var, $name = 'var', $die = false, $maxDepth = 2, $returnBuffer = false)
{
    return $this->get('coil.tools.debug')->dump($var, $name, $die, $maxDepth, $returnBuffer);
}
```

``` php
<?php
$this->dump($categories, '$categories', true);
```

### The `timer` service:

 - the `coil.tools.timer` service allows you to measure code performance on the fly.

  * `start()`: Starts a timer
  * `stop()`: Stops a timer
  * `getTime()`: Returns the elapsed time between the start and end time references of a timer
  * `clear()`: Clears all the existing timers
  * `all()`: Returns the timers array

#### start():

Start the timer:

``` php
<?php
$this->get('coil.tools.timer')->start();
```

Or you can pass a name for the timer:

``` php
<?php
$this->get('coil.tools.timer')->start('myTimer');
```

#### stop():

Stops the timer:

``` php
<?php
$this->get('coil.tools.timer')->stop();
```

Or with a timer name:

``` php
<?php
$this->get('coil.tools.timer')->stop('myTimer');
```

#### getTime():

Returns the elapsed time between the start and end time references of a timer.

``` php
<?php
$time = $this->get('coil.tools.timer')->getTime();
echo $time. ' second(s)';
```

(or `->getTime('myTimer')`)

Will output:

    0.0012 second(s)

#### clear():

Clears all the existing timers.

#### all():

Returns the timers array.


Tips
----

Note that you don't have to call the `stop()` function, it will be automatically
called by the `getTime()` one if it was not called before. If you call `getTime()`
and the timer was not started, an exception will be raised.


Changelog
---------

**2012-03-04**

* Added the timer class
* Added unit tests for the timer service

**2012-01-23**

- Fist version of the plugin

TODO
----

- Submit your PR.

Credits
-------

* COil\ToolsBundle has been developed by [COil](https://github.com/COil).
* [My Symfony blog](http://www.strangebuzz.com)
* [Strangebuzz git](https://github.com/Strangebuzz)
* [The original symfony1 plugin](http://www.symfony-project.org/plugins/sfToolsPlugin)