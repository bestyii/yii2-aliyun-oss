# yii2-aliyun-oss
阿里云对象存储（OSS）基于flysystem Yii2 扩展

[![Packagist Version](https://img.shields.io/packagist/v/bestyii/yii2-aliyun-oss.svg?style=flat-square)](https://packagist.org/packages/bestyii/yii2-aliyun-oss)
[![Total Downloads](https://img.shields.io/packagist/dt/bestyii/yii2-aliyun-oss.svg?style=flat-square)](https://packagist.org/packages/bestyii/yii2-aliyun-oss)

本扩展的文件管理系统，采用 [Flysystem](http://flysystem.thephpleague.com/)，通过 Yii2扩展[creocoder/yii2-flysystem](https://github.com/creocoder/yii2-flysystem)将其集成到Yii2框架中。

通过阿里云OSS的适配器[OssAdapter](https://github.com/xxtime/flysystem-aliyun-oss)，将两者结合在一起。

目的：标准化文件管理的接口，方便迁移到其他云平台。

## 安装

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

执行安装命令

```bash
$ composer require bestyii/yii2-aliyun-oss
```

或添加以下

```
"bestyii/yii2-aliyun-oss": "*"
```

到 `composer.json` 文件的 `require` 部分.

## 配置


配置Yii的 `components` 如下:

```php
return [
    //...
    'components' => [
        //...
        'fs' => [
                    'class' => 'bestyii\aliyunoss\Filesystem',
                    'accessId' => OSS_ACCESS_ID,
                    'accessSecret' => OSS_ACCESS_SECRET,
                    'region' => OSS_REGION,
                    'bucket' => OSS_BUCKET,
                    'endpoint' => OSS_ENDPOINT,
                    // 'timeout'        => 3600,
                    // 'connectTimeout' => 10,
                    // 'isCName'        => false,
                    // 'token'          => '',
                ],
    ],
];
```

## 使用

### Writing files

To write file

```php
Yii::$app->fs->write('filename.ext', 'contents');
```

To write file using stream contents

```php
$stream = fopen('/path/to/somefile.ext', 'r+');
Yii::$app->fs->writeStream('filename.ext', $stream);
```

### Updating files

To update file

```php
Yii::$app->fs->update('filename.ext', 'contents');
```

To update file using stream contents

```php
$stream = fopen('/path/to/somefile.ext', 'r+');
Yii::$app->fs->updateStream('filename.ext', $stream);
```

### Writing or updating files

To write or update file

```php
Yii::$app->fs->put('filename.ext', 'contents');
```

To write or update file using stream contents

```php
$stream = fopen('/path/to/somefile.ext', 'r+');
Yii::$app->fs->putStream('filename.ext', $stream);
```

### Reading files

To read file

```php
$contents = Yii::$app->fs->read('filename.ext');
```

To retrieve a read-stream

```php
$stream = Yii::$app->fs->readStream('filename.ext');
$contents = stream_get_contents($stream);
fclose($stream);
```

### Checking if a file exists

To check if a file exists

```php
$exists = Yii::$app->fs->has('filename.ext');
```

### Deleting files

To delete file

```php
Yii::$app->fs->delete('filename.ext');
```

### Reading and deleting files

To read and delete file

```php
$contents = Yii::$app->fs->readAndDelete('filename.ext');
```

### Renaming files

To rename file

```php
Yii::$app->fs->rename('filename.ext', 'newname.ext');
```

### Getting files mimetype

To get file mimetype

```php
$mimetype = Yii::$app->fs->getMimetype('filename.ext');
```

### Getting files timestamp

To get file timestamp

```php
$timestamp = Yii::$app->fs->getTimestamp('filename.ext');
```

### Getting files size

To get file size

```php
$timestamp = Yii::$app->fs->getSize('filename.ext');
```

### Creating directories

To create directory

```php
Yii::$app->fs->createDir('path/to/directory');
```

Directories are also made implicitly when writing to a deeper path

```php
Yii::$app->fs->write('path/to/filename.ext');
```

### Deleting directories

To delete directory

```php
Yii::$app->fs->deleteDir('path/to/filename.ext');
```

### Managing visibility

Visibility is the abstraction of file permissions across multiple platforms. Visibility can be either public or private.

```php
use League\Flysystem\AdapterInterface;

Yii::$app->fs->write('filename.ext', 'contents', [
    'visibility' => AdapterInterface::VISIBILITY_PRIVATE
]);
```

You can also change and check visibility of existing files

```php
use League\Flysystem\AdapterInterface;

if (Yii::$app->fs->getVisibility('filename.ext') === AdapterInterface::VISIBILITY_PRIVATE) {
    Yii::$app->fs->setVisibility('filename.ext', AdapterInterface::VISIBILITY_PUBLIC);
}
```

### Listing contents

To list contents

```php
$contents = Yii::$app->fs->listContents();

foreach ($contents as $object) {
    echo $object['basename']
        . ' is located at' . $object['path']
        . ' and is a ' . $object['type'];
}
```

By default Flysystem lists the top directory non-recursively. You can supply a directory name and recursive boolean to get more precise results

```php
$contents = Yii::$app->fs->listContents('path/to/directory', true);
```

### Listing paths

To list paths

```php
$paths = Yii::$app->fs->listPaths();

foreach ($paths as $path) {
    echo $path;
}
```

### Listing with ensured presence of specific metadata

To list with ensured presence of specific metadata

```php
$listing = Yii::$app->fs->listWith(
    ['mimetype', 'size', 'timestamp'],
    'optional/path/to/directory',
    true
);

foreach ($listing as $object) {
    echo $object['path'] . ' has mimetype: ' . $object['mimetype'];
}
```

### Getting file info with explicit metadata

To get file info with explicit metadata

```php
$info = Yii::$app->fs->getWithMetadata('path/to/filename.ext', ['timestamp', 'mimetype']);
echo $info['mimetype'];
echo $info['timestamp'];
```