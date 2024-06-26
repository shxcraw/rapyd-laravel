<?php namespace Zofe\Rapyd\Demo;

use Eloquent;

/**
 * ArticleDetail
 */
class ArticleDetail extends Eloquent
{

    public $timestamps = false;
    protected $table = 'demo_article_detail';

    public function article()
    {
        return $this->belongsTo('Zofe\Rapyd\Models\Article', 'article_id');
    }

}
