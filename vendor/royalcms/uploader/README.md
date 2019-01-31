# Royalcms Uploader

Uploading files and store its in Filesystem / Cloud storage in Royalcms is not easy and simple for some developers. This package provides a simple way to do that, and comes with fluent interface that you might like.

## Configuration
The Uploader configuration is located at `packages/royalcms/uploader/uploader.php`, where you can adjust the default file provider and the default file visibility as you want.

## File Providers
This package comes with two file providers, from HTTP request and local filesystem. Before uploading a file, you can set where the file is provided. Example:

```php
RC_Uploader::from('request')->upload('avatar'); // see the supported providers at config/uploader.php

// Or you can use the magic methods...
RC_Uploader::fromRequest()->upload('file');
RC_Uploader::fromLocal()->upload('/path/to/file');
```
If you call method on the `RC_Uploader` facade without first calling the `from` method, the uploader will assume that you want to use the default provider.

```php
// If your default provider is local, it will automatically use the local provider.
RC_Uploader::upload('/path/to/file');
```

## Usage
### Uploading a File
Now, uploading a file is very simple like this:

```php
<?php

namespace App\Http\Controllers;

use RC_Uploader;
use Royalcms\Component\Http\Request;

class UserController extends Controller
{
    /**
     * Change user's avatar.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return \Royalcms\Component\Http\Response
     */
    public function changeAvatar(Request $request)
    {
        RC_Uploader::upload('avatar');

        //
    }
}
```
The `upload` method accept a request key or path where the file is located (based on the file provider) as first parameter and returns a boolean: `true` if succeed or `false` if failed.

You may pass a `Closure` callback as second parameter that will be called if the file successfully uploaded:

```php
// The parameter in the Closure is a full uploaded filename...
RC_Uploader::upload('avatar', function ($filename) {
    Photo::create(['photo' => $filename]);
});

RC_Uploader::upload('/path/to/file', function ($filename) {
    $user = User::find(12);

    $user->update(['avatar' => $filename]);
});
```

### Choosing the File Storage
Automatically, the Uploader will use your default [Filesystem] Disk when storing the file. But, you can choose where you will store the file with `uploadTo` method:

```php
// see the supported uploadTo parameter at config/filesystems.php
RC_Uploader::uploadTo('s3')->upload('avatar');

// Or you can use the magic methods...
RC_Uploader::uploadToS3();
RC_Uploader::uploadToFtp();
RC_Uploader::uploadToLocal();
RC_Uploader::uploadToRackspace();
```

### Set the Folder
Maybe you want to specify the folder where the file will be stored. Just use the `toFolder` method:

```php
RC_Uploader::toFolder('photos')->upload('photo');
```

### Rename the File
Adjust the filename as you want with `renameTo` method:

```php
RC_Uploader::renameTo('my-awesome-videos')->upload('/path/to/video');
```
If you ignore this method, the file will be renamed to random and unique name.

### File Visibility
You may set the [Filesystem] using the `setVisibility` method:

```php
RC_Uploader::setVisibility('public')->upload('avatar');
```
Or just ignore this, and the Uploader will set the visibility based on your configuration.

### Method Chainning
All the methods above except the `upload` method, are chainable. Feel free to call other methods before calling the `upload`. Example:

```php
RC_Uploader::from('local')->uploadToS3()->toFolder('banners')->renameTo('cool-banner')->setVisibility('public')->upload('/path/to/banner');
```
