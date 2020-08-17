# 安装

```
composer require sbing/nova-images
```

# 使用

```
use Sbing\Nova\Images\Images;

Images::make('轮播图', 'images', 'oss')->rules('nullable', 'array')
```
