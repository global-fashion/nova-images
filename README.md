# 安装

```php
composer require sbing/nova-images
```

# 使用

```php
use Sbing\Images\Images;

Images::make('轮播图', 'images', 'oss')->rules('nullable', 'array')
```
