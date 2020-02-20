<?php
$where = $modx->newQuery('Comment');
$where->sortby('id','ASC');
$where->where(array(
    'resursid' => $modx->resource->get('id')
));

$comments = $modx->getCollection('Comment',$where);

$alias = $modx->resource->get('uri');

$categoryTree = [];
foreach ($comments as $res) {
    if($res->get('parentid') == 0) {
        $categoryTree[$res->get('id')][] = $res;
    }
    else {
        $categoryTree[$res->get('parentid')][] = $res;
    }
}


foreach ($categoryTree as $k => $value) {

echo '<article class="comment">';

    if ($pdoTools = $modx->getService('pdoTools')) {
        $output = $pdoTools->getChunk('@FILE: particular/article/commentItem.html', array(
            'userid' => $value[0]->get('userid'),
            'time' => $value[0]->get('create'),
            'idcomment' => $value[0]->get('id'),
            'comment' => $value[0]->get('comment'),
            'delete' => $value[0]->get('delete'),
            'alias' => $alias
        ));
        echo $output;


        if(!empty($value[1])) {

            foreach($value as $key => $val) {
                if($key != 0) {
                    $output = $pdoTools->getChunk('@FILE: particular/article/commentItem.html', array(
                        'userid' => $value[$key]->get('userid'),
                        'time' => $value[$key]->get('create'),
                        'idcomment' => $value[$key]->get('id'),
                        'comment' => $value[$key]->get('comment'),
                        'delete' => $value[$key]->get('delete'),
                        'alias' => $alias
                    ));
                    echo '<article class="comment">'.$output.'</article>';
                }
            }

        }

    }

echo '</article>';

}
