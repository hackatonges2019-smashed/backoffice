<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticlesCaches extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles_caches';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
