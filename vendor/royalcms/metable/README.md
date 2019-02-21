# Royalcms-Metable

Royalcms-Metable is a package for easily attaching arbitrary data to Eloquent models for Royalcms 5.

## Features

- One-to-many polymorphic relationship allows attaching data to Eloquent models without needing to adjust the database schema.
- Type conversion system allows data of numerous different scalar and object types to be stored and retrieved. See the documentation for the list of supported types.

## Example Usage

Attach some metadata to an eloquent model

```php
$post = Post::create($this->request->input());
$post->setMeta('color', 'blue');
```

Query the model by its metadata

```php
$post = Post::whereMeta('color', 'blue');
```

Retrieve the metadata from a model

```php
$value = $post->getMeta('color');
```

Add the `Royalcms\Component\Metable\Metable` trait to any eloquent model class that you want to be able to attach metadata to.


```php
<?php

namespace App;

use Royalcms\Component\Database\Eloquent\Model;
use Plank\Metable\Metable;

class Post extends Model
{
	use Metable;

	//...
}
```

## License

This package is released under the MIT license (MIT).

