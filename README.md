# Laravel UUID
This package easily adds a uuid generated with ramsey/uuid to an Eloquent model.

## Installation

```composer require dan-lyn/laravel-uuid```

## Documentation
To automatically create a uuid for new models all that is needed is to include the uuid trait as in following example:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DanLyn\LaravelUuid\Traits\Uuid;

class MyModel extends Model
{
    use Uuid;
}

```

There are several options to specify which type of uuid should be generated: 'uuidVersion', 'uuidString', 'uuidColumnName', and 'uuidGenerateOnSave'. But first...

Default values are:
- uuidVersion = 4
- uuidString = ''
- uuidColumnName = 'uuid'
- uuidGenerateOnSave = false

The last option, 'uuidGenerateOnSave', will generate a uuid for the element on the next save action. This could be useful if uuids were introduced later on and existing elements require a uuid.

To change these options they can be specified through class properties in the model as in the following example:
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DanLyn\LaravelUuid\Traits\Uuid;

class MyModel extends Model
{
    use Uuid;

    protected $uuidVersion = 5;
    protected $uuidString = 'lorem';
    protected $uuidColumnName = 'my_uuid';
    protected $uuidGenerateOnSave = true;
}

```

The uuid trait also adds a find-function to the model which makes it is easy to find an element by uuid. This can be done as in the following code snippet:
```php
<?php

$element = MyModel::findByUuid('3059dbe0-20d4-4591-9b02-1f77a1826544');

```

## License
This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)