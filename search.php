<?php
/**
 * 搜索页模板 - Steam公告风格
 * 
 * @package SteamAnnouncement
 */

// 获取搜索关键词，直接从$_GET获取，最可靠
$searchTerm = '';
if (isset($_GET['s'])) {
    $searchTerm = trim((string)$_GET['s']);
}

// 确保Typecho的request对象能正确获取到搜索关键词
// 这对于header.php中的archiveTitle函数至关重要
if (isset($this)) {
    $this->request->s = $searchTerm;
}

// 转义用于安全输出
$safeSearchTerm = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');

// 引入header，此时标题会正确显示搜索关键词
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
            
            // 输出配置的菜单项
            foreach ($menuItems as $item) {
                $isActive = false;
                $isGroupTitle = ($item['url'] == '#');
                
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
            
            // 显示Typecho页面
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
                <!-- 搜索结果头部 -->
                <div class="search-header">
                    <h1 class="search-title">搜索结果: <?php echo htmlspecialchars(trim((string)$_GET['s']), ENT_QUOTES, 'UTF-8'); ?></h1>
                </div>
                
                <!-- 搜索结果列表 -->
                <div class="search-results">
                    <?php if ($this->have()): ?>
                        <?php while($this->next()): ?>
                            <article class="search-result-card">
                                <h2 class="search-result-title">
                                    <a href="<?php $this->permalink(); ?>" title="<?php $this->title(); ?>"><?php $this->title(); ?></a>
                                </h2>
                                <div class="search-result-excerpt">
                                    <?php $this->excerpt(200, '...'); ?>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- 无结果状态 -->
                        <div class="no-search-results">
                            <h3>未找到相关结果</h3>
                            <p>抱歉，没有找到与 "<?php echo htmlspecialchars(trim((string)$_GET['s']), ENT_QUOTES, 'UTF-8'); ?>" 相关的文章。</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php $this->need('footer.php'); ?>