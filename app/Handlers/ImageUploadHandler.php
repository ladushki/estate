<?php declare(strict_types = 1);

namespace App\Handlers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageUploadHandler
{

    /**
     * @var string
     */
    private string $destination;

    /**
     * @var integer
     */
    private int $width;

    /**
     * @var integer
     */
    private int $height;

    /**
     * ImageUploadHandler constructor.
     */
    public function __construct()
    {
        $this->destination = public_path('images');
        $this->width = config('estate.thumb.h');
        $this->height = config('estate.thumb.w');
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file File.
     * @return array|string[]
     */
    public function upload(UploadedFile $file): array
    {
        $ext  = $file->getClientOriginalExtension();
        $full = $this->getFileName($ext);
        $thumbnail = $this->getThumbnailName($full);
        $img = Image::make($file->getRealPath());

        $img->resize($this->width, $this->height, static function ($constraint) {
            $constraint->aspectRatio();
        })->save($this->destination.'/'.$thumbnail);
        Storage::disk('public')->putFileAs('images', $file, $full);
        $file->move($this->destination, $full);

        return [$full, $thumbnail];
    }

    /**
     * @param string $ext
     * @return string
     */
    public function getFileName(string $ext): string
    {
        return Str::random(20) . '.' . $ext;
    }

    /**
     * @param string $full
     * @return string
     */
    public function getThumbnailName(string $full): string
    {
        return config('estate.thumb.prefix') . '_' . $full;
    }
}
