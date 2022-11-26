<?php

/** 
 * Archives
 *
 * @package custom
 *  
 * @author      熊猫小A
 * @version     2019-01-17 0.1
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

            <!-- 最后离开位置与时间 -->
            <?php $this->widget('Widget_Comments_Recent', 'pageSize=1')->to($comments); ?>
            <p>最后位置：</p>
            <p style="text-align: center">
                <i class="voidicon-location"></i>
                <?php echo convertip($comments->ip); ?>
            </p>
            <p>最后来过：</p>
            <p style="text-align: center">
                <i class="voidicon-cw"></i>
                <?php echo get_last_update(); ?>
            </p>
        </div>
        <!-- 博客大事记 - 开始 -->
        <div class="yue float-up" id="blog-event">
            <h2>🎞 博客大事记</h2>
            <ol>
                <li>
                    <span>2022年09月10日（中秋节、教师节）</span><br>
                    <span>网站被黑，重装服务器并增强了网站前后端防护机制，<a href="https://blog.manyacan.com/archives/1961/">中秋节网站重新上线</a>。</span>
                </li>
                <li>
                    <span>2020年09月</span><br>
                    <span>开始读研，博客进入稳定期，记录生活，分享知识。</span>
                </li>
                <li>
                    <span>2020年04月20日</span><br>
                    <span>网站服务器变更为杭州阿里云，<a href="https://manyacan.com">manyacan.com</a>第二次通过河南管局备案。</span>
                </li>
                <li>
                    <span>2019年03月</span><br>
                    <span>开始准备考研，博客进入荒废期。</span>
                </li>
                <li>
                    <span>2018年12月22日</span><br>
                    <span><a href="https://blog.manyacan.com/archives/904/">SolidWorks_ 2018_SP5.0_完整集成版
                            安装</a>本站第一篇阅读过万、阅读过百的文章。</span>
                </li>
                <li>
                    <span>2018年07月11日</span><br>
                    <span><a href="https://manyacan.com">manyacan.com</a>首次通过河南管局备案。</span>
                </li>
                <li>
                    <span>2017年12月27日</span><br>
                    <span>购买个人拼音域名<a href="https://manyacan.com">manyacan.com</a>。</span>
                </li>
                <li>
                    <span>2017年09月</span><br>
                    <span>建立第一个网站，基于WordPress程序、腾讯云服务器，域名：reboy.club（已弃用）。</span>
                </li>
                <li>
                    <span>2017年07月</span><br>
                    <span>暑假无聊，开始在<a href="https://www.w3school.com.cn/">W3C</a>学习Web，使用Microsoft Surface Pro
                        4敲出了人生第一个Hello world.</span>
                </li>
            </ol>
        </div>

        <!--PHP输出热门文章-->
        <div class="popular-articles yue float-up">
            <h2>🗒️ 热门文章排行</h2>
            <ol>
                <?php getHotComments('20'); ?>
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
    <!-- 自定义css -->
    <style>
        /* 博客运行时间 */
        #countdown-box {
            width: fit-content;
            margin: 10px auto;
        }
    
        #countdown-box>span {
            /* 转化span模式，使span能设置宽高 */
            display: inline-block;
            width: 3em;
            height: 3em;
            background-color: #333;
            color: #fff;
            font-weight: 900;
            /* 使方块中文字居中 */
            text-align: center;
            line-height: 3em;
        }
    
        #countdown-box strong {
            font-size: 150%;
            font-weight: 600;
        }
    
        /* 博客大事记 */
        #blog-event ol {
            display: block;
            border-left: 5px double #ccc;
            list-style: none;
            margin: unset;
        }
    
        #blog-event li {
            border-bottom: 1px solid;
        }
    
        #blog-event li>span:first-child {
            font-size: 80%;
        }
    
        /* 热门文章排行 */
        .popular-articles ol>li:first-child {
            color: #FE2D46;
        }
    
        .popular-articles ol>li:nth-of-type(2) {
            color: #F60;
        }
    
        .popular-articles ol>li:nth-of-type(3) {
            color: #FAA90E;
        }
    
        .popular-articles ol>li.hot i::after {
            content: '热';
            color: #fafafa;
            position: absolute;
            background-color: #F60;
            display: inline-block;
            border-radius: 5px;
            padding: 0 3px;
            right: -1.7em;
            transform: translateY(-50%);
            top: 50%;
            font-style: normal;
            font-size: 80%;
        }
    
        .popular-articles ol>li.hot i {
            position: relative;
        }
    
        /* 标签云 */
        .tag-cloud>a {
            border-radius: 5px;
            padding: 1px 5px;
            margin-right: 1px !important;
        }
    
        .tag-cloud>a::after {
            content: '' !important;
        }
    
        /* 时光杀猪刀 */
        #archive-list a::after {
            content: '';
        }
    </style>
    
    <!-- 自定义JS -->
    <script>
        // 博客运行时间
        //获取元素
        var countdown_box = document.querySelector("#countdown-box");
        var day = countdown_box.querySelector(".day");
        var hour = countdown_box.querySelector(".hour");
        var minute = countdown_box.querySelector(".minute");
        var second = countdown_box.querySelector(".second");
        //获取截止时间的时间戳（单位毫秒）
        var inputTime = +new Date("2017-07-02 16:54:00");
    
        //我们先调用countDown函数，可以避免在打开界面后停一秒后才开始倒计时
        countDown();
        //定时器 每隔一秒变化一次
        setInterval(countDown, 1000);
    
        function countDown() {
            //获取当前时间的时间戳（单位毫秒）
            var nowTime = +new Date();
            //把剩余时间毫秒数转化为秒
            var times = (nowTime - inputTime) / 1000;
            if (times > 0) {
                //计算天 转化为整数
                var d = parseInt(times / 60 / 60 / 24);
                day.innerHTML = d < 10 ? "0" + d : d;
                //计算小时数 转化为整数
                var h = parseInt(times / 60 / 60 % 24);
                //如果小时数小于 10，要变成 0 + 数字的形式 赋值给盒子
                hour.innerHTML = h < 10 ? "0" + h : h;
                //计算分钟数 转化为整数
                var m = parseInt(times / 60 % 60);
                //如果分钟数小于 10，要变成 0 + 数字的形式 赋值给盒子
                minute.innerHTML = m < 10 ? "0" + m : m;
                //计算描述 转化为整数
                var s = parseInt(times % 60);
                //如果秒钟数小于 10，要变成 0 + 数字的形式 赋值给盒子
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