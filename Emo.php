<?php

/** 
 * Emo
 *
 * @package custom
 *  
 * @author      Man Yacan
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
    <!-- 输出Banner -->
    <?php $this->need('includes/banner.php'); ?>

    <!-- 个人信息card Start -->
    <style>
        .card {
            position: relative;
            width: 350px;
            height: 190px;
            background: #333;
            transition: 0.5s;
            margin: 5rem auto 3rem;
        }

        .card:hover {
            height: 450px;
        }

        .card .lines {
            position: absolute;
            inset: 0;
            background: #000;
            overflow: hidden;
        }

        .card .lines::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 600px;
            height: 120px;
            background: linear-gradient(transparent, #45f3ff, #45f3ff, #45f3ff, transparent);
            animation: animate 4s linear infinite;
        }

        @keyframes animate {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .card .lines::after {
            content: '';
            position: absolute;
            /* https://developer.mozilla.org/en-US/docs/Web/CSS/inset */
            inset: 3px;
            background: #292929;
        }

        .card:hover .imgBx {
            width: 250px;
            height: 250px;
        }

        .card .imgBx {
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 150px;
            background: #000;
            transition: 0.5s;
            z-index: 1;
            overflow: hidden;
        }

        .card .imgBx::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 500px;
            height: 150px;
            transform: translate(-50%, -50%);
            background: linear-gradient(transparent, #ff3c7b, #ff3c7b, #ff3c7b, transparent);
            animation: animate2 6s linear infinite;
        }

        @keyframes animate2 {
            0% {
                transform: translate(-50%, -50%) rotate(360deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(0deg);
            }
        }

        .card .imgBx::after {
            content: '';
            position: absolute;
            inset: 3px;
            background: #292929;
        }

        .card .imgBx img {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1;
            width: calc(100% - 20px);
            height: calc(100% - 20px);
            /* filter: grayscale(1); */
        }

        .card .content {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            overflow: hidden;
        }

        .card .content .details {
            padding: 40px;
            text-align: center;
            width: 100%;
            transition: 0.5s;
            transform: translateY(140px);
        }

        .card:hover .content .details {
            transform: translateY(0px);
        }

        .card .content .details h2 {
            font-size: 1.25em;
            font-weight: 600;
            color: #45f3ff;
            line-height: 1.2em;
            border-bottom: unset;
        }

        .card .content .details h2::before {
            content: '';
        }

        .card .content .details h2 span {
            font-size: 0.75em;
            font-weight: 500;
            opacity: 0.5;
            color: #fff;
        }

        .card .content .details .data {
            display: flex;
            justify-content: space-between;
            margin: 20px 0 !important;
        }

        .card .content .details .data h3 {
            font-size: 1em;
            color: #45f3ff;
            line-height: 1.2em;
            font-weight: 600;
            margin: unset
        }

        .card .content .details .data h3 span {
            font-size: 0.85em;
            font-weight: 400;
            opacity: 0.5;
            color: #fff;
        }

        .card .content .details .actionBtn {
            display: flex;
            justify-content: space-between;
        }

        .card .content .details .actionBtn a {
            padding: 10px 30px;
            border-radius: 5px;
            border: none;
            outline: none;
            font-size: 1em;
            font-weight: 500;
            background: #45f3ff;
            color: #222;
            cursor: pointer;
            opacity: 0.9;
        }

        .card .content .details .actionBtn a::after {
            content: unset;
        }

        .card .content .details .actionBtn a:nth-child(2) {
            /* border: 1px solid #999; */
            /* color: #999; */
            background: #fff;
        }

        .card .content .details .actionBtn a:hover {
            opacity: 1;
        }
    </style>

    <div class="card">
        <div class="lines"></div>
        <div class="imgBx">
            <img src="https://image.manyacan.com/202211280901328.png#vwid=256&vhei=256" alt="">
        </div>
        <div class="content">
            <div class="details">
                <h2>曼亚灿<br><span>每天都在祈求平安毕业~</span></h2>
                <div class="data">
                    <h3><?php echo Utils::getPostNum(); ?><br><span>文章</span></h3>
                    <h3><?php echo get_sum_view_num(); ?><br><span>阅读</span></h3>
                    <h3><?php echo get_user_level(); ?><br><span>评论</span></h3>
                </div>
                <div class="actionBtn">
                    <a href="https://blog.manyacan.com/readme.html">关于</a>
                    <a href="http://wpa.qq.com/msgrd?v=3&uin=931941244&site=qq&menu=yes">QQ</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 个人信息card End -->


    <div class="wrapper container">
        <!-- 输出页面 Markdown -->
        <?php $this->content(); ?>
        <!-- 输出页面 Markdown End -->
    </div>

    <!-- 评论区 -->
    <?php
    if (!defined('__TYPECHO_ROOT_DIR__')) exit;
    $setting = $GLOBALS['VOIDSetting'];
    $parameter = array(
        'parentId'      => $this->hidden ? 0 : $this->cid,
        'parentContent' => $this->row,
        'respondId'     => $this->respondId,
        'commentPage'   => $this->request->filter('int')->commentPage,
        'allowComment'  => $this->allow('comment')
    );
    $this->widget('VOID_Widget_Comments_Archive', $parameter)->to($comments);
    ?>

    <div class="comments-container float-up">
        <section id="comments" class="container">
            <!--评论框-->
            <?php $this->header('commentReply=1&description=0&keywords=0&generator=0&template=0&pingback=0&xmlrpc=0&wlw=0&rss2=0&rss1=0&antiSpam=0&atom'); ?>
            <div id="<?php $this->respondId(); ?>" class="respond">
                <div class="cancel-comment-reply" role=button>
                    <?php $comments->cancelReply(); ?>
                </div>
                <h3 id="response" class="widget-title text-left">发表个说说吧~☺️🙂😆😄🤠</h3>
                <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
                    <p style="margin-top:0">
                        <textarea aria-label="评论输入框" style="resize:none;" class="input-area" rows="5" name="text" id="textarea" placeholder="在这里输入你的说说..." onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('comment-submit-button').click();return false};"><?php $this->remember('text'); ?></textarea>
                    </p>
                    <p class="comment-buttons">
                        <span class="OwO" aria-label="表情按钮" role="button"></span>
                        <button id="comment-submit-button" type="submit" class="submit btn btn-normal">提交评论(Ctrl+Enter)</button>
                    </p>
                </form>
            </div>

            <!-- 如果没登陆，那么就把评论框隐藏，禁止非博主在这个页面评论 -->
            <?php if (!$this->user->hasLogin()) : ?>
                <style>
                    .respond {
                        display: none
                    }

                    .comment-reply {
                        display: none
                    }
                </style>
            <?php endif; ?>

            <style>
                .user-logo.webmaster {
                    display: none
                }
            </style>

            <!--历史评论-->
            <h3 class="comment-separator">
                <div class="comment-tab-current">
                    <div style="margin: 20px auto;width: fit-content;">--------------- <span style="color: white;background-color: black;padding: 0 5px;font-size: .7rem;"><?php $this->commentsNum('开始第一条说说吧~', '已有 1 条说说', '已经矫情了 <span class="num">%d</span> 次🤪'); ?></span> ---------------</div>
                </div>
            </h3>
            <?php if ($comments->have()) : ?>
                <?php $comments->listComments(array(
                    'before'        =>  '<div class="comment-list">',
                    'after'         =>  '</div>',
                    'avatarSize'    =>  64,
                    'dateFormat'    =>  'Y-m-d H:i'
                )); ?>
                <?php $comments->pageNav('<span aria-label="评论上一页">←</span>', '<span aria-label="评论下一页">→</span>', 1, '...', 'wrapClass=pager&prevClass=prev&nextClass=next'); ?>
            <?php endif; ?>
        </section>
    </div>
    <!-- 评论区 End -->

</main>

<!-- footer -->
<?php
if (!Utils::isPjax()) {
    $this->need('includes/footer.php');
}
?>