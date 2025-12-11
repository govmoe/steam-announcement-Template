<?php
/**
 * 测试评论功能
 * 
 * @package SteamAnnouncement
 */

// 简单的测试页面，用于验证评论功能

echo '<h1>评论测试页面</h1>';
echo '<p>这是一个用于测试评论功能的页面。</p>';

// 显示评论表单
echo '<h2>发表评论</h2>';

// 简单的HTML表单，用于测试评论提交
echo '<form method="post" action="' . $this->commentUrl() . '" id="test-comment-form">';
echo '<div>';
echo '<label for="test-author">昵称:</label>';
echo '<input type="text" name="author" id="test-author" required>';
echo '</div>';
echo '<div>';
echo '<label for="test-mail">邮箱:</label>';
echo '<input type="email" name="mail" id="test-mail" required>';
echo '</div>';
echo '<div>';
echo '<label for="test-url">网站:</label>';
echo '<input type="url" name="url" id="test-url">';
echo '</div>';
echo '<div>';
echo '<label for="test-text">评论内容:</label>';
echo '<textarea name="text" id="test-text" required></textarea>';
echo '</div>';
echo '<div>';
echo '<input type="hidden" name="_" value="' . $this->security->getToken() . '">';
echo '<input type="submit" value="发表评论">';
echo '</div>';
echo '</form>';

// 显示当前评论
echo '<h2>现有评论</h2>';
$this->comments()->to($comments);
if ($comments->have()) {
    echo '<ul id="test-comments">';
    while ($comments->next()) {
        echo '<li>';
        echo '<strong>' . $comments->author . '</strong> 于 ' . $comments->date('Y-m-d H:i') . ' 说:';
        echo '<div>' . $comments->content . '</div>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>暂无评论</p>';
}