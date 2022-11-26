<?php

/**
 * comments.php
 * 
 * 评论区
 * 
 * @author      熊猫小A
 * @version     2019-01-15 0.1
 */
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

    .comment-info-input .get-nickname {
        cursor: pointer;
        position: absolute;
        font-size: 180%;
        transform: translateY(-50%);
        right: .2em;
        top: 50%;
    }

    .shake {
        animation-name: shake;
        animation-duration: .1s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        display: inherit;
        transform-origin: center;
    }

    @keyframes shake {
        2% {
            transform: translate(-1.5px, calc(-50% + .5px)) rotate(1.5deg);
        }

        4% {
            transform: translate(2.5px, calc(-50% + .5px)) rotate(-.5deg);
        }

        6% {
            transform: translate(1.5px, calc(-50% + 1.5px)) rotate(1.5deg);
        }

        8% {
            transform: translate(1.5px, calc(-50% + .5px)) rotate(1.5deg);
        }

        10% {
            transform: translate(-.5px, calc(-50% - .5px)) rotate(.5deg);
        }

        12% {
            transform: translate(-1.5px, calc(-50% - 1.5px)) rotate(-.5deg);
        }

        14% {
            transform: translate(2.5px, calc(-50% + 1.5px)) rotate(1.5deg);
        }

        16% {
            transform: translate(-.5px, calc(-50% - .5px)) rotate(1.5deg);
        }

        18% {
            transform: translate(-1.5px, calc(-50% - .5px)) rotate(.5deg);
        }

        20% {
            transform: translate(-.5px, calc(-50% + 1.5px)) rotate(.5deg);
        }

        22% {
            transform: translate(2.5px, calc(-50% + 2.5px)) rotate(1.5deg);
        }

        24% {
            transform: translate(-.5px, calc(-50% + 1.5px)) rotate(-.5deg);
        }

        26% {
            transform: translate(.5px, calc(-50% - .5px)) rotate(.5deg);
        }

        28% {
            transform: translate(1.5px, calc(-50% + .5px)) rotate(.5deg);
        }

        30% {
            transform: translate(1.5px, calc(-50% + 2.5px)) rotate(1.5deg);
        }

        32% {
            transform: translate(-1.5px, calc(-50% - .5px)) rotate(.5deg);
        }

        34% {
            transform: translate(.5px, calc(-50% + 1.5px)) rotate(.5deg);
        }

        36% {
            transform: translate(-1.5px, calc(-50% + .5px)) rotate(-.5deg);
        }

        38% {
            transform: translate(1.5px, calc(-50% - .5px)) rotate(-.5deg);
        }

        40% {
            transform: translate(2.5px, calc(-50% - .5px)) rotate(.5deg);
        }

        42% {
            transform: translate(2.5px, calc(-50% + 1.5px)) rotate(1.5deg);
        }

        44% {
            transform: translate(.5px, calc(-50% + 1.5px)) rotate(1.5deg);
        }

        46% {
            transform: translate(.5px, calc(-50% + 1.5px)) rotate(.5deg);
        }

        48% {
            transform: translate(-1.5px, calc(-50% - 1.5px)) rotate(-.5deg);
        }

        50% {
            transform: translate(-.5px, calc(-50% - .5px)) rotate(-.5deg);
        }

        52% {
            transform: translate(-1.5px, calc(-50% - .5px)) rotate(-.5deg);
        }

        54% {
            transform: translate(1.5px, calc(-50% + 1.5px)) rotate(.5deg);
        }

        56% {
            transform: translate(.5px, calc(-50% - 1.5px)) rotate(-.5deg);
        }

        58% {
            transform: translate(-.5px, calc(-50% - 2.5px)) rotate(1.5deg);
        }

        60% {
            transform: translate(2.5px, calc(-50% + 1.5px)) rotate(-.5deg);
        }

        62% {
            transform: translate(2.5px, calc(-50% - 1.5px)) rotate(-.5deg);
        }

        64% {
            transform: translate(-.5px, calc(-50% - 2.5px)) rotate(1.5deg);
        }

        66% {
            transform: translate(1.5px, calc(-50% - .5px)) rotate(1.5deg);
        }

        68% {
            transform: translate(.5px, calc(-50% - 1.5px)) rotate(1.5deg);
        }

        70% {
            transform: translate(.5px, calc(-50% - .5px)) rotate(1.5deg);
        }

        72% {
            transform: translate(2.5px, calc(-50% - .5px)) rotate(.5deg);
        }

        74% {
            transform: translate(-.5px, calc(-50% + 2.5px)) rotate(1.5deg);
        }

        76% {
            transform: translate(1.5px, calc(-50% - .5px)) rotate(.5deg);
        }

        78% {
            transform: translate(2.5px, calc(-50% - .5px)) rotate(1.5deg);
        }

        80% {
            transform: translate(1.5px, calc(-50% + 2.5px)) rotate(-.5deg);
        }

        82% {
            transform: translate(-1.5px, calc(-50% + .5px)) rotate(-.5deg);
        }

        84% {
            transform: translate(.5px, calc(-50% - .5px)) rotate(-.5deg);
        }

        86% {
            transform: translate(-1.5px, calc(-50% + .5px)) rotate(.5deg);
        }

        88% {
            transform: translate(2.5px, calc(-50% + .5px)) rotate(.5deg);
        }

        90% {
            transform: translate(1.5px, calc(-50% + 2.5px)) rotate(.5deg);
        }

        92% {
            transform: translate(-1.5px, calc(-50% + 1.5px)) rotate(-.5deg);
        }

        94% {
            transform: translate(-.5px, calc(-50% + 2.5px)) rotate(1.5deg);
        }

        96% {
            transform: translate(1.5px, calc(-50% + .5px)) rotate(.5deg);
        }

        98% {
            transform: translate(1.5px, calc(-50% - .5px)) rotate(-.5deg);
        }

        0%,
        100% {
            transform: translate(0, -50%) rotate(0);
        }
    }
</style>

<!-- 自定义Javascript -->
<script>
    // 随机昵称实现
    var nick_name_switch = null,
        name_first = ["大名鼎鼎", "躲闪", "骄傲", "挺胸", "不知名", "知名", "刚下飞机", "看透一切", "小有名气", "潜心学习", "十里八乡有名", "刚下班", "饱受社会毒打", "已经秃头", "正在被压榨"],
        name_second = ["大黄", "匿名人士", "高质量男性", "女士", "人士", "男孩", "女孩", "贫僧", "道士", "学生", "打工人", "路人甲", "炮灰已", "流氓丙", "土匪丁", "龙套戊", "社畜", "俊后生", "牛马", "旺财", "大学僧", "研究僧", "博士僧"];
    $(".get-nickname").on("click", function() {
        const this_name = $(this);
        $(this).removeClass("shake"),
        $(this).addClass("shake"),
        null != nick_name_switch && (clearTimeout(nick_name_switch), nick_name_switch = null),
        nick_name_switch = setTimeout(function() {
            this_name.removeClass("shake")
        }, 500),
        _tmp = name_first[Math.floor(Math.random() * name_first.length)] + "的" + name_second[Math.floor(Math.random() * name_second.length)],
        $(this).prev().val(_tmp)
    })
    // placehold变化
    $("#textarea").focus(function() {
        $(this).attr("placeholder", "说点什么吧~")
    });

    $("#textarea").blur(function() {
        $(this).attr("placeholder", "居然什么也不说，哼~")
    });
</script>