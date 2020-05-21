<?php

namespace App\Traits;

trait PropertyAttributes
{
    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->town;
    }

    /**
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->town . ' ' . $this->postcode . ' ' . $this->country;
    }

    /**
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->getLargeImageAttribute();
    }

    /**
     * @return string
     */
    public function getLargeImageAttribute()
    {
        return $this->getImageLink($this->image_full, [730, 400]);
    }

    /**
     * @return string
     */
    public function getThumbnailAttribute()
    {
        return $this->getImageLink($this->image_thumbnail, [250, 190]);
    }

    /**
     * @return string
     */
    public function getMapLinkAttribute()
    {
        return config('estate.map_link') . $this->latitude . ',' . $this->longitude;
    }

}
