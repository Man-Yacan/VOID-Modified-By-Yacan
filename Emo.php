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

    <?php
    $this->need('includes/ldjson.php');
    $this->need('includes/banner.php');
    ?>

    <!-- 那年今日 -->

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
                        <button id="comment-submit-button" type="submit" class="submit btn btn-normal">
                            提交评论(Ctrl+Enter)
                        </button>
                    </p>
                </form>
            </div>

            <!-- 如果没登陆，那么就把评论框隐藏，禁止非博主在这个页面评论 -->
            <?php if (!$this->user->hasLogin()) : ?>
                <style>
                    .respond,
                    .comment-reply,
                    .comment-avatar.star {
                        display: none !important
                    }

                    .comment-meta {
                        margin-left: unset !important
                    }

                    .comment-content.yue {
                        max-width: 100% !important;
                        margin-left: unset !important
                    }
                </style>
            <?php endif; ?>

            <style>
                /* ----------------------------------------------- 自定义Emo页面评论列表 Start ----------------------------------------------- */
                .user-logo.webmaster {
                    display: none
                }

                .comment-list-diy:has(+ .pager) {
                    border: 1px solid #ccc;
                }

                .comment-list-diy:has(+ .pager) img.biaoqing {
                    display: inline-block;
                    height: 2em;
                    vertical-align: bottom;
                    margin: 0;
                    -webkit-box-shadow: none;
                    box-shadow: none;
                }

                /* 嵌套评论 */
                .comment-children:has(.comment-list-diy) {
                    padding-left: 20px;
                }

                /* ----------------------------------------------- 自定义Emo页面评论列表 Start ----------------------------------------------- */


                /* ----------------------------------------------- 评论按钮 Start ----------------------------------------------- */
                button#comment-submit-button {
                    position: absolute !important;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }

                button#comment-submit-button:hover {
                    background-image: linear-gradient(to right, rgb(250, 82, 82), rgb(250, 82, 82) 16.65%, rgb(190, 75, 219) 16.65%, rgb(190, 75, 219) 33.3%, rgb(76, 110, 245) 33.3%, rgb(76, 110, 245) 49.95%, rgb(64, 192, 87) 49.95%, rgb(64, 192, 87) 66.6%, rgb(250, 176, 5) 66.6%, rgb(250, 176, 5) 83.25%, rgb(253, 126, 20) 83.25%, rgb(253, 126, 20) 100%, rgb(250, 82, 82) 100%) !important;
                    animation: 2s linear dance6123 infinite;
                    transform: scale(1.1) translate(-50%, -50%);
                }

                @keyframes dance6123 {
                    to {
                        background-position: 150px;
                    }
                }

                /* ----------------------------------------------- 评论按钮 End ----------------------------------------------- */
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