<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreMedialAction
{
    public function execute(UploadedFile $file): string
    {
        return Storage::put('uploads', $file);
    }
}
