<div class="comment comment-<?php echo $comment->id; ?>" style="margin-left: <?php echo $depth*4 * 10; ?>px">
	<?php echo CHtml::image($comment->author->gravatarImage(30), NULL, array('class' => 'rounded-image avatar')); ?>
	<div class="<?php echo $comment->author->id == $comment->content->author->id ? 'green-indicator author-indicator' : NULL; ?>">
		<div class="comment-body comment-byline">
			<?php echo $comment->author->name; ?>
			<?php if ($comment->parent_id != 0): ?>
				<span class="icon-share-alt"></span> <?php echo $comment->parent->author->name; ?> •
			<?php else: ?>
			 •
			<?php endif; ?>
			<time class="timeago" title="<?php echo date('c', strtotime($comment->created)); ?>">
				<?php echo Cii::formatDate($comment->created); ?>
			</time>
		</div>
		<div class="comment-body">
			<?php echo $md->safeTransform($comment->comment); ?>
		</div>
		<div class="comment-body comment-byline comment-byline-footer">
			<?php if (!Yii::app()->user->isGuest): ?>
				<span class="reply">reply</span> • <span class="flag <?php echo $comment->approved == -1 ? 'flagged' : NULL; ?>" data-attr-id="<?php echo $comment->id; ?>"><?php echo $comment->approved == -1 ? 'flagged' : 'flag'; ?></span>
			<?php endif; ?>
		</div>
	</div>
		<?php $model = new Comments(); ?>
		<?php $comment->parent_id = $comment->parent_id; ?>
		<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		    'id'=>'comment-form',
		    'htmlOptions' => array('style' => 'display:none; padding-left: 50px; margin-top: 10px; margin-bottom: 0px; padding-bottom: -10px;')
		)); ?>
			<?php echo $form->textField($model, 'comment', array('class'=>'span10')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit', 
				'type' => 'primary',
				'label'=>'Submit',
				'htmlOptions' => array(
					'style' => 'margin-top: -10px'
				)
			)); ?>
		<?php $this->endWidget(); ?>
	<div class="clearfix"></div>
</div>