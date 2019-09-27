<p align="center">
    <h1 align="center">AuthBehavior Extension for Yii 2</h1>
    <br>
</p>
This extension provides a [AuthBehavior]()

Installation
------------
Need to create new alias.

add the following code in index.php

```
Yii::setAlias('getin');
```
or add the following code in your application configuration:
```php
return [
    //....
    'alias' => [
        '@geiin' => dirname(..path to files..),
    ],
];
```
or put this files to vendor folder.

Usage
-----

To use this extension,  simply add the following code in your application configuration:

```php
return [
    //....
    'as AuthBehavior' => [
        'class' => 'getin\behavior\AuthBehavior',
    ],
];
```
