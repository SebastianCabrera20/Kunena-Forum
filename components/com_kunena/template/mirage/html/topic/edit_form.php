<?php
/**
 * Kunena Component
 * @package Kunena.Template.Default20
 * @subpackage Topic
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

JHTML::_('behavior.formvalidation');
JHTML::_('behavior.tooltip');
JHTML::_('kunenafile.uploader', 'kuploader');
?>
<div class="block-wrapper box-color box-border box-border_radius box-shadow">
	<div class="block">
		<div class="headerbox-wrapper">
			<div class="header">
				<h2 class="header"><span><?php echo $this->escape($this->title)?></span></h2>
			</div>
		</div>
		<form action="<?php echo KunenaRoute::_('index.php?option=com_kunena') ?>" enctype="multipart/form-data" name="postform" method="post" id="postform" class="postform form-validate">
			<input type="hidden" name="view" value="topic" />
			<?php if ($this->message->exists()) : ?>
			<input type="hidden" name="task" value="edit" />
			<input type="hidden" name="mesid" value="<?php echo intval($this->message->id) ?>" />
			<?php else: ?>
			<input type="hidden" name="task" value="post" />
			<input type="hidden" name="parentid" value="<?php echo intval($this->message->parent) ?>" />
			<?php endif; ?>
			<?php if (empty($this->selectcatlist)) : ?>
			<input type="hidden" name="catid" value="<?php echo intval($this->topic->category_id) ?>" />
			<?php endif; ?>
			<?php if ($this->catid && $this->catid != $this->message->catid) : ?>
			<input type="hidden" name="return" value="<?php echo intval($this->catid) ?>" />
			<?php endif; ?>
			<?php echo JHTML::_( 'form.token' ); ?>
		<div class="detailsbox-wrapper">
			<div class="detailsbox box-border box-border_radius box-shadow">
				<ul class="kform postmessage-list clearfix">

					<?php if (isset($this->selectcatlist)): ?>
					<li id="kpost-category" class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="kpostcatid"><?php echo JText::_('COM_KUNENA_POST_IN_CATEGORY')?></label>
						</div>
						<div class="form-field">
							<?php echo $this->selectcatlist ?>
						</div>
					</li>
					<?php endif; ?>

					<?php if ($this->message->userid) : ?>
					<li style="display: none" id="kanynomous-check" class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="kanonymous">
								<?php echo JText::_('COM_KUNENA_POST_AS_ANONYMOUS'); ?>
							</label>
						</div>
						<div class="form-field">
							<input type="checkbox" value="1" name="anonymous" id="kanonymous" class="hasTip" title="<?php echo JText::_('COM_KUNENA_POST_AS_ANONYMOUS') ?> :: <?php echo JText::_('COM_KUNENA_POST_AS_ANONYMOUS_CHECK') ?>" <?php if ($this->post_anonymous) echo 'checked="checked"'; ?> />
							<div class="kform-note"><?php echo JText::_('COM_KUNENA_POST_AS_ANONYMOUS_DESC'); ?></div>
						</div>
					</li>
					<?php endif; ?>

					<li style="display: none" id="kanynomous-check-name" class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="kauthorname">
								<?php echo JText::_('COM_KUNENA_GEN_NAME'); ?>
							</label>
						</div>
						<div class="form-field">
							<input type="text" value="<?php echo $this->escape($this->message->name) ?>" maxlength="35" class="inputbox postinput required hasTip" size="35" name="authorname" id="kauthorname" disabled="disabled" title="<?php echo JText::_('COM_KUNENA_GEN_NAME') ?> :: <?php echo JText::_('COM_KUNENA_MESSAGE_ENTER_NAME') ?>" />
						</div>
					</li>

					<?php if ($this->config->askemail && !$this->me->exists()) : ?>
					<li id="kanynomous-email" class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="kauthorname">
								<?php echo JText::_('COM_KUNENA_GEN_EMAIL'); ?>
							</label>
						</div>
						<div class="form-field">
							<div><input type="text" value="<?php echo $this->escape($this->message->email) ?>" maxlength="35" class="inputbox postinput required hasTip" size="35" name="password" id="kpassword" title="<?php echo JText::_('COM_KUNENA_GEN_EMAIL') ?> :: <?php echo JText::_('COM_KUNENA_MESSAGE_ENTER_EMAIL') ?>" /></div>
							<div><?php echo $this->config->showemail == '0' ? JText::_('COM_KUNENA_POST_EMAIL_NEVER') : JText::_('COM_KUNENA_POST_EMAIL_REGISTERED'); ?></div>
						</div>
					</li>
					<?php endif; ?>

					<li class="post-subject postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="ksubject">
								<?php echo JText::_('COM_KUNENA_GEN_SUBJECT'); ?>
							</label>
						</div>
						<div class="form-field">
							<input type="text" value="<?php echo $this->escape($this->message->subject) ?>" maxlength="<?php echo $this->escape($this->config->maxsubject) ?>" size="35" id="ksubject" name="subject" class="box-width inputbox postinput required hasTip" title="<?php echo JText::_('COM_KUNENA_GEN_SUBJECT') ?> :: <?php echo JText::_('COM_KUNENA_ENTER_SUBJECT') ?>" />
						</div>
					</li>
					<?php if ($this->message->parent==0 && $this->config->topicicons) : ?>
					<li class="post-topicicons postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="topic_emoticon_default">
								<?php echo JText::_('COM_KUNENA_GEN_TOPIC_ICON'); ?>
							</label>
						</div>
						<div class="form-field">
							<ul>
								<?php foreach ($this->topicIcons as $id=>$icon) : ?>
								<li class="hasTip" title="Topic icon :: <?php echo $this->escape(ucfirst($icon->name)) ?>">
									<input type="radio" name="topic_emoticon" id="topic_emoticon_<?php echo $this->escape($icon->name) ?>" value="<?php echo $icon->id ?>" <?php echo !empty($icon->checked) ? ' checked="checked" ':'' ?> />
									<label for="topic_emoticon_<?php echo $this->escape($icon->name) ?>"><img src="<?php echo $this->ktemplate->getTopicIconIndexPath($icon->id, true) ?>" alt="" border="0" /></label>
								</li>
								<?php endforeach ?>
							</ul>
						</div>
					</li>
					<?php endif ?>

					<?php echo $this->loadTemplateFile('editor'); ?>

					<li class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="kupload">
								<?php echo JText::_('COM_KUNENA_EDITOR_ATTACHMENTS') ?>
							</label>
						</div>
						<div id="kuploader" class="form-field">
							<input id="kupload" class="kupload" name="kattachment" type="file" />
						</div>
					</li>

					<?php if ($this->config->keywords && $this->me->isModerator ( $this->message->catid ) ) : ?>
					<li class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="ktags">
								<?php echo JText::_('COM_KUNENA_EDITOR_TOPIC_TAGS') ?>
							</label>
						</div>
						<div class="form-field">
							<input type="text" value="<?php echo $this->escape($this->topic->getKeywords(false, ', ')); ?>" maxlength="100" size="35" id="ktags" name="tags" class="box-width inputbox postinput hasTip" title="<?php echo JText::_('COM_KUNENA_EDITOR_TOPIC_TAGS') ?> :: <?php echo JText::_('COM_KUNENA_EDITOR_TOPIC_TAGS_ADD_COMMAS') ?>" />
						</div>
					</li>
					<?php endif; ?>

					<?php if ($this->config->userkeywords && $this->my->id) : ?>
					<li class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="kmytags">
								<?php echo JText::_('COM_KUNENA_EDITOR_TOPIC_TAGS_OWN') ?>
							</label>
						</div>
						<div class="form-field">
							<input type="text" value="<?php echo $this->escape($this->topic->getKeywords($this->my->id, ', ')); ?>" maxlength="100" size="35" id="kmytags" name="mytags" class="box-width inputbox postinput hasTip" title="<?php echo JText::_('COM_KUNENA_EDITOR_TOPIC_TAGS_OWN') ?> :: <?php echo JText::_('COM_KUNENA_EDITOR_TOPIC_TAGS_ADD_COMMAS') ?>" />
						</div>
					</li>
					<?php endif; ?>

					<?php if ($this->canSubscribe()) : ?>
					<li class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label for="ksubscribe-me">
								<?php echo JText::_('COM_KUNENA_POST_SUBSCRIBE'); ?>
							</label>
						</div>
						<div class="form-field">
							<label for="ksubscribe-me" class="hasTip" title="<?php echo JText::_('COM_KUNENA_POST_SUBSCRIBE'); ?> :: <?php echo JText::_('COM_KUNENA_POST_NOTIFIED'); ?>">
								<input type="checkbox" value="1" name="subscribe-me" id="ksubscribe-me" <?php if ($this->subscriptionschecked == 1) echo 'checked="checked"' ?> />
									<i><?php echo JText::_('COM_KUNENA_POST_NOTIFIED'); ?></i>
							</label>
						</div>
					</li>
					<?php endif; ?>
					<?php if (!empty($this->captchaHtml)) : ?>
					<li class="postmessage-row box-hover box-hover_list-row">
						<div class="form-label">
							<label>
								<?php echo JText::_('COM_KUNENA_CAPDESC'); ?>
							</label>
						</div>
						<div class="form-field">
							<?php echo $this->captchaHtml ?>
						</div>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
			<div class="kpost-buttons">
				<button class="kbutton hasTip" type="submit" title="<?php echo JText::_('COM_KUNENA_GEN_CONTINUE').' :: '.JText::_('COM_KUNENA_EDITOR_HELPLINE_SUBMIT') ?>"><?php echo JText::_('COM_KUNENA_GEN_CONTINUE') ?></button>
				<button class="kbutton hasTip" type="button" title="<?php echo JText::_('COM_KUNENA_GEN_CANCEL').' :: '.JText::_('COM_KUNENA_EDITOR_HELPLINE_CANCEL') ?>" onclick="javascript:window.history.back();"><?php echo JText::_('COM_KUNENA_GEN_CANCEL') ?></button>
			</div>
		</form>
	</div>
</div>
<div class="spacer"></div>
<?php
if (!$this->message->name) {
	echo '<script type="text/javascript">document.postform.authorname.focus();</script>';
} else if (!$this->topic->subject) {
	echo '<script type="text/javascript">document.postform.subject.focus();</script>';
} else {
	echo '<script type="text/javascript">document.postform.message.focus();</script>';
}
?>
<?php $this->displayThreadHistory (); ?>