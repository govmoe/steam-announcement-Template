<!DOCTYPE html>
<html lang="<?php $this->options->language(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->archiveTitle(array(
        'category'  =>  _t('分类 %s 下的文章'),
        'search'    =>  _t('搜索 %s 的结果'),
        'tag'       =>  _t('标签 %s 下的文章'),
        'author'    =>  _t('%s 发布的文章')
    ), '', ' - '); ?><?php $this->options->title(); ?></title>
    
    <!-- 引入Font Awesome图标 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- 内联样式 -->
    <style>
        /* 公告栏样式 - Steam风格 */
        .announcement-bar {
            background-color: rgba(26, 38, 51, 0.95);
            border: 1px solid rgba(102, 192, 244, 0.3);
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .announcement-item {
            margin: 8px 0;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .announcement-item i {
            color: #66c0f4;
            font-size: 20px;
        }
        
        /* 响应式设计 */
        @media (max-width: 768px) {
            .announcement-bar {
                padding: 12px 16px;
                margin-bottom: 16px;
            }
            
            .announcement-item {
                font-size: 16px;
                gap: 8px;
            }
            
            .announcement-item i {
                font-size: 18px;
            }
        }
        
        @media (max-width: 480px) {
            .announcement-item {
                font-size: 14px;
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }
        }
        /* 全局样式重置 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* 全局变量定义 - Steam风格 */
        :root {
            --primary-color: #0e141b;
            --secondary-color: #1a2633;
            --accent-color: #1b2838;
            --highlight-color: #66c0f4;
            --text-primary: #ffffff;
            --text-secondary: #8f98a0;
            --text-muted: #666d77;
            --border-color: #2a475e;
            --card-bg: #1b2838;
            --hover-bg: #253649;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --sidebar-bg: #171a21;
            --nav-active: #2a475e;
            
            --font-primary: 'Arial', sans-serif;
            --font-size-small: 12px;
            --font-size-normal: 14px;
            --font-size-large: 16px;
            --font-size-xlarge: 20px;
            --font-size-xxlarge: 28px;
            
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 12px;
            --spacing-lg: 16px;
            --spacing-xl: 24px;
            --spacing-xxl: 32px;
            
            --border-radius-sm: 0;
            --border-radius-md: 4px;
            --border-radius-lg: 8px;
            
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
        }

        /* 基础样式 */
        body {
            font-family: var(--font-primary);
            font-size: var(--font-size-normal);
            line-height: 1.5;
            color: var(--text-primary);
            background-color: var(--primary-color);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* 容器样式 */
        .container {
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        /* 链接样式 */
        a {
            color: var(--highlight-color);
            text-decoration: none;
            transition: all var(--transition-fast);
            /* 解决长链接超出UI问题 */
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
            display: inline-block;
        }

        a:hover {
            color: #8ac4f7;
        }

        /* 按钮样式 */
        .btn {
            display: inline-block;
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: var(--font-size-small);
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: all var(--transition-fast);
            background-color: var(--highlight-color);
            color: var(--accent-color);
        }

        .btn:hover {
            background-color: #8ac4f7;
            color: var(--accent-color);
            text-decoration: none;
        }

        /* 按钮样式 - 次要 */
        .btn-secondary {
            background-color: transparent;
            color: var(--highlight-color);
            border: 1px solid var(--highlight-color);
        }

        /* 整体布局 */
        .page-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* 内容容器 */
        .content-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 220px; /* 留出左侧导航宽度 */
        }

        /* 头部样式 - Steam风格 */
        .site-header {
            background-color: var(--accent-color);
            border-bottom: 1px solid var(--border-color);
            padding: var(--spacing-sm) var(--spacing-lg);
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
        }

        .site-branding {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .site-logo {
            font-size: var(--font-size-large);
            color: var(--highlight-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .site-logo img {
            height: 32px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            vertical-align: middle;
        }

        .site-title {
            font-size: var(--font-size-large);
            font-weight: bold;
            margin: 0;
            font-family: 'Arial Black', Arial, sans-serif;
            text-transform: uppercase;
        }

        .site-title a {
            color: var(--text-primary);
            text-decoration: none;
        }

        /* 左侧导航样式 - Steam风格 */
        .main-navigation {
            width: 220px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            padding: var(--spacing-lg) 0;
            position: fixed;
            top: 48px; /* 与顶部栏高度保持一致，避免被覆盖 */
            left: 0;
            height: calc(100vh - 48px); /* 减去顶部栏高度 */
            overflow-y: auto;
            flex-shrink: 0;
            z-index: 999;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: block;
            padding: var(--spacing-sm) var(--spacing-lg);
            color: var(--text-secondary);
            font-size: var(--font-size-normal);
            font-weight: normal;
            text-decoration: none;
            transition: all var(--transition-fast);
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background-color: var(--hover-bg);
            border-left-color: var(--highlight-color);
        }

        .nav-link.active {
            color: var(--text-primary);
            background-color: var(--nav-active);
            border-left-color: var(--highlight-color);
        }

        /* 导航分组标题 */
        .nav-group-title {
            display: block;
            padding: var(--spacing-md) var(--spacing-lg) var(--spacing-xs);
            color: var(--text-muted);
            font-size: var(--font-size-small);
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: rgba(26, 38, 51, 0.5);
        }

        /* 搜索框样式 */
        .header-search {
            position: relative;
            margin-left: auto;
        }

        .search-input {
            padding: var(--spacing-xs) var(--spacing-md);
            padding-right: 32px;
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            font-size: var(--font-size-small);
            width: 200px;
            transition: all var(--transition-fast);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--highlight-color);
            box-shadow: 0 0 0 1px var(--highlight-color);
            width: 250px;
        }

        .search-submit {
            position: absolute;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
            padding: var(--spacing-xs);
            background-color: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color var(--transition-fast);
        }

        .search-submit:hover {
            color: var(--highlight-color);
        }

        /* 主内容区样式 */
        .main-content {
            flex: 1;
            background-color: var(--primary-color);
            padding: var(--spacing-lg);
            overflow-y: auto;
        }

        /* 内容布局 - Steam风格 */
        .content-wrapper {
            display: block;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* 主内容区域 */
        .content-area {
            width: 100%;
        }

        /* 侧边栏样式 - Steam风格 */
        .sidebar {
            display: none;
        }

        /* 公告头部样式 - Steam风格 */
        .announcement-header {
            text-align: left;
            margin-bottom: var(--spacing-xl);
            padding: 0;
            background-color: transparent;
            border: none;
            border-radius: 0;
        }

        .announcement-header h1 {
            font-size: var(--font-size-xxlarge);
            margin-bottom: var(--spacing-sm);
            color: var(--text-primary);
            font-weight: bold;
        }

        .announcement-header p {
            font-size: var(--font-size-normal);
            color: var(--text-secondary);
            margin: 0;
        }

        /* 公告列表样式 - Steam风格 */
        .announcement-list {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-xl);
        }
        
        /* 公告区域链接样式 */
        .announcement-list a {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
            display: inline-block;
        }

        /* 日期分组标题 */
        .date-section-title {
            color: var(--text-muted);
            font-size: var(--font-size-small);
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: var(--spacing-xl) 0 var(--spacing-sm);
            padding: var(--spacing-xs) 0;
            border-bottom: 1px solid var(--border-color);
        }

        /* 公告卡片样式 - Steam风格 */
        .announcement-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            transition: all var(--transition-fast);
            display: flex;
            gap: var(--spacing-lg);
            min-height: 160px;
        }

        .announcement-card:hover {
            background-color: var(--hover-bg);
            border-color: var(--highlight-color);
        }

        /* 公告缩略图 */
        .announcement-thumbnail {
            width: 240px;
            height: 100%;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            background-color: var(--secondary-color);
        }

        .announcement-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-normal);
        }

        .announcement-card:hover .announcement-thumbnail img {
            transform: scale(1.05);
        }

        /* 视频播放图标 */
        .announcement-thumbnail.video::after {
            content: '\f04b';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(14, 20, 27, 0.8);
            color: var(--highlight-color);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 16px;
        }

        /* 公告内容 */
        .announcement-content {
            flex: 1;
            padding: var(--spacing-md);
            display: flex;
            flex-direction: column;
        }

        /* 公告标题 */
        .announcement-title {
            font-size: var(--font-size-large);
            margin: 0 0 var(--spacing-xs) 0;
            line-height: 1.4;
        }

        .announcement-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .announcement-title a:hover {
            color: var(--highlight-color);
        }

        /* 公告摘要 */
        .announcement-excerpt {
            color: var(--text-secondary);
            font-size: var(--font-size-normal);
            line-height: 1.5;
            margin-bottom: var(--spacing-md);
            flex: 1;
        }

        /* 公告元数据 */
        .announcement-meta {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
            font-size: var(--font-size-small);
            color: var(--text-muted);
        }

        .announcement-date {
            color: var(--text-muted);
        }

        /* 互动数据 */
        .announcement-actions {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            margin-left: auto;
        }

        .action-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: var(--text-muted);
            font-size: var(--font-size-small);
        }

        /* 公告按钮组 */
        .announcement-buttons {
            display: flex;
            gap: var(--spacing-sm);
            margin-top: var(--spacing-sm);
        }

        /* 特色公告样式 */
        .featured-announcement {
            background-color: rgba(26, 38, 51, 0.8);
            border: 1px solid var(--highlight-color);
        }

        /* 公告标签 */
        .announcement-tags {
            display: flex;
            gap: var(--spacing-xs);
            margin-top: var(--spacing-xs);
        }

        .announcement-tag {
            padding: 2px var(--spacing-sm);
            background-color: var(--highlight-color);
            color: var(--accent-color);
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* 分页样式 - Steam风格 */
        .pagination {
            margin-top: var(--spacing-xl);
            text-align: center;
            padding: var(--spacing-lg) 0;
        }

        .page-nav {
            display: flex;
            justify-content: center;
            gap: var(--spacing-xs);
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .page-nav span {
            display: inline-block;
        }

        .page-nav a, .page-nav .current {
            display: inline-block;
            padding: var(--spacing-xs) var(--spacing-sm);
            background-color: transparent;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            font-size: var(--font-size-small);
            text-decoration: none;
            transition: all var(--transition-fast);
            min-width: 32px;
            text-align: center;
        }

        .page-nav a:hover {
            background-color: var(--hover-bg);
            border-color: var(--highlight-color);
            text-decoration: none;
        }

        .page-nav .current {
            background-color: var(--highlight-color);
            color: var(--accent-color);
            border-color: var(--highlight-color);
            font-weight: bold;
        }

        /* 页脚样式 - Steam风格 */
        .site-footer {
            background-color: var(--accent-color);
            border-top: 1px solid var(--border-color);
            padding: var(--spacing-lg);
            margin-top: var(--spacing-xl);
            font-size: var(--font-size-small);
            color: var(--text-muted);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: var(--spacing-md);
        }

        .footer-info p {
            margin: var(--spacing-xs) 0;
            color: var(--text-muted);
        }

        /* 社交链接 - Steam风格 */
        .social-links {
            display: flex;
            gap: var(--spacing-sm);
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background-color: transparent;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-muted);
            font-size: var(--font-size-normal);
            transition: all var(--transition-fast);
        }

        .social-link:hover {
            background-color: var(--hover-bg);
            border-color: var(--highlight-color);
            color: var(--highlight-color);
            transform: none;
            text-decoration: none;
        }

        /* 文章页样式 - Steam风格 */
        .single-post {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            overflow: hidden;
        }
        
        /* 文章特色图片 */
        .post-featured-image {
            width: 100%;
            overflow: hidden;
            background-color: var(--secondary-color);
        }
        
        .post-featured-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            max-height: 400px;
            transition: transform var(--transition-normal);
        }
        
        .post-featured-image:hover img {
            transform: scale(1.02);
        }

        .post-header {
            margin-bottom: var(--spacing-xl);
            padding: var(--spacing-lg);
            padding-bottom: var(--spacing-xl);
            border-bottom: 1px solid var(--border-color);
            background-color: rgba(26, 38, 51, 0.5);
        }

        .post-title {
            font-size: var(--font-size-xxlarge);
            margin-bottom: var(--spacing-lg);
            color: var(--text-primary);
            line-height: 1.3;
            padding-left: var(--spacing-lg);
        }

        .post-meta {
            display: flex;
            gap: var(--spacing-lg);
            font-size: var(--font-size-small);
            color: var(--text-muted);
            flex-wrap: wrap;
            padding-left: var(--spacing-lg);
        }

        .post-meta-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }

        .post-content {
            margin-bottom: var(--spacing-xl);
            line-height: 1.8;
            font-size: var(--font-size-large);
            padding: 0 var(--spacing-lg);
        }

        .post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6 {
            margin: var(--spacing-lg) 0 var(--spacing-md) 0;
            color: var(--text-primary);
            font-weight: bold;
        }

        .post-content h1 { font-size: var(--font-size-xxlarge); }
        .post-content h2 { font-size: var(--font-size-xlarge); }
        .post-content h3 { font-size: var(--font-size-large); }

        .post-content p {
            margin-bottom: var(--spacing-md);
        }

        .post-content a {
            color: var(--highlight-color);
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
            display: inline-block;
        }

        .post-content img {
            max-width: 100%;
            height: auto;
            margin: var(--spacing-md) 0;
        }

        .post-content code {
            background-color: var(--secondary-color);
            padding: 2px var(--spacing-sm);
            border-radius: var(--border-radius-sm);
            font-family: 'Courier New', Courier, monospace;
            font-size: var(--font-size-small);
            color: #f0f0f0;
        }

        .post-content pre {
            background-color: var(--secondary-color);
            padding: var(--spacing-md);
            border-radius: var(--border-radius-sm);
            overflow-x: auto;
            margin: var(--spacing-md) 0;
        }

        .post-content pre code {
            background-color: transparent;
            padding: 0;
        }

        .post-content ul, .post-content ol {
            margin: var(--spacing-md) 0;
            padding-left: var(--spacing-xl);
        }

        .post-content li {
            margin-bottom: var(--spacing-xs);
        }
        
        /* 文章页脚 */
        .post-footer {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: var(--spacing-lg);
            margin-top: var(--spacing-xl);
            border-top: 1px solid var(--border-color);
            background-color: rgba(26, 38, 51, 0.5);
        }
        
        .post-tags {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
        }
        
        .post-tags i {
            color: var(--text-muted);
            margin-right: var(--spacing-xs);
        }
        
        .post-tags a {
            display: inline-block;
            padding: 2px var(--spacing-sm);
            background-color: rgba(102, 192, 244, 0.1);
            color: var(--highlight-color);
            border: 1px solid rgba(102, 192, 244, 0.3);
            border-radius: var(--border-radius-sm);
            font-size: var(--font-size-small);
            transition: all var(--transition-fast);
            text-decoration: none;
        }
        
        .post-tags a:hover {
            background-color: rgba(102, 192, 244, 0.2);
            border-color: var(--highlight-color);
            color: var(--text-primary);
        }

        /* 相关文章样式 */
        .related-posts {
            margin-top: var(--spacing-xxl);
            padding: var(--spacing-lg);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
        }
        
        .related-title {
            font-size: var(--font-size-xlarge);
            margin-bottom: var(--spacing-lg);
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .related-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: var(--spacing-lg);
        }
        
        /* 相关文章链接样式 */
        .related-posts a {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
            display: inline-block;
        }
        
        .related-card {
            display: flex;
            flex-direction: column;
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            transition: all var(--transition-fast);
        }
        
        .related-card:hover {
            border-color: var(--highlight-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 192, 244, 0.15);
        }
        
        /* 相关文章缩略图 */
        .related-card-thumbnail {
            width: 100%;
            height: 140px;
            overflow: hidden;
            background-color: var(--primary-color);
        }
        
        .related-card-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-normal);
        }
        
        .related-card:hover .related-card-thumbnail img {
            transform: scale(1.05);
        }
        
        .related-card-content {
            padding: var(--spacing-md);
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .related-post-title {
            font-size: var(--font-size-normal);
            margin: 0 0 var(--spacing-xs);
            line-height: 1.4;
        }
        
        .related-post-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        .related-post-title a:hover {
            color: var(--highlight-color);
        }
        
        .related-post-meta {
            font-size: var(--font-size-small);
            color: var(--text-muted);
            margin-top: auto;
        }
        
        /* 评论区样式 - Steam风格 */
        .comments-section {
            margin-top: var(--spacing-xxl);
            padding-top: var(--spacing-xl);
            border-top: 1px solid var(--border-color);
        }

        .comments-title {
            font-size: var(--font-size-xlarge);
            margin-bottom: var(--spacing-lg);
            color: var(--text-primary);
        }
        
        /* 评论区链接样式 */
        .comments-section a {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
            display: inline-block;
        }

        /* 评论列表样式 */
        .comments-list, .comment-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .comment {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            transition: all var(--transition-fast);
        }

        .comment:hover {
            border-color: var(--highlight-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 192, 244, 0.15);
        }

        /* 评论者头像 */
        .comment-author-avatar {
            float: left;
            margin-right: var(--spacing-lg);
        }

        .comment-author-avatar img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
        }

        /* 评论内容 */
        .comment-content {
            overflow: hidden;
        }

        /* 评论元信息 */
        .comment-meta {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-sm);
        }

        .comment-author, .comment-author-name {
            color: var(--highlight-color);
            font-weight: bold;
            font-size: var(--font-size-normal);
        }

        .comment-date {
            color: var(--text-muted);
            font-size: var(--font-size-small);
        }

        .comment-reply {
            margin-left: auto;
        }

        .comment-reply a {
            color: var(--highlight-color);
            font-size: var(--font-size-small);
            text-decoration: none;
            transition: all var(--transition-fast);
        }

        .comment-reply a:hover {
            color: #8ac4f7;
        }

        /* 评论正文 */
        .comment-text {
            color: var(--text-primary);
            font-size: var(--font-size-normal);
            line-height: 1.6;
            margin: var(--spacing-md) 0 0 0;
        }

        /* 评论子列表 */
        .comment-children {
            margin-left: var(--spacing-xl);
            margin-top: var(--spacing-lg);
        }

        /* 评论表单样式 */
        .comments-form, #respond {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: var(--spacing-lg);
            margin-top: var(--spacing-xl);
        }

        .comments-form h3, #respond h3 {
            color: var(--text-primary);
            font-size: var(--font-size-large);
            margin-bottom: var(--spacing-lg);
        }

        .form-group {
            margin-bottom: var(--spacing-lg);
        }

        .form-group label, .comment-form label {
            display: block;
            color: var(--text-primary);
            font-size: var(--font-size-normal);
            margin-bottom: var(--spacing-xs);
        }

        .form-control, .comment-form input[type="text"], .comment-form input[type="email"], .comment-form input[type="url"], .comment-form textarea {
            width: 100%;
            padding: var(--spacing-sm) var(--spacing-md);
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            font-size: var(--font-size-normal);
            transition: all var(--transition-fast);
        }

        .form-control:focus, .comment-form input[type="text"]:focus, .comment-form input[type="email"]:focus, .comment-form input[type="url"]:focus, .comment-form textarea:focus {
            outline: none;
            border-color: var(--highlight-color);
            box-shadow: 0 0 0 1px var(--highlight-color);
        }

        textarea.form-control, .comment-form textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-submit, .comment-form .submit {
            text-align: right;
        }

        .submit-btn, .comment-form .submit input[type="submit"] {
            padding: var(--spacing-sm) var(--spacing-xl);
            background-color: var(--highlight-color);
            border: none;
            border-radius: var(--border-radius-sm);
            color: var(--accent-color);
            font-size: var(--font-size-normal);
            font-weight: bold;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .submit-btn:hover, .comment-form .submit input[type="submit"]:hover {
            background-color: #8ac4f7;
        }

        /* 无评论状态 */
        .no-comment, .no-comments {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: var(--spacing-lg);
            text-align: center;
        }

        .no-comment p, .no-comments p {
            color: var(--text-secondary);
            margin: 0;
        }

        /* 评论分页 */
        .comments-pagination {
            text-align: center;
            margin: var(--spacing-xl) 0;
        }

        .comment-nav {
            display: inline-flex;
            gap: var(--spacing-sm);
        }

        .comment-nav a {
            padding: var(--spacing-xs) var(--spacing-md);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            text-decoration: none;
            transition: all var(--transition-fast);
        }

        .comment-nav a:hover {
            border-color: var(--highlight-color);
            background-color: var(--hover-bg);
        }

        /* 分类页样式 - Steam风格 */
        
        /* 分类页头部 */
        .category-header {
            margin-bottom: var(--spacing-xl);
            padding: var(--spacing-xl);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            text-align: center;
        }
        
        .category-title {
            font-size: var(--font-size-xxlarge);
            margin-bottom: var(--spacing-md);
            color: var(--text-primary);
            font-weight: bold;
        }
        
        .category-info {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
            align-items: center;
        }
        
        .category-description {
            color: var(--text-secondary);
            font-size: var(--font-size-normal);
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .category-count {
            font-size: var(--font-size-normal);
            color: var(--text-muted);
            margin: 0;
        }
        
        .category-count strong {
            color: var(--highlight-color);
            font-weight: bold;
        }
        
        /* 分类文章列表 */
        .category-posts {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-xl);
        }
        
        /* 分类文章卡片 */
        .category-post-card {
            display: flex;
            gap: var(--spacing-lg);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            transition: all var(--transition-fast);
        }
        
        .category-post-card:hover {
            background-color: var(--hover-bg);
            border-color: var(--highlight-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 192, 244, 0.15);
        }
        
        /* 分类文章缩略图 */
        .category-post-thumbnail {
            width: 200px;
            height: 100%;
            flex-shrink: 0;
            overflow: hidden;
            background-color: var(--secondary-color);
        }
        
        .category-post-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-normal);
        }
        
        .category-post-card:hover .category-post-thumbnail img {
            transform: scale(1.05);
        }
        
        /* 分类文章内容 */
        .category-post-content {
            flex: 1;
            padding: var(--spacing-lg);
            display: flex;
            flex-direction: column;
        }
        
        /* 分类文章标题 */
        .category-post-title {
            font-size: var(--font-size-large);
            margin: 0 0 var(--spacing-sm);
            line-height: 1.4;
        }
        
        .category-post-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        .category-post-title a:hover {
            color: var(--highlight-color);
        }
        
        /* 分类文章摘要 */
        .category-post-excerpt {
            color: var(--text-secondary);
            font-size: var(--font-size-normal);
            line-height: 1.6;
            margin: var(--spacing-sm) 0;
            flex: 1;
        }
        
        /* 分类文章元数据 */
        .category-post-meta {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
            font-size: var(--font-size-small);
            color: var(--text-muted);
            flex-wrap: wrap;
        }
        
        .category-post-meta span {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }
        
        .category-post-meta i {
            color: var(--text-muted);
        }
        
        /* 分类文章标签 */
        .category-post-tags {
            display: flex;
            gap: var(--spacing-xs);
            margin-top: var(--spacing-sm);
            flex-wrap: wrap;
        }
        
        .category-post-tags a {
            display: inline-block;
            padding: 2px var(--spacing-sm);
            background-color: rgba(102, 192, 244, 0.1);
            color: var(--highlight-color);
            border: 1px solid rgba(102, 192, 244, 0.3);
            border-radius: var(--border-radius-sm);
            font-size: var(--font-size-small);
            transition: all var(--transition-fast);
            text-decoration: none;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
        }
        
        .category-post-tags a:hover {
            background-color: rgba(102, 192, 244, 0.2);
            border-color: var(--highlight-color);
            color: var(--text-primary);
        }
        
        /* 无分类文章状态 */
        .no-category-posts {
            text-align: center;
            padding: var(--spacing-xxl);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            margin: var(--spacing-xl) 0;
        }
        
        .no-posts-icon {
            font-size: 48px;
            color: var(--text-muted);
            margin-bottom: var(--spacing-lg);
        }
        
        .no-category-posts h3 {
            font-size: var(--font-size-xlarge);
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
        }
        
        .no-category-posts p {
            color: var(--text-secondary);
            margin-bottom: var(--spacing-xl);
        }
        
        /* 搜索和归档页面通用样式 - Steam风格 */
        
        /* 搜索/归档页头部 */
        .search-header {
            margin-bottom: var(--spacing-xl);
            padding-bottom: var(--spacing-lg);
            border-bottom: 1px solid var(--border-color);
        }
        
        .search-title {
            font-size: var(--font-size-xxlarge);
            margin-bottom: var(--spacing-sm);
            color: var(--text-primary);
            font-weight: bold;
        }
        
        /* 搜索信息区域 */
        .search-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--spacing-lg);
            margin-top: var(--spacing-sm);
            flex-wrap: wrap;
        }
        
        .search-results-count {
            font-size: var(--font-size-normal);
            color: var(--text-secondary);
            margin: 0;
        }
        
        .search-results-count strong {
            color: var(--highlight-color);
            font-weight: bold;
        }
        
        /* 搜索结果排序 */
        .search-refine {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .refine-label {
            font-size: var(--font-size-small);
            color: var(--text-muted);
        }
        
        .refine-select {
            padding: var(--spacing-xs) var(--spacing-md);
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            font-size: var(--font-size-small);
            cursor: pointer;
            transition: all var(--transition-fast);
        }
        
        .refine-select:hover {
            border-color: var(--highlight-color);
        }
        
        .refine-select:focus {
            outline: none;
            border-color: var(--highlight-color);
            box-shadow: 0 0 0 1px var(--highlight-color);
        }
        
        /* 搜索结果列表 */
        .search-results {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-xl);
        }
        
        /* 搜索结果卡片 */
        .search-result-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: var(--spacing-lg);
            transition: all var(--transition-fast);
        }
        
        .search-result-card:hover {
            background-color: var(--hover-bg);
            border-color: var(--highlight-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 192, 244, 0.15);
        }
        
        /* 搜索结果内容 */
        .search-result-content {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }
        
        /* 搜索结果标题 */
        .search-result-title {
            font-size: var(--font-size-large);
            margin: 0 0 var(--spacing-xs);
            line-height: 1.4;
        }
        
        .search-result-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        .search-result-title a:hover {
            color: var(--highlight-color);
        }
        
        /* 搜索结果摘要 */
        .search-result-excerpt {
            color: var(--text-secondary);
            font-size: var(--font-size-normal);
            line-height: 1.6;
            margin: var(--spacing-sm) 0;
        }
        
        /* 搜索结果元数据 */
        .search-result-meta {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
            font-size: var(--font-size-small);
            color: var(--text-muted);
            flex-wrap: wrap;
        }
        
        .search-result-meta span {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }
        
        .search-result-meta i {
            color: var(--text-muted);
        }
        
        /* 搜索结果标签 */
        .search-result-tags {
            display: flex;
            gap: var(--spacing-xs);
            margin-top: var(--spacing-xs);
            flex-wrap: wrap;
        }
        
        .search-result-tags a {
            display: inline-block;
            padding: 2px var(--spacing-sm);
            background-color: rgba(102, 192, 244, 0.1);
            color: var(--highlight-color);
            border: 1px solid rgba(102, 192, 244, 0.3);
            border-radius: var(--border-radius-sm);
            font-size: var(--font-size-small);
            transition: all var(--transition-fast);
            text-decoration: none;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
        }
        
        .search-result-tags a:hover {
            background-color: rgba(102, 192, 244, 0.2);
            border-color: var(--highlight-color);
            color: var(--text-primary);
        }
        
        /* 无搜索结果状态 */
        .no-search-results {
            text-align: center;
            padding: var(--spacing-xxl);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            margin: var(--spacing-xl) 0;
        }
        
        .no-results-icon {
            font-size: 48px;
            color: var(--text-muted);
            margin-bottom: var(--spacing-lg);
        }
        
        .no-search-results h3 {
            font-size: var(--font-size-xlarge);
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
        }
        
        .no-search-results p {
            color: var(--text-secondary);
            margin-bottom: var(--spacing-xl);
        }
        
        /* 搜索建议 */
        .search-suggestions {
            text-align: left;
            max-width: 400px;
            margin: 0 auto;
            padding: var(--spacing-lg);
            background-color: rgba(26, 38, 51, 0.5);
            border-radius: var(--border-radius-sm);
        }
        
        .search-suggestions h4 {
            font-size: var(--font-size-normal);
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .search-suggestions ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .search-suggestions li {
            padding: var(--spacing-xs) 0;
            color: var(--text-secondary);
            font-size: var(--font-size-normal);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .search-suggestions li:before {
            content: "•";
            color: var(--highlight-color);
            font-weight: bold;
        }
        
        /* 404页面样式 - Steam风格 */
        .error-404 {
            text-align: center;
            padding: var(--spacing-xxl) var(--spacing-lg);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: var(--highlight-color);
            margin-bottom: var(--spacing-lg);
            opacity: 0.8;
        }
        
        .error-title {
            font-size: var(--font-size-xxlarge);
            margin-bottom: var(--spacing-md);
            color: var(--text-primary);
        }
        
        .error-description {
            font-size: var(--font-size-large);
            color: var(--text-secondary);
            margin-bottom: var(--spacing-xl);
            line-height: 1.6;
        }
        
        .error-actions {
            display: flex;
            gap: var(--spacing-md);
            justify-content: center;
            margin-bottom: var(--spacing-xl);
            flex-wrap: wrap;
        }
        
        .error-search {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .error-search h3 {
            font-size: var(--font-size-large);
            margin-bottom: var(--spacing-md);
            color: var(--text-primary);
        }
        
        .error-search .search-input {
            width: 100%;
        }

        /* 响应式设计 */
        @media (max-width: 1200px) {
            .container {
                max-width: 100%;
                padding: 0 var(--spacing-lg);
            }
        }

        @media (max-width: 992px) {
            /* 在平板设备上隐藏左侧导航，改为顶部菜单 */
            .main-navigation {
                display: none;
                top: 0; /* 重置顶部位置 */
                height: 100vh; /* 重置高度 */
            }
            
            /* 重置内容容器margin */
            .content-container {
                margin-left: 0;
            }
            
            /* 调整搜索框宽度 */
            .search-input {
                width: 150px;
            }
            
            .search-input:focus {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            /* 在移动设备上调整布局 */
            .site-title {
                font-size: var(--font-size-large);
            }
            
            .announcement-header h1 {
                font-size: var(--font-size-xlarge);
            }
            
            /* 文章页响应式调整 */
            .post-title {
                font-size: var(--font-size-xlarge);
                padding-left: var(--spacing-md);
                text-align: center;
            }
            
            .post-meta {
                padding-left: var(--spacing-md);
                justify-content: center;
                text-align: center;
            }
            
            .post-content {
                padding: 0 var(--spacing-md);
                font-size: var(--font-size-normal);
            }
            
            /* 分类页响应式调整 */
            .category-title {
                font-size: var(--font-size-xlarge);
            }
            
            .category-header {
                padding: var(--spacing-lg);
            }
            
            .category-post-card {
                flex-direction: column;
            }
            
            .category-post-thumbnail {
                width: 100%;
                height: 200px;
            }
            
            /* 搜索页面响应式调整 */
            .search-title {
                font-size: var(--font-size-xlarge);
            }
            
            .search-info {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-sm);
            }
            
            .search-refine {
                width: 100%;
            }
            
            .refine-select {
                width: 100%;
            }
            
            /* 搜索结果卡片平板适配 */
            .search-result-card {
                padding: var(--spacing-md);
            }
            
            .search-result-meta {
                flex-wrap: wrap;
            }
            
            /* 相关文章平板适配 */
            .related-list {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: var(--spacing-md);
            }
            
            /* 新闻卡片改为垂直布局 */
            .announcement-card {
                flex-direction: column;
                min-height: auto;
            }
            
            /* 调整缩略图大小 */
            .announcement-thumbnail {
                width: 100%;
                height: 200px;
            }
            
            .announcement-thumbnail img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                aspect-ratio: 16/9;
            }
            
            /* 调整页脚布局 */
            .footer-content {
                flex-direction: column;
                gap: var(--spacing-lg);
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            /* 在小屏手机上进一步调整 */
            .container {
                padding: 0 var(--spacing-sm);
            }
            
            .main-content {
                padding: var(--spacing-md);
            }
            
            .site-title {
                font-size: var(--font-size-normal);
            }
            
            .announcement-header {
                padding: var(--spacing-lg) var(--spacing-md);
            }
            
            .announcement-content {
                padding: var(--spacing-md);
            }
            
            /* 文章页小屏手机调整 */
            .post-title {
                font-size: var(--font-size-large);
                padding-left: var(--spacing-sm);
                margin-bottom: var(--spacing-md);
            }
            
            .post-meta {
                padding-left: var(--spacing-sm);
                flex-direction: column;
                gap: var(--spacing-xs);
                align-items: center;
            }
            
            .post-content {
                padding: 0 var(--spacing-sm);
            }
            
            /* 分类页小屏手机调整 */
            .category-title {
                font-size: var(--font-size-large);
            }
            
            .category-description {
                font-size: var(--font-size-normal);
            }
            
            .category-post-content {
                padding: var(--spacing-md);
            }
            
            .category-post-title {
                font-size: var(--font-size-large);
            }
            
            .category-post-meta {
                flex-direction: column;
                gap: var(--spacing-xs);
                align-items: flex-start;
            }
            
            /* 调整新闻卡片间距 */
            .announcement-list {
                gap: var(--spacing-md);
            }
            
            /* 调整元数据布局 */
            .announcement-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-xs);
            }
            
            .announcement-actions {
                margin-left: 0;
                margin-top: var(--spacing-xs);
            }
            
            /* 搜索结果卡片移动端适配 */
            .search-result-card {
                padding: var(--spacing-md);
            }
            
            .search-result-title {
                font-size: var(--font-size-large);
            }
            
            .search-result-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-xs);
            }
            
            .search-result-meta span {
                margin-bottom: var(--spacing-xs);
            }
            
            /* 相关文章移动端适配 */
            .related-list {
                grid-template-columns: 1fr;
                gap: var(--spacing-md);
            }
            
            .related-card-thumbnail {
                height: 160px;
            }
            
            /* 标签页移动端适配 */
            .search-header {
                padding-bottom: var(--spacing-md);
            }
            
            .search-title {
                font-size: var(--font-size-large);
            }
            
            /* 404页面移动端适配 */
            .error-404 {
                padding: var(--spacing-xl) var(--spacing-md);
            }
            
            .error-code {
                font-size: 5rem;
            }
            
            .error-title {
                font-size: var(--font-size-xlarge);
            }
            
            .error-description {
                font-size: var(--font-size-normal);
            }
            
            .error-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .error-actions .btn {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
    
    <!-- 引入Typecho自带的jQuery -->
    <?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw=&rss1=&rss2=&atom='); ?>
</head>
<body>
    <header class="site-header">
        <div class="header-content">
            <div class="site-branding">
                <a href="<?php $this->options->siteUrl(); ?>" class="site-logo">
                    <?php if ($this->options->logoUrl): ?>
                        <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title(); ?>" style="height: 32px; vertical-align: middle;">
                    <?php else: ?>
                        <i class="fab fa-steam"></i>
                    <?php endif; ?>
                </a>
                <h1 class="site-title">
                    <a href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title(); ?>"><?php $this->options->title(); ?></a>
                </h1>
            </div>
            
            <!-- 移除重复导航，使用左侧导航菜单 -->
            
            <div class="header-search">
                <form method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                    <input type="text" name="s" placeholder="搜索文章..." class="search-input">
                    <button type="submit" class="search-submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </header>
