# Create zip files containing export data

This package makes it easy to let a user download an export containing all the personal data. Such an export consists of a zip file containing all the user properties and related info.

You can create and mail such a zip by dispatching the `CreateCustomizeDataExportJob` job:

```php
// somewhere in your app

use Royalcms\Component\DataExport\Jobs\CreateCustomizeDataExportJob;

// ...

dispatch(new CreateCustomizeDataExportJob(userModel());
```

The package will create a zip containing all the customize data. When the zip has been created, a link to it will be mailed to the user. By default, the zips are saved in a non-public location, and the user should be logged in to be able to download the zip.

You can configure which data will will be exported in the `selectCustomizeData ` method on the `model`.

```php
// in your User model

public function selectCustomizeData(CustomizeDataSelection $customizeDataSelection) {
    $customizeDataSelection
        ->add('user.json', ['name' => $this->name, 'email' => $this->email])
        ->addFile(storage_path("avatars/{$this->id}.jpg");
        ->addFile('other-user-data.xml', 's3');
}
```

This package also offers an artisan command to remove old zip files.

You must add a disk named `data-exports` to `config/filesystems`. You can use any driver that you want. We recommend that your disk is not publicly accessible. If you're using the `local` driver, make sure you use a path that is not inside the public path of your app.

```php
// in config/filesystems.php

// ...

'disks' => [

    'data-exports' => [
        'driver' => 'local',
        'root' => storage_path('app/data-exports'),
    ],

// ...
```

## Usage

### Selecting customize data

First, you'll have to prepare your user model. You should let your model implement the `Royalcms\Component\DataExport\ExportsCustomizeData` interface. This is what that interface looks like:

```php
namespace Royalcms\Component\DataExport\Contracts;

interface ExportsCustomizeData
{
    public function selectCustomizeData(CustomizeDataSelection $customizeDataSelection);

    public function customizeDataExportName();
    
    public function getKey();
}
```

The `selectCustomizeData ` is used to determine the content of the customize download. Here's an example implementation:

```php
// in your user model

public function selectCustomizeData(CustomizeDataSelection $customizeDataSelection) {
    $customizeDataSelection
        ->add('user.json', ['name' => $this->name, 'email' => $this->email])
        ->addFile(storage_path("avatars/{$this->id}.jpg");
        ->addFile('other-user-data.xml', 's3');
}
```

`$customizeDataSelection ` is used to determine the content of the zip file that the user will be able to download. You can call these methods on it:

- `add`: the first parameter is the name of the file in the inside the zip file. The second parameter is the content that should go in that file. If you pass an array here, we will encode it to JSON.
- `addFile`: the first parameter is a path to a file which will be copied to the zip. You can also add a disk name as the second parameter.

The name of the export itself can be set using the `customizeDataExportName` on the user. This will only affect the name of the download that will be sent as a response to the user, not the name of the zip stored on disk.

```php
// on your user

public function customizeDataExportName(string $realFilename) {
    $userName = Str::slug($this->name);

    return "export-data-{$userName}.zip";
}
```

### Creating an export

You can create a personal data export by executing this job somewhere in your application:

```php
// somewhere in your app

use Royalcms\Component\DataExport\Jobs\CreateCustomizeDataExportJob;

// ...

dispatch(new CreateCustomizeDataExportJob(userModel());
```

By default, this job is queued. It will copy all files and content you selected in the `selectCustomizeData` on your user to a temporary directory. Next, that temporary directory will be zipped and copied over to the `data-exports` disk. A link to this zip will be mailed to the user. 

### Securing the export

We recommend that the `data-exports` disk is not publicly accessible. If you're using the `local` driver for this disk, make sure you use a path that is not inside the public path of your app.

### Customizing the queue

You can customize the job that creates the zip file and mails it by extending the `Royalcms\Component\DataExport\Jobs\CreateCustomizeDataExportJob` and dispatching your own custom job class.

```php
use Royalcms\Component\DataExport\Jobs\CreateCustomizeDataExportJob;

class MyCustomJobClass extends CreateCustomizeDataExportJob
{
    public $queue = 'my-custom-queue`
}
```

```php
dispatch(new MyCustomJobClass(userModel()));
```

### Events

#### CustomizeDataSelected

This event will be fired after the personal data has been selected. It has two public properties:
- `$customizeData`: an instance of `CustomizeData`. In your listeners you can call the `add`, `addFile` methods on this object to add extra content to the zip.
- `$data`: the data for which this personal data has been selected.

#### CustomizeDataExportCreated

This event will be fired after the personal data zip has been created. It has two public properties:
- `$zipFilename`: the name of the zip filename.
- `$data`: the data for which this zip has been created.

#### CustomizeDataExportDownloaded

This event will be fired after the export has been download. It has two public properties:
- `$zipFilename`: the name of the zip filename.
- `$data`: the data for which this zip has been created.

You could use this event to immediately clean up the downloaded zip.
