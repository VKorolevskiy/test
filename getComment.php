
<?php


$where = $modx->newQuery('Comment');
$where->sortby('id','ASC');
$where->where(array(
    'resursid' => $modx->resource->get('id')
));

$comments = $modx->getCollection('Comment',$where);
 
foreach ($comments as $k => $res) {

    if ($res->get('parentid') == 0) {

    $userid = $res->get('userid');
    $time = $res->get('create');
    $comment = $res->get('comment');
    $idcomment = $res->get('id');
    $delete = $res->get('delete');

    if ($pdoTools = $modx->getService('pdoTools')) {


        $output = $pdoTools->getChunk('@FILE: particular/article/commentItem.html', array(
            'userid' => $userid,
            'time' => $time,
            'idcomment' => $idcomment,
            'comment' => $comment,
            'delete' => $delete,
            'alias' => $modx->resource->get('uri')
        ));

        echo $output;

    }
   }

}
?>
