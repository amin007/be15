			<p>Below we have listed all available icons that jQuery Mobile provides:</p>
			<a href="view-source:http://www.w3schools.com/jquerymobile/jquerymobile_ref_icons.asp">Icon Jqm</a>
<?php
$icons = array(
'action'=>'Action (arrow pointing clockwise out of a box)', 
'alert'=>'Alert', 
'audio'=>'Audio / Sound / Speakers', 
'arrow-d-l'=>'Arrow pointing downwards to the left', 
'arrow-d-r'=>'Arrow pointing downwards to the right', 
'arrow-u-l'=>'Arrow pointing upwards to the left', 
'arrow-u-r'=>'Arrow pointing upwards to the right', 
'arrow-l'=>'Arrow pointing left', 
'arrow-r'=>'Arrow pointing right', 
'arrow-u'=>'Arrow pointing up', 
'arrow-d'=>'Arrow pointing down', 
'back'=>'Back (curved arrow pointing counterclockwise upwards)',
'bars'=>'Bars (three horizontal bars over each other)',
'bullets'=>'Bullets (three horizontal bullets over each other)',
'calendar'=>'Calendar', 
'camera'=>'Camera', 
'carat-d'=>'Carat pointing down', 
'carat-l'=>'Carat pointing left', 
'carat-r'=>'Carat pointing right', 
'carat-u'=>'Carat pointing up', 
'check'=>'Checkmark', 
'clock'=>'Clock', 
'cloud'=>'Cloud', 
'comment'=>'Comment', 
'delete'=>'Delete (X)',
'edit'=>'Edit / Pencil', 
'eye'=>'Eye', 
'forbidden'=>'Forbidden sign', 
'forward'=>'Forward', 
'gear'=>'Gear', 
'grid'=>'Grid', 
'heart'=>'Heart / Love symbol', 
'home'=>'Home', 
'info'=>'Information', 
'location'=>'Location / GPS', 
'lock'=>'Lock / Padlock', 
'mail'=>'Mail / Letter', 
'minus'=>'Minus', 
'navigation'=>'Navigation', 
'phone'=>'Telephone', 
'power'=>'Power (On/off)',
'plus'=>'Plus', 
'recycle'=>'Recycle', 
'refresh'=>'Refresh', 
'search'=>'Search', 
'shop'=>'Shop / Pag / Purse', 
'star'=>'Star', 
'tag'=>'Tag', 
'user'=>'User / Person', 
'video'=>'Video Camera'
);
?>			
			<div class="table-responsive">
			<table border="0">
			<tr>
			<th>Icon</th>
			<th>Description</th>
			</tr>
<?php foreach ($icons as $key => $value) : ?>			
			<tr>
			<td><a href="#" class="ui-btn ui-icon-<?php echo $key ?> ui-btn-icon-left"><?php echo $key ?></a></td>
			<td><?php echo $value ?></td>
			</tr>
<?php endforeach; ?>
			</table>
			</div>
