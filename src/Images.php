<?php

namespace Sbing\Nova\Images;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class Images extends Image
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'images';

    /**
     * 插入方式
     *
     * @var string
     */
    public $order;


    /**
     * 构造方法.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  string|null  $disk
     */
    public function __construct($name, $attribute = null, $disk = 'public')
    {
        parent::__construct($name, $attribute, $disk);

        $this->thumbnail(function () {
            return $this->formatUrl($this->value);
        })->preview(function () {
            return $this->formatUrl($this->value);
        });
    }

    /**
     * 格式化图像显示的URL
     *
     * @param $value
     * @return Collection|null
     */
    protected function formatUrl($value)
    {
        return Collection::wrap($value)->filter()->map(function ($url) {
            return Storage::disk($this->getStorageDisk())->url($url);
        });
    }

    /**
     * 根据传入的请求对模型上的给定属性进行合并
     *
     * @param  NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return mixed
     */
    protected function fillAttribute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $files = $request->file($requestAttribute);

        $deletes = $request->get('deletes');

        $images = Collection::make($model->{$attribute});

        $paths = Collection::make($files)->map(function (UploadedFile $file) {
            return $file->store($this->getStorageDir(), $this->getStorageDisk());
        });

        if (!empty($deletes)) {
            $des = Collection::make($deletes)->each(function (string $path) {
                Storage::disk($this->getStorageDisk())->delete($path);
            });

            $images = $images->diff($des);
        }

        return $model->{$attribute} = $request->get('order') === 'before' ? $paths->merge($images) : $images->merge($paths);
    }

    /**
     * 图片插入方式
     *
     * @param  string  $order after | before
     */
    public function order($order = 'after')
    {
        $this->order = $order;
    }

    /**
     * 为JSON序列化准备field元素.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'order' => $this->order
        ]);
    }
}
