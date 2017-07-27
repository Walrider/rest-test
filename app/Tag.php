<?php

namespace LoremPublishing;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publications()
    {
        return $this->belongsToMany('LoremPublishing\Publication', 'publication_tag', 'tag_id', 'publication_id');
    }
}
