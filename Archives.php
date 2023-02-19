<?php

/** 
 * Archives
 *
 * @package custom
 *  
 * @author      熊猫小A Modified By Yacan
 * @version     2022-11-28 0.1
 * 
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$setting = $GLOBALS['VOIDSetting'];

if (!Utils::isPjax()) {
    $this->need('includes/head.php');
    $this->need('includes/header.php');
}
?>

<main id="pjax-container" class="post">
    <title hidden>
        <?php Contents::title($this); ?>
    </title>

    <?php $this->need('includes/ldjson.php'); ?>
    <?php $this->need('includes/banner.php'); ?>

    <div class="wrapper container narrow articleBody">
        <!-- PHP输出网站统计汇总 -->
        <div class="yue float-up">
            <h2>🧮️ 网站统计</h2>
            <p>内容统计：</p>
            <table>
                <thead>
                    <tr>
                        <th align="center">分类</th>
                        <th align="center">标签</th>
                        <th align="center">文章</th>
                        <th align="center">字数</th>
                        <th align="center">阅读</th>
                        <th align="center">评论</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center">
                            <?php echo Utils::getCatNum(); ?>
                        </td>
                        <td align="center">
                            <?php echo Utils::getTagNum(); ?>
                        </td>
                        <td align="center">
                            <?php echo Utils::getPostNum(); ?>
                        </td>
                        <td align="center" <?php if ($setting['VOIDPlugin'])
                                                echo 'id="totalWordCount"'; ?>></td>
                        <td align="center">
                            <?php echo get_sum_view_num(); ?>
                        </td>
                        <td align="center">
                            <?php echo get_user_level(); ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- 运行时间 -->
            <p>本站已运行：</p>
            <div id="countdown-box">
                <span class="day">00</span> <strong>:</strong>
                <span class="hour">00</span> <strong>:</strong>
                <span class="minute">00</span> <strong>:</strong>
                <span class="second">00</span>
            </div>
        </div>

        <!--PHP输出热门文章-->
        <div class="popular-articles yue float-up">
            <h2>🗒️ 热门文章排行</h2>
            <ol>
                <?php getHotComments(); ?>
            </ol>
        </div>

        <!-- 输出标签云 -->
        <div class="tag-cloud yue float-up">
            <h2>📂 标签</h2>
            <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=10000')->to($tags); ?>
            <?php if ($tags->have()) : ?>
                <?php while ($tags->next()) : ?>
                    <a href="<?php $tags->permalink(); ?>" rel="tag" class="tag-item" title="<?php $tags->count(); ?> 个话题" style="background-color:#<?php echo substr(md5(rand()), 0, 6); ?>">
                        <?php $tags->name(); ?><small>
                            <?php $tags->count(); ?>
                        </small>
                    </a>
                <?php endwhile; ?>
            <?php else : ?>
                <?php echo ('还没有标签哦～'); ?>
            <?php endif; ?>
        </div>
        <section id="archive-list" class="yue float-up">
            <h2>⏲️ 时光真是一把杀猪刀~</h2>
            <?php $archives = Contents::archives($this);
            $index = 0;
            foreach ($archives as $year => $posts) : ?>
                <h3>
                    <?php echo $year; ?>
                    <span class="num-posts">
                        <?php $post_num = count($posts);
                        echo $post_num; ?> 篇
                    </span>
                    <a no-pjax target="_self" data-num="<?php echo $post_num; ?>" data-year="<?php echo $year; ?>" class="toggle-archive" href="javascript:void(0);" onclick="VOID_Ui.toggleArchive(this); return false;">
                        <?php if ($index > 0)
                            echo '+';
                        else
                            echo '-'; ?>
                    </a>
                </h3>
                <section id="year-<?php echo $year; ?>" class="year<?php if ($index > 0)
                                                                        echo ' shrink'; ?>" style="max-height: <?php if ($index > 0)
                                                                                                                    echo '0';
                                                                                                                else
                                                                                                                    echo $post_num * 49; ?>px; transition-duration: <?php echo $post_num * 0.03 > 0.8 ? 0.8 : $post_num * 0.03; ?>s">
                    <ul>
                        <?php foreach ($posts as $created => $post) : ?>
                            <li>
                                <a class="archive-title<?php if ($setting['VOIDPlugin'])
                                                            echo ' show-word-count'; ?>" data-words="<?php if ($setting['VOIDPlugin'])
                                                                                                            echo $post['words']; ?>" href="<?php echo $post['permalink']; ?>">
                                    <span class="date">
                                        <?php echo date('m-d', $created); ?>
                                    </span>
                                    <?php echo $post['title']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php $index = $index + 1;
            endforeach; ?>
        </section>
    </div>

    <!-- 自定义代码必须放在PJax刷新区域 -->
    <script>
        //博客运行时间
        var countdown_box = document.querySelector("#countdown-box");
        var day = countdown_box.querySelector(".day");
        var hour = countdown_box.querySelector(".hour");
        var minute = countdown_box.querySelector(".minute");
        var second = countdown_box.querySelector(".second");
        var inputTime = +new Date("2017-07-02 16:54:00");

        countDown();
        setInterval(countDown, 1000);

        function countDown() {
            var nowTime = +new Date();
            var times = (nowTime - inputTime) / 1000;
            if (times > 0) {
                var d = parseInt(times / 60 / 60 / 24);
                day.innerHTML = d < 10 ? "0" + d : d;
                var h = parseInt(times / 60 / 60 % 24);
                hour.innerHTML = h < 10 ? "0" + h : h;
                var m = parseInt(times / 60 % 60);
                minute.innerHTML = m < 10 ? "0" + m : m;
                var s = parseInt(times % 60);
                second.innerHTML = s < 10 ? "0" + s : s;
            }
        }
    </script>
</main>

<?php
if (!Utils::isPjax()) {
    $this->need('includes/footer.php');
}
?>