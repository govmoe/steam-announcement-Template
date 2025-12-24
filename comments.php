<?php
/**
 * 评论模板
 * 
 * @package SteamAnnouncement
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

<div id="comments" class="comments-area">
    <?php $this->comments()->to($comments); ?>

    <?php if ($comments->have()): ?>
    <h3 class="comments-title"><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>

    <ol class="comment-list">
        <?php $comments->listComments(); ?>
    </ol>

    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;', 1, '...', array('wrapTag' => 'div', 'wrapClass' => 'comment-navigation', 'itemTag' => 'span', 'textTag' => 'a', 'currentClass' => 'current')); ?>

    <?php endif; ?>

    <?php if ($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="comment-respond">
        <h3 id="reply-title" class="comment-reply-title">
            <?php _e('添加新评论'); ?>
            <div class="cancel-comment-reply">
                <?php $comments->cancelReply(); ?>
            </div>
        </h3>

        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" class="comment-form" role="form">
            <?php if ($this->user->hasLogin()): ?>
            <p class="logged-in-as"><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"
                    class="username"><?php $this->user->screenName(); ?></a>. <a
                    href="<?php $this->options->logoutUrl(); ?>" title="<?php _e('退出登录'); ?>"
                    class="logout-link"><?php _e('退出'); ?></a></p>
            <?php else: ?>
            <div class="comment-form-fields">
                <div class="comment-form-author">
                    <label for="author" class="required"><?php _e('称呼'); ?>
                        <?php if($this->options->commentsRequireAuthor): ?><span
                            class="required">*</span><?php endif; ?></label>
                    <input type="text" name="author" id="author" class="text"
                        value="<?php $this->remember('author'); ?>" <?php if($this->options->commentsRequireAuthor): ?>
                        required<?php endif; ?> size="30" />
                </div>
                <div class="comment-form-email">
                    <label for="mail" <?php if ($this->options->commentsRequireMail): ?> class="required"
                        <?php endif; ?>><?php _e('Email'); ?> <?php if($this->options->commentsRequireMail): ?><span
                            class="required">*</span><?php endif; ?></label>
                    <input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"
                        <?php if($this->options->commentsRequireMail): ?> required<?php endif; ?> size="30" />
                </div>
                <div class="comment-form-url">
                    <label for="url" <?php if ($this->options->commentsRequireURL): ?> class="required"
                        <?php endif; ?>><?php _e('网站'); ?></label>
                    <input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>"
                        value="<?php $this->remember('url'); ?>" <?php if($this->options->commentsRequireURL): ?>
                        required<?php endif; ?> size="30" />
                </div>
            </div>
            <?php endif; ?>
            <div class="comment-form-comment">
                <label for="textarea" class="required"><?php _e('内容'); ?> <span class="required">*</span></label>
                <textarea rows="8" cols="50" name="text" id="textarea" class="textarea"
                    required><?php $this->remember('text'); ?></textarea>
            </div>
            <div class="form-submit">
                <button type="submit" class="submit btn btn-primary"><?php _e('提交评论'); ?></button>
                <?php $this->security->hash(); ?>
            </div>
        </form>
    </div>
    <?php else: ?>
    <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
</div>

<!-- 加载Typecho评论JS -->
<script type="text/javascript">
(function() {
    window.TypechoComment = {
        dom: function(id) {
            return document.getElementById(id);
        },
        create: function(tag, attr) {
            var el = document.createElement(tag);
            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }
            return el;
        },
        reply: function(cid, coid) {
            var comment = this.dom(cid),
                parent = comment.parentNode,
                response = this.dom('<?php $this->respondId(); ?>'),
                input = this.dom('comment-parent'),
                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];

            if (null == input) {
                input = this.create('input', {
                    'type': 'hidden',
                    'name': 'parent',
                    'id': 'comment-parent'
                });
                form.appendChild(input);
            }
            input.setAttribute('value', coid);

            if (null == this.dom('comment-form-place-holder')) {
                var holder = this.create('div', {
                    'id': 'comment-form-place-holder'
                });
                response.parentNode.insertBefore(holder, response);
            }

            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';

            if (null != textarea && 'text' == textarea.name) {
                textarea.focus();
            }

            return false;
        },
        cancelReply: function() {
            var response = this.dom('<?php $this->respondId(); ?>'),
                holder = this.dom('comment-form-place-holder'),
                input = this.dom('comment-parent');

            if (null != input) {
                input.parentNode.removeChild(input);
            }

            if (null == holder) {
                return true;
            }

            this.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
            return false;
        }
    };
})();
</script>