<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 22.08.2018
 * Time: 14:15
 */

namespace App\Media;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;
use App\User;
use Illuminate\Support\Facades\Auth;

class CustomPath implements PathGenerator
{


    public function getPath(Media $media): string
    {
        return 'Bzdykin/default/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'/responsive/';
    }
}