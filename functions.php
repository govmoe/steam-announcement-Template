<?php
/**
 * 主题函数库
 * 
 * @package SteamAnnouncement
 */

/**
 * 主题配置面板
 * 
 * @param Typecho_Widget_Helper_Form $form 配置面板
 */
function themeConfig($form) {
    // 站点LOGO设置
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前显示一个LOGO'));
    $form->addInput($logoUrl);
    
    // 站点描述设置
    $description = new Typecho_Widget_Helper_Form_Element_Textarea('description', NULL, NULL, _t('站点描述'), _t('在这里输入站点描述，将显示在首页头部'));
    $form->addInput($description);
    
    // 自定义CSS
    $customCss = new Typecho_Widget_Helper_Form_Element_Textarea('customCss', NULL, NULL, _t('自定义CSS'), _t('在这里输入自定义CSS代码，可以覆盖主题默认样式'));
    $form->addInput($customCss);
    
    // 自定义JavaScript
    $customJs = new Typecho_Widget_Helper_Form_Element_Textarea('customJs', NULL, NULL, _t('自定义JavaScript'), _t('在这里输入自定义JavaScript代码'));
    $form->addInput($customJs);
    
    // Steam个人资料地址设置
    $steamUrl = new Typecho_Widget_Helper_Form_Element_Text('steamUrl', NULL, NULL, _t('Steam个人资料地址'), _t('输入你的Steam社区个人资料地址'));
    $form->addInput($steamUrl);
    
    $twitterUrl = new Typecho_Widget_Helper_Form_Element_Text('twitterUrl', NULL, NULL, _t('Twitter链接'), _t('输入你的Twitter地址'));
    $form->addInput($twitterUrl);
    
    $githubUrl = new Typecho_Widget_Helper_Form_Element_Text('githubUrl', NULL, NULL, _t('GitHub链接'), _t('输入你的GitHub地址'));
    $form->addInput($githubUrl);
    
    $discordUrl = new Typecho_Widget_Helper_Form_Element_Text('discordUrl', NULL, NULL, _t('Discord链接'), _t('输入你的Discord地址'));
    $form->addInput($discordUrl);
    
    // 侧边导航菜单设置
    $sidebarMenu = new Typecho_Widget_Helper_Form_Element_Textarea('sidebarMenu', NULL, "新闻中心|#
首页|/
全部游戏|#
最近游玩|#
愿望单|#", _t('侧边导航菜单'), _t('每行一个菜单项，格式：菜单名称|链接地址，如：首页|/。使用#表示当前页面或分组标题。'));
    $form->addInput($sidebarMenu);
    
    // 公告栏设置
    $announcement = new Typecho_Widget_Helper_Form_Element_Textarea('announcement', NULL, "SteamAnnouncement模板1.0发布了\n这是一个模仿Steam公告风格的Typecho模板，支持响应式设计和自定义配置。", _t('公告栏内容'), _t('在这里输入公告内容，支持多行，将显示在首页顶部公告栏位置'));
    $form->addInput($announcement);
}

/**
 * 主题初始化
 */
function themeInit() {
    // 移除了自定义路由注册，避免Typecho版本兼容性问题
}

/**
 * 自定义评论列表HTML
 * 
 * @param Typecho_Widget_Abstract_Comments $comments 评论对象
 * @param array $options 评论选项
 */
function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';
    ?>
<li id="li-<?php $comments->theId(); ?>" class="comment<?php 
    if ($comments->_levels > 0) {
        echo ' comment-child';
        $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
    } else {
        echo ' comment-parent';
    }
    $comments->alt(' comment-odd', ' comment-even');
    echo $commentClass;
    ?>">
    <div id="<?php $comments->theId(); ?>" class="comment-body">
        <div class="comment-author-avatar">
            <?php $comments->gravatar('48', ''); ?>
        </div>
        <div class="comment-content">
            <div class="comment-meta">
                <span class="comment-author"><?php $comments->author(); ?></span>
                <span class="comment-date"><?php $comments->date('Y-m-d H:i'); ?></span>
                <span class="comment-actions">
                    <?php $comments->reply(); ?>
                    <?php if($comments->status=='approved'): ?>
                    <?php $comments->edit(); ?>
                    <?php endif; ?>
                </span>
            </div>
            <div class="comment-text">
                <?php $comments->content(); ?>
            </div>
        </div>
    </div>
    <?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </div>
    <?php } ?>
</li>
<?php
}

/**
 * 截取文章摘要
 * 
 * @param string $text 文章内容
 * @param int $length 摘要长度
 * @return string 截取后的摘要
 */
function customExcerpt($text, $length = 150) {
    $text = strip_tags($text);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);
    
    if (mb_strlen($text) > $length) {
        $text = mb_substr($text, 0, $length);
        $text .= '...';
    }
    
    return $text;
}

/**
 * 获取文章浏览量
 * 
 * @param int $cid 文章ID
 * @return int 浏览量
 */
function getViews($cid) {
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('table.contents.views')->from('table.contents')->where('table.contents.cid = ?', $cid));
    return $row['views'] ? $row['views'] : 0;
}

/**
 * 增加文章浏览量
 * 
 * @param int $cid 文章ID
 */
function increaseViews($cid) {
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('table.contents.views')->from('table.contents')->where('table.contents.cid = ?', $cid));
    $views = $row['views'] ? $row['views'] : 0;
    $views++;
    $db->query($db->update('table.contents')->rows(array('views' => $views))->where('table.contents.cid = ?', $cid));
}

/**
 * 解析侧边栏菜单配置
 * 
 * @param string $menuConfig 菜单配置字符串
 * @return array 解析后的菜单数组
 */
function parseSidebarMenu($menuConfig) {
    $menu = array();
    $lines = explode("\n", $menuConfig);
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        $parts = explode('|', $line, 2);
        if (count($parts) == 2) {
            $menu[] = array(
                'name' => trim($parts[0]),
                'url' => trim($parts[1])
            );
        }
    }
    
    return $menu;
}

/**
 * 获取文章自定义字段
 * 
 * @param string $name 字段名称
 * @param string $default 默认值
 * @return string 字段值
 */
function getPostMeta($name, $default = '') {
    $db = Typecho_Db::get();
    $cid = Typecho_Widget::widget('Widget_Archive')->cid;
    $row = $db->fetchRow(
        $db->select('table.fields.str_value')
           ->from('table.fields')
           ->where('table.fields.cid = ?', $cid)
           ->where('table.fields.name = ?', $name)
    );
    return $row ? $row['str_value'] : $default;
}

/**
 * 注册文章自定义字段编辑器
 * 
 * @param Typecho_Widget_Helper_Form $form 表单对象
 */
function postFields(Typecho_Widget_Helper_Form $form) {
    // 文章封面图字段
    $thumbnail = new Typecho_Widget_Helper_Form_Element_Text('thumbnail', NULL, NULL, _t('文章封面图'), _t('输入封面图片的URL地址，用于文章列表和首页展示'));
    $form->addInput($thumbnail);
    
    // 自定义摘要字段
    $customExcerpt = new Typecho_Widget_Helper_Form_Element_Textarea('customExcerpt', NULL, NULL, _t('自定义摘要'), _t('输入自定义摘要内容，用于文章列表和首页展示，不填写则自动截取文章内容'));
    $form->addInput($customExcerpt);
}

// 注册文章自定义字段钩子
typecho_Plugin::factory('admin/write-post.php')->write = 'postFields';
typecho_Plugin::factory('admin/write-page.php')->write = 'postFields';

// 注册评论回调函数，用于渲染评论列表
typecho_Plugin::factory('Widget_Comments_Archive')->threadedComments = 'threadedComments';

/**
 * 获取随机文章
 * 
 * @param int $num 文章数量
 * @return array 文章列表
 */
function getRandomPosts($num = 5) {
    $db = Typecho_Db::get();
    $posts = $db->fetchAll($db->select()->from('table.contents')->where('table.contents.type = ?', 'post')->where('table.contents.status = ?', 'publish')->order('RAND()')->limit($num));
    return $posts;
}

/**
 * 获取热门文章
 * 
 * @param int $num 文章数量
 * @return array 文章列表
 */
function getHotPosts($num = 5) {
    $db = Typecho_Db::get();
    $posts = $db->fetchAll($db->select()->from('table.contents')->where('table.contents.type = ?', 'post')->where('table.contents.status = ?', 'publish')->order('table.contents.commentsNum DESC')->limit($num));
    return $posts;
}

/**
 * 自定义分页链接
 * 
 * @param string $prev 上一页文本
 * @param string $next 下一页文本
 * @param int $splitPage 分页数
 * @param string $splitWord 分割符
 * @param array $options 分页选项
 * @return string 分页HTML
 */
function customPageNav($prev = '上一页', $next = '下一页', $splitPage = 1, $splitWord = '...', $options = array()) {
    $defaultOptions = array(
        'wrapTag' => 'div',
        'wrapClass' => 'page-nav',
        'itemTag' => 'span',
        'textTag' => 'a',
        'currentClass' => 'current',
        'prevClass' => 'prev',
        'nextClass' => 'next'
    );
    
    $options = array_merge($defaultOptions, $options);
    $db = Typecho_Db::get();
    $options = array_merge($defaultOptions, $options);
    
    $this->widget('Widget_Contents_Post_Recent', 'pageSize=' . $this->parameter->pageSize)->to($posts);
    $total = ceil($posts->getTotal() / $this->parameter->pageSize);
    $current = $this->request->get('page') ? $this->request->get('page') : 1;
    
    if ($total <= 1) {
        return '';
    }
    
    $html = '<' . $options['wrapTag'] . ' class="' . $options['wrapClass'] . '">';
    
    // 上一页
    if ($current > 1) {
        $html .= '<' . $options['itemTag'] . ' class="' . $options['prevClass'] . '">';
        $html .= '<' . $options['textTag'] . ' href="' . $this->options->siteUrl . 'page/' . ($current - 1) . '/">' . $prev . '</' . $options['textTag'] . '>';
        $html .= '</' . $options['itemTag'] . '>';
    }
    
    // 页码
    for ($i = 1; $i <= $total; $i++) {
        if ($i == $current) {
            $html .= '<' . $options['itemTag'] . ' class="' . $options['currentClass'] . '">' . $i . '</' . $options['itemTag'] . '>';
        } else {
            $html .= '<' . $options['itemTag'] . '>';
            $html .= '<' . $options['textTag'] . ' href="' . $this->options->siteUrl . 'page/' . $i . '/">' . $i . '</' . $options['textTag'] . '>';
            $html .= '</' . $options['itemTag'] . '>';
        }
    }
    
    // 下一页
    if ($current < $total) {
        $html .= '<' . $options['itemTag'] . ' class="' . $options['nextClass'] . '">';
        $html .= '<' . $options['textTag'] . ' href="' . $this->options->siteUrl . 'page/' . ($current + 1) . '/">' . $next . '</' . $options['textTag'] . '>';
        $html .= '</' . $options['itemTag'] . '>';
    }
    
    $html .= '</' . $options['wrapTag'] . '>';
    
    return $html;
}

//文章缩略图函数
function showThumbnail($widget,$type=0)
{ 
    $random = Helper::options()->themeUrl.'/img/none.jpg';//这里时默认缩略图
    $pattern = '/\<img.*?\ssrc\s*=\s*\"([^"\']+)\"[^>]*>/i';
    $attach = $widget->widget('Widget_Contents_Attachment_Related@' . $widget->cid . '-' . uniqid(), array(
            'parentId'  => $widget->cid,'limit'     => 1,'offset'    => 0))->attachment;
    $t=@preg_match_all($pattern, $widget->markdown($widget->text), $thumbUrl);
    $img=$random;

//兼容thumb文章自定义封面插件
   $name = md5($widget->cid);
   $file1 = ".".__TYPECHO_PLUGIN_DIR__."/Thumb/uploads/".$name.'.webp';
   $file2 = ".".__TYPECHO_PLUGIN_DIR__."/Thumb/uploads/".$name.'.jpg';
   if(file_exists($file1)){
        $img=__TYPECHO_PLUGIN_DIR__."/Thumb/uploads/".$name.'.webp?'.filemtime($file1);
    }
   elseif(file_exists($file2)){
        $img=__TYPECHO_PLUGIN_DIR__."/Thumb/uploads/".$name.'.jpg?'.filemtime($file2);
    }
    
//兼容常见自定义字段设置
elseif($widget->fields->img){$img=$widget->fields->img;}
elseif($widget->fields->thumb){$img=$widget->fields->thumb;}
elseif($widget->fields->thumbnail){$img=$widget->fields->thumbnail;}
    
elseif ($t && strpos($thumbUrl[1][0],'icon.png') == false && strpos($thumbUrl[1][0],'alipay') == false && strpos($thumbUrl[1][0],'wechat') == false) {$img = $thumbUrl[1][0];}//从文章中获取封面
  elseif (@$attach->isImage) {$img=$attach->url;}//从附件中获取封面

  if($type==0){
  if($img==$random){echo $img;}else{echo $img.Helper::options()->thumbnail;}//输出封面图
  }else{
   if($img==$random){return $img;}else{return $img.Helper::options()->thumbnail;}//输出封面图     
  }
  
}