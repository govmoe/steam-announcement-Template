<?php
/**
 * 文章页模板 - Steam公告风格
 * 
 * @package SteamAnnouncement
 */

// 引入头部模板
$this->need('header.php');
?>

<div class="page-wrapper">
    <!-- 左侧导航 - Steam风格 -->
    <nav class="main-navigation">
        <ul class="nav-menu">
            <?php
            // 获取侧边导航菜单配置
            $menuConfig = $this->options->sidebarMenu;
            $menuItems = parseSidebarMenu($menuConfig);
            
            // 输出导航菜单项
            foreach ($menuItems as $item) {
                $isGroupTitle = ($item['url'] == '#');
                $isActive = false;
                
                // 检查是否为当前页面
                if (!$isGroupTitle) {
                    $currentUrl = $this->request->getPathinfo();
                    $itemUrl = parse_url($item['url'], PHP_URL_PATH);
                    $isActive = ($currentUrl == $itemUrl);
                }
                
                if ($isGroupTitle) {
                    // 分组标题
                    echo '<li class="nav-item"><span class="nav-group-title">' . htmlspecialchars($item['name']) . '</span></li>';
                } else {
                    // 普通菜单项
                    echo '<li class="nav-item"><a href="' . htmlspecialchars($item['url']) . '" class="nav-link' . ($isActive ? ' active' : '') . '">' . htmlspecialchars($item['name']) . '</a></li>';
                }
            }
            
            // 输出Typecho页面导航
            $this->widget('Widget_Contents_Page_List')->to($pages);
            if ($pages->have()) {
                echo '<li class="nav-item"><span class="nav-group-title">页面</span></li>';
                while($pages->next()):
                    $isActive = ($this->is('page') && $this->cid == $pages->cid);
                    echo '<li class="nav-item"><a href="' . htmlspecialchars($pages->permalink) . '" class="nav-link' . ($isActive ? ' active' : '') . '">' . htmlspecialchars($pages->title) . '</a></li>';
                endwhile;
            }
            ?>
        </ul>
    </nav>
    
    <!-- 主内容区 -->
    <div class="content-container">
        <main class="main-content">
            <div class="container">
                <!-- 文章内容 -->
                <article class="single-post">
                    <!-- 文章特色图片 -->
                    <?php if ($thumbnail = $this->fields->thumbnail): ?>
                    <div class="post-featured-image">
                        <img src="<?php echo $thumbnail; ?>" alt="<?php $this->title(); ?>">
                    </div>
                    <?php endif; ?>
                    
                    <!-- 文章头部 -->
                    <header class="post-header">
                        <h1 class="post-title"><?php $this->title(); ?></h1>
                        <div class="post-meta">
                            <span class="post-meta-item">
                                <i class="far fa-calendar"></i>
                                <?php $this->date('Y-m-d H:i'); ?>
                            </span>
                            <span class="post-meta-item">
                                <i class="far fa-user"></i>
                                <?php $this->author(); ?>
                            </span>
                            <span class="post-meta-item">
                                <i class="far fa-folder"></i>
                                <?php $this->category(', '); ?>
                            </span>
                            <span class="post-meta-item">
                                <i class="far fa-comment"></i>
                                <?php $this->commentsNum('暂无评论', '1条评论', '%d条评论'); ?>
                            </span>
                        </div>
                    </header>
                    
                    <!-- 文章正文 -->
                    <div class="post-content">
                        <?php $this->content(); ?>
                    </div>
                    
                    <!-- 文章底部 -->
                    <footer class="post-footer">
                        <div class="post-tags">
                            <i class="fas fa-tags"></i>
                            <?php $this->tags(' ', true, '无标签'); ?>
                        </div>
                    </footer>
                </article>
                
                <!-- 评论区 -->
                <section class="comments-section">
                    <h3 class="comments-title"><?php $this->commentsNum('暂无评论', '1条评论', '%d条评论'); ?></h3>
                    
                    <!-- 评论列表 -->
                    <div id="comments">
                        <?php $this->comments()->to($comments); ?>
                        
                        <?php if ($comments->have()): ?>
                            <ol class="comment-list">
                                <?php $comments->listComments(); ?>
                            </ol>
                            
                            <!-- 评论分页 -->
                            <?php if ($comments->have() && $comments->getTotal() > $comments->parameter->pageSize): ?>
                                <div class="comments-pagination">
                                    <?php $comments->pageNav('上一页', '下一页'); ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- 无评论状态 -->
                            <div class="no-comment">
                                <p>暂无评论，欢迎发表您的看法！</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- 评论表单 -->
                    <div id="respond">
                        <h3 class="respond-title">
                            <?php $this->is('post') ? _e('发表评论') : _e('发表回复'); ?>
                            <?php if($comments->isCommentable()): ?>
                                <small><?php $comments->cancelReply('取消回复'); ?></small>
                            <?php endif; ?>
                        </h3>
                        
                        <?php if($comments->isCommentable()): ?>
                            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" class="comment-form">
                                <!-- 访客信息（未登录用户） -->
                                <?php if(!$this->user->hasLogin()): ?>
                                    <div class="form-group">
                                        <label for="author">姓名 <span class="required">*</span></label>
                                        <input type="text" name="author" id="author" class="form-control" value="<?php $this->remember('author'); ?>" required />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="mail">邮箱 <span class="required">*</span></label>
                                        <input type="email" name="mail" id="mail" class="form-control" value="<?php $this->remember('mail'); ?>" required />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="url">网站</label>
                                        <input type="url" name="url" id="url" class="form-control" value="<?php $this->remember('url'); ?>" />
                                    </div>
                                <?php endif; ?>
                                
                                <!-- 评论内容 -->
                                <div class="form-group">
                                    <label for="text">评论内容 <span class="required">*</span></label>
                                    <textarea name="text" id="text" class="form-control" rows="5" required><?php $this->remember('text'); ?></textarea>
                                </div>
                                
                                <!-- 安全验证和提交按钮 -->
                                <div class="form-group">
                                    <?php $this->security->protect(); ?>
                                    <button type="submit" class="submit-btn">发表评论</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <!-- 评论关闭状态 -->
                            <p class="comment-closed">评论已关闭</p>
                        <?php endif; ?>
                    </div>
                </section>
                
                <!-- 相关文章 -->
                <div class="related-posts">
                    <h3 class="related-title">相关文章</h3>
                    <div class="related-list">
                        <?php $this->related(5)->to($relatedPosts); ?>
                        
                        <?php if($relatedPosts->have()): ?>
                            <?php while($relatedPosts->next()): ?>
                                <article class="related-card">
                                    <!-- 相关文章封面图 -->
                                    <div class="related-card-thumbnail">
                                        <?php $thumbnail = $relatedPosts->fields->thumbnail ? $relatedPosts->fields->thumbnail : 'https://via.placeholder.com/120x68'; ?>
                                        <img src="<?php echo $thumbnail; ?>" alt="<?php $relatedPosts->title(); ?>">
                                    </div>
                                    
                                    <!-- 相关文章内容 -->
                                    <div class="related-card-content">
                                        <h4 class="related-post-title">
                                            <a href="<?php $relatedPosts->permalink(); ?>" title="<?php $relatedPosts->title(); ?>"><?php $relatedPosts->title(); ?></a>
                                        </h4>
                                        <div class="related-post-meta">
                                            <span><?php $relatedPosts->date('Y-m-d'); ?></span>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>暂无相关文章</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- 引入底部模板 -->
        <?php $this->need('footer.php'); ?>
    </div>
</div>

<!-- 评论回复功能JS -->
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
                response = this.dom('respond'),
                input = this.dom('comment-parent'),
                form = response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];
            
            // 创建parent输入框（如果不存在）
            if (!input) {
                input = this.create('input', {
                    'type': 'hidden',
                    'name': 'parent',
                    'id': 'comment-parent'
                });
                form.appendChild(input);
            }
            input.setAttribute('value', coid);
            
            // 创建评论表单占位符（如果不存在）
            if (!this.dom('comment-form-place-holder')) {
                var holder = this.create('div', {'id': 'comment-form-place-holder'});
                response.parentNode.insertBefore(holder, response);
            }
            
            // 将评论表单移动到评论下方
            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';
            
            // 聚焦到评论框
            if (textarea) {
                textarea.focus();
            }
            
            return false;
        },
        
        cancelReply: function() {
            var response = this.dom('respond'),
                holder = this.dom('comment-form-place-holder'),
                input = this.dom('comment-parent');
            
            // 移除parent输入框
            if (input) {
                input.parentNode.removeChild(input);
            }
            
            // 恢复评论表单位置
            if (holder) {
                holder.parentNode.insertBefore(response, holder);
                this.dom('cancel-comment-reply-link').style.display = 'none';
            }
            
            return false;
        }
    };
})();
</script>