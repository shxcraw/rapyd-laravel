<?php namespace Zofe\Rapyd\Demo;

use Eloquent;

/**
 * Comment
 */
class Comment extends Eloquent
{

    protected $table = 'demo_comments';

    public function article()
    {
        return $this->belongsTo('Zofe\Rapyd\Models\Article', 'article_id');
    }

    public function author()
    {
        return $this->belongsTo('Zofe\Rapyd\Models\Author', 'author_id');
    }
}
