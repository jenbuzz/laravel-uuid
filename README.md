[![Build Status](https://secure.travis-ci.org/jenbuzz/laravel-uuid.png?branch=master)](http://travis-ci.org/jenbuzz/laravel-uuid)

# Laravel UUID
This package easily adds a uuid generated with ramsey/uuid to an Eloquent model.

## Installation

```composer require jenbuzz/laravel-uuid```

## Documentation
To automatically create a uuid for new models all that is needed is to include the uuid trait as in the following example:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenbuzz\LaravelUuid\Traits\Uuid;

class MyModel extends Model
{
    use Uuid;
}

```

There are several options to specify the uuid that should be generated: 'uuidVersion', 'uuidString', 'uuidColumnName', and 'uuidGenerateOnSave'. But first...

Default values are:
- uuidVersion = 4
- uuidString = ''
- uuidColumnName = 'uuid'
- uuidGenerateOnSave = false

The last option, 'uuidGenerateOnSave', will generate a uuid for the element on the next save action if set to true. This could be useful if uuids were introduced later on and existing elements require an uuid.

To change these options they can be specified through class properties in the model as in the following example:
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenbuzz\LaravelUuid\Traits\Uuid;

class MyModel extends Model
{
    use Uuid;

    protected $uuidVersion = 5;
    protected $uuidString = 'lorem';
    protected $uuidColumnName = 'my_uuid';
    protected $uuidGenerateOnSave = true;
}

```

The uuid trait also adds a 'find'-function to the model which makes it is easy to find an element by uuid. This can be done as in the following code snippet:
```php
<?php

$element = MyModel::findByUuid('3059dbe0-20d4-4591-9b02-1f77a1826544');

```

## License
This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)