<?php

namespace App\Http\Controllers;

use App\Models\ListingPhoto;

class ListingPhotoController extends Controller
{
    public function show(ListingPhoto $photo)
    {
        $data = $photo->photo;
        if (is_resource($data)) {
            $data = stream_get_contents($data); // PostgreSQL returns bytea as a stream
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($data) ?: 'image/jpeg';

        return response($data, 200, [
            'Content-Type' => $mime,
            'Cache-Control' => 'private, max-age=86400',
        ]);
    }
}