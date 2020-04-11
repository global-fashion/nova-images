<?php

namespace Sbing\Nova\Images\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Sbing\Nova\Images\Requests\UploadRequest;

class UploadController extends Controller
{
    public function upload(UploadRequest $request)
    {
        $files = $request->allFiles();

        return Collection::wrap($files)
            ->flatten(1)
            ->map(
                function (UploadedFile $file) use ($request) {
                    return [
                        'path' => $path = $file->store($request->get('storagePath', '/')),
                        'url' => Storage::disk($request->get('disk'))->url($path),
                    ];
                }
            );
    }

    public function delete(UploadRequest $request, $file)
    {
        return ['is_deleted' => Storage::disk($request->get('disk'))->delete($file)];
    }
}
