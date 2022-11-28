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
                <h3 id="response" class="widget-title text-left">添加新评论</h3>
                <?php if (!empty($setting['commentNotification'])) : ?>
                    <p class="comment-notification notice"><?php echo $setting['commentNotification']; ?></p>
                <?php endif; ?>
                <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
                    <?php if ($this->user->hasLogin()) : ?>
                        <p id="logged-in" data-name="<?php $this->user->screenName(); ?>" data-url="<?php $this->user->url(); ?>" data-email="<?php $this->user->mail(); ?>"><?php _e('登录身份: '); ?>
                            <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
                            . <a no-pjax href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
                        </p>
                    <?php else : ?>
                        <div class="comment-info-input">
                            <div>
                                <img class="author-avatar" src="<?php local_random_avatar(); ?>">
                                <input aria-label="称呼(必填)" type="text" name="author" id="author" required placeholder="称呼(必填)" value="<?php $this->remember('author'); ?>" />
                                <div class="get-nickname">🎲</div>
                            </div>
                            <input aria-label="电子邮件<?php echo Helper::options()->commentsRequireMail ? '(必填，将保密)' : '(选填)' ?>" type="email" name="mail" id="mail" placeholder="Email<?php echo Helper::options()->commentsRequireMail ? '(必填，用于收到回复通知)' : '(选填)' ?>" <?php echo Helper::options()->commentsRequireMail ? 'required' : '' ?> value="<?php $this->remember('mail'); ?>" />
                            <input aria-label="网站<?php echo Helper::options()->commentsRequireURL ? '(必填)' : '(选填)' ?>" type="url" name="url" id="url" <?php echo Helper::options()->commentsRequireURL ? 'required' : '' ?> placeholder="网站<?php echo Helper::options()->commentsRequireURL ? '(必填)' : '(选填)' ?>" value="<?php $this->remember('url'); ?>" />
                        </div>
                    <?php endif; ?>
                    <p style="margin-top:0">
                        <textarea aria-label="评论输入框" style="resize:none;" class="input-area" rows="5" name="text" id="textarea" placeholder="在这里输入你的评论..." onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('comment-submit-button').click();return false};"><?php $this->remember('text'); ?></textarea>
                    </p>
                    <p class="comment-buttons">
                        <span class="OwO" aria-label="表情按钮" role="button"></span>
                        <?php if (Utils::isPluginAvailable('Comment2Mail') || Utils::isPluginAvailable('Mailer')) :  ?>
                            <span class="comment-mail-me submit btn btn-normal">
                                <input aria-label="有回复时通知我" name="receiveMail" type="checkbox" value="yes" id="receiveMail" checked style="vertical-align: bottom;" />
                                <label for="receiveMail">有回复时通知我</label>
                            </span>
                        <?php endif;  ?>
                        <button id="comment-submit-button" type="submit" class="submit btn btn-normal">提交评论(Ctrl+Enter)</button>
                    </p>
                </form>
            </div>

            <?php if (!$this->user->hasLogin()) : ?>
                <style>
                    div.respond {
                        display: none;
                    }
                </style>
            <?php endif; ?>

            <!--历史评论-->
            <h3 class="comment-separator">
                <div class="comment-tab-current">
                    <div style="margin: 20px auto;width: fit-content;">--------------- <span style="color: white;background-color: black;padding: 0 5px;font-size: .7rem;"><?php $this->commentsNum('开始第一条评论吧~', '已有 1 条评论', '已有 <span class="num">%d</span> 条评论'); ?></span> ---------------</div>
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

    <!-- 自定义css样式 -->
    <style>
        .comment-info-input>div:first-child {
            position: relative;
            flex: 1;
            height: inherit;
        }

        .comment-info-input #author {
            width: 100%;
            padding-right: 3em !important;
        }

        #comments form .comment-info-input input:nth-child(2) {
            margin: 5px 0 !important;
        }
    </style>
    <!-- 评论区 End -->

</main>

<!-- footer -->
<?php
if (!Utils::isPjax()) {
    $this->need('includes/footer.php');
}
?>