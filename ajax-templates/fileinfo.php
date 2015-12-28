<?php

$values = array(
    'title'     => _('Title'),
    'artist'    => _('Artist'),
    'album'     => _('Album'),
    'genre'     => _('Genre'),
    'originalTrackNumber' => _('Track#'),
    'date'      => _('Date'),
    'author'    => _('Author'),
    'actor'     => _('Actor'),
    'longDescription' => _('Description')
);

?>
<h2><?php echo $item->title ?></h2>

<?php if(isset($image)): ?>
    <img src="resources.php?image=<?php echo urlencode($image) ?>&w=200" style="float: left; margin-right: 10px; margin-bottom: 10px;" />
<?php endif ?>

<table>
<?php foreach($values as $key => $value): ?>
<?php if(isset($item->$key) && trim($item->$key != '')): ?>
<tr valign="top">
    <td><?php echo $value ?>:</td><td><?php echo $item->$key ?></td>
</tr>
<?php endif ?>
<?php endforeach ?>
</table>

<br class="clear" />
