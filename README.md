# SpiffyNavigation Module for Zend Framework 3

This is a fork of spiffyjr/spiffy-navigation which was updated with the intent to support ZF3 for FXWeb. The www.fxnetworks.com site uses the SpiffyNavigation module for rendering the hamburger menu and populating the sitemap with items in that menu.

## Project Status
[![Master Branch Build Status](https://secure.travis-ci.org/startupdevs/spiffy-navigation.png?branch=master)](http://travis-ci.org/startupdevs/spiffy-navigation)
[![Coverage Status](https://coveralls.io/repos/startupdevs/spiffy-navigation/badge.png?branch=master)](https://coveralls.io/r/startupdevs/spiffy-navigation?branch=master)


## Requirements
 - PHP 5.6 or higher
 - [Zend Framework 3](https://github.com/zendframework/zendframework) (now known as **Laminas**)

## Installation

Installation of SpiffyNavigation uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

### Installation steps

  1. `cd my/project/directory`
  2. create a `composer.json` file with following contents:

     ```json
     {
         "require": {
             "startupdevs/spiffy-navigation": "dev-master"
         }
     }
     ```
  3. install composer via `curl -s http://getcomposer.org/installer | php` (on windows, download
     http://getcomposer.org/installer and execute it with PHP)
  4. run `php composer.phar install`
  5. open `my/project/directory/configs/application.config.php` and add the following key to your `modules`:

     ```php
     'SpiffyNavigation',
     ```

## Providers

[Providers](https://github.com/spiffyjr/spiffy-navigation/tree/feature/providers/src/SpiffyNavigation/Provider) let you
create your navigation containers from various sources. The following providers are included out of the box:

  * [array](https://github.com/spiffyjr/spiffy-navigation/blob/feature/providers/src/SpiffyNavigation/Provider/ArrayProvider.php): builds a container from an array.
  * [config](https://github.com/spiffyjr/spiffy-navigation/blob/feature/providers/src/SpiffyNavigation/Provider/ConfigProvider.php):  builds a container from a file using Zend\Config.
  * [json](https://github.com/spiffyjr/spiffy-navigation/blob/feature/providers/src/SpiffyNavigation/Provider/JsonProvider.php):  builds a container from a json string.

## Creating containers

Creating navigation containers is done via the module configuration using the `spiffy_navigation` key. The containers
array can take two types of values: a string and an array. If you pass a string the container will be created from a
provider matching the name if it exists, pulled from the service manager or instantiated directly. If you pass an array
the container is built using the ContainerFactory::create() method.

```php
<?php

// module.config.php
return array(
    'spiffy_navigation' => array(
        'containers' => array(
            'default' => array(
                array(
                    'options' => array(
                        'uri' => 'http://www.github.com',
                    ),
                    'attributes' => array(
                        'class'  => 'foo',
                        'target' => '_blank',
                        'name'   => 'github'
                    )
                ),
                array(
                    'options' => array(
                        'label' => 'Home',
                        'route' => 'home',
                    ),
                    'attributes' => array(
                        'name' => 'Home'
                    )
                    'pages' => array(
                        // ...
                    )
                )
            ),

            'serviceManager' => 'My\ServiceManager\Alias',

            'class' => 'My\Class\Instantiation',

            'json_provider' => 'mynav',
        ),

        'providers' => array(
            'mynav' => array(
                'type' => 'json',
                'options' => array(
                    'json' => file_get_contents(__DIR__ . '/navigation/mynav.json')
                )
            )
        )
    )
);
```

## Page options

* label: The label for the element in view helpers.
* anchor: An optional anchor to append to the uri.
* route: The route to use for assembling the uri.
* uri: The direct uri to use (use instead of route).
* params: Optional params to include during route assembly.
* query_params: Optional params to include in the query string during assembly.

#### Rbac specific options

* role: **required** The role to use to determine if access is granted.
* permission: **required** The permission to use to determine if access is granted.
* assertion: The assertion to use to determine if access is granted.

## Using the view helpers

Once you have created a container using a view helper is as simple as putting:

```php
<?php

echo $this->helperName('containerName');
```

### NavigationMenu

#### Quick Start
```php
<?php

// in view script
echo $this->navigationMenu('containerName');

// or

echo $this->navigationMenu()->renderMenu('containerName', $options);

// or

echo $this->navigationMenu()->renderPartial('containerName', 'partialName');
```

#### Options

* ulClass: The class to use when generating the ul.
* minDepth: Minimum render depth.
* maxDepth: Maximum render depth.
* activeClass: Active class to use for the active element.
