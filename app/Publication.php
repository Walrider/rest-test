<?php

namespace LoremPublishing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Publication extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'text', 'cover_image',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('LoremPublishing\User', 'author_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('LoremPublishing\Tag', 'publication_tag', 'publication_id', 'tag_id');
    }

    /**
     * @return mixed
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    /**
     * @param Request $request
     */
    public function syncTags(Request $request)
    {
        if ($request->input('tag_list')) {
            $tags_list = collect($request->input('tag_list'));
            $publication_tags = collect([]);
            foreach ($tags_list as $tag) {
                $publication_tags->push($tag);
            }
            $this->tags()->sync($publication_tags->toArray());
        } else {
            $this->tags()->sync([]);
        }
    }


    /**
     * @return string
     */
    public function coverImageURL()
    {
        if ($this->cover_image && file_exists('images/' . $this->cover_image . '.jpg')) {
            return '/images/' . $this->cover_image . '.jpg';
        } else {
            return '/assets/img/placeholder.png';
        }
    }
}
