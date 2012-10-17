
<div class="row fluid">
    <div class="well span6 card">
        <h4 class="nav-header top">Flagged Comments</h4>
        <br />
        <div class="left span10">
	<?php foreach ($flagged as $comment): ?>
		<?php $this->renderPartial('comment', array('comment'=>$comment)); ?>
	<?php endforeach; ?>
        </div>
    </div>

    <div class="well span6 card">
        <h4 class="nav-header top">Unapproved Comments</h4>
        <br />
        <div class="left span10">
	<?php foreach ($notapproved as $comment): ?>
		<?php $this->renderPartial('comment', array('comment'=>$comment)); ?>
	<?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row fluid">
<div class="well card">
	<div class="top">
	<div>
		<h4 class="nav-header left">Active Comments</h4>
		<?php echo CHtml::button('Search', array('class'=>'btn btn-primary right')); ?>
		<?php echo CHtml::textField('search', NULL, array('placeholder'=>'Search for Comment', 'class'=>'right', 'style'=>'margin-right: 10px;')); ?>
	</div>
	<div style="clear:both;"></div>
	</div>
	<br />
	<div class="left">
	</div>
</div>
</div>
