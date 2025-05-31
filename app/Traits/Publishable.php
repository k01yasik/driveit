<?php

namespace App\Traits;

trait Publishable
{
    public function publish(): bool
    {
        $this->is_published = true;
        $this->date_published = $this->date_published ?? now();
        return $this->save();
    }

    public function unpublish(): bool
    {
        $this->is_published = false;
        return $this->save();
    }

    public function isPublished(): bool
    {
        return $this->is_published && $this->date_published <= now();
    }
}
