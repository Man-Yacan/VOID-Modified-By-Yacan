<?php

/**
 * main.php
 * 
 * 内容页面主要区域，PJAX 作用区域
 * 
 * @author      熊猫小A
 * @version     2019-01-15 0.1
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$setting = $GLOBALS['VOIDSetting'];
?>

<main id="pjax-container">
    <title hidden>
        <?php Contents::title($this); ?>
    </title>

    <?php $this->need('includes/ldjson.php'); ?>
    <?php $this->need('includes/banner.php'); ?>

    <div class="wrapper container">
        <div class="contents-wrap">
            <!--start .contents-wrap-->
            <section id="post" class="float-up">
                <article class="post yue">

                    <!-- 文章最前面显示文章摘要 -->
                    <p <?php if ($this->fields->excerpt == '' || !$setting['showHeadlineInPost']) echo 'hidden' ?> class="headline" itemprop="headline"><?php if ($this->fields->excerpt != '') echo $this->fields->excerpt;
                                                                                                                                                    else $this->excerpt(30); ?></p>
                    <?php $postCheck = Utils::isOutdated($this);
                    if ($postCheck["is"] && $this->is('post')) : ?>
                        <p class="notice">请注意，本文编写于 <?php echo $postCheck["created"]; ?> 天前，最后修改于 <?php echo $postCheck["updated"]; ?> 天前，其中某些信息可能已经过时。</p>
                    <?php endif; ?>

                    <div class="articleBody" class="full">
                        <?php $this->content(); ?>
                    </div>
                    <!-- 仅在文章页面输出版权信息和分享链接，固定页面不输出 -->
                    <?php if ($this->is('post')) : ?>
                        <!--输出文章版权-->
                        <div style="margin: 20px auto;width: fit-content;">----- <span style="color: white;background-color: black;padding: 0 5px;font-size: .7rem;">END</span> -----</div>
                        <p class="notice" style="text-indent:0em">
                            本文作者：<a href="<?php $this->author->permalink(); ?>" rel="author"> <?php $this->author(); ?></a><br>
                            本文链接：<a href="<?php $this->permalink(); ?>"><?php $this->permalink(); ?></a><br>
                            版权声明：本文章采用<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><i>&nbsp;<strong>知识共享署名-非商业性使用-相同方式共享 4.0 国际许可协议&nbsp;</strong></i></a>。
                        </p>
                        <section class="tag-and-reward">
                            <?php $tags = Contents::getTags($this->cid);
                            if (count($tags) > 0) {
                                echo '<div class="tags">';
                                foreach ($tags as $tag) {
                                    echo '<a href="' . $tag['permalink'] . '" rel="tag" class="tag-item">' . $tag['name'] . '</a>';
                                }
                                echo '</div>';
                            } ?>
                            <div class="social-button" data-url="<?php $this->permalink(); ?>" data-title="<?php Contents::title($this); ?>" data-excerpt="<?php $this->fields->excerpt(); ?>" data-img="<?php $this->fields->banner(); ?>" data-twitter="<?php if ($setting['twitterId'] != '') echo $setting['twitterId'];
                                                                                                                                                                                                                                                            else $this->author(); ?>" data-weibo="<?php if ($setting['weiboId'] != '') echo $setting['weiboId'];
                                                                                                                                                                                                                                                                                                    else $this->author(); ?>" <?php if ($this->fields->banner != '') echo 'data-image="' . $this->fields->banner . '"'; ?>>
                                <?php if (!empty($setting['reward'])) : ?>
                                    <a data-fancybox="gallery-reward" role=button aria-label="赞赏" data-src="#reward" href="javascript:;" class="btn btn-normal btn-highlight">赏杯咖啡</a>
                                    <div hidden id="reward"><img src="<?php echo $setting['reward']; ?>"></div>
                                <?php endif; ?>
                                <?php if ($setting['VOIDPlugin']) : ?>
                                    <a role=button aria-label="为文章点赞" id="social" href="javascript:void(0);" onclick="VOID_Vote.vote(this);" data-item-id="<?php echo $this->cid; ?>" data-type="up" data-table="content" class="btn btn-normal post-like vote-button">赞一个 <span class="value"><?php echo $this->likes; ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </article>

                <script>
                    (function() {
                        $.each($('iframe'), function(i, item) {
                            var src = $(item).attr('src');
                            if (typeof src === 'string' && src.indexOf('player.bilibili.com') > -1) {
                                // $(item).addClass('bili-player');
                                if (src.indexOf('&high_quality') < 0) {
                                    src += '&high_quality=1'; // 启用高质量
                                    $(item).attr('src', src);
                                }
                                $(item).wrap('<div class="bili-player"></div>');
                            }
                        });
                    })();

                    $(document).ready(function() {
                        // 代码框一键复制按钮
                        $('pre').prepend('<div class="copyDiv">🖱️Copy</div>');

                        function copyHandle(content) {
                            let copy = (e) => {
                                e.preventDefault()
                                e.clipboardData.setData('text/plain', content)
                                document.removeEventListener('copy', copy)
                            }
                            document.addEventListener('copy', copy)
                            document.execCommand("Copy");
                        }
                        $('.copyDiv').click(function() {
                            copyHandle($(this).next().text());
                        })
                    })
                </script>

                <!-- 一键复制按钮样式 -->
                <style>
                    .copyDiv {
                        position: absolute;
                        top: 6px;
                        right: 10px;
                        color: white;
                        z-index: 100;
                        border: 1px solid #05F56B;
                        text-align: center;
                        cursor: pointer;
                        background-color: #85C1E9;
                        border-radius: 3px;
                        line-height: 18px
                    }
                </style>

                <!--分页-->
                <?php if (!$this->is('page')) : ?>
                    <div class="post-pager"><?php $prev = Contents::thePrev($this);
                                            $next = Contents::theNext($this); ?>
                        <div class="prev">
                            <?php if ($prev) : ?>
                                <a href="<?php $prev->permalink(); ?>">
                                    <h2><?php $prev->title(); ?></h2>
                                </a>
                                <!-- 如果有摘要就输出摘要，没有摘要输出一段文字 -->
                                <?php
                                if ($prev->fields->excerpt != '') {
                                    echo "<p>{$prev->fields->excerpt}</p>";
                                } else {
                                    // 移动端少输出一点字
                                    if (Utils::isMobile())
                                        $prev->excerpt(60);
                                    else
                                        $prev->excerpt(80);
                                }
                                ?>
                            <?php else : ?>
                                <h2>考古结束~</h2>
                            <?php endif; ?>
                        </div>
                        <div class="next">
                            <?php if ($next) : ?>
                                <a href="<?php $next->permalink(); ?>">
                                    <h2><?php $next->title(); ?></h2>
                                </a>
                                <?php /* echo $next->fields->excerpt != '' ? "<p>{$next->fields->excerpt}</p>" : ''; */ ?>
                                <?php
                                if ($next->fields->excerpt != '') {
                                    echo "<p>{$next->fields->excerpt}</p>";
                                } else {
                                    // 移动端少输出一点字
                                    if (Utils::isMobile())
                                        $next->excerpt(60);
                                    else
                                        $next->excerpt(80);
                                }
                                ?>
                            <?php else : ?>
                                <h2>鸽了鸽了~</h2>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        <!--end .contents-wrap-->
        <!--目录，可选-->
        <?php if ($this->fields->showTOC == '1') : ?>
            <div class="toc-mask" onclick="TOC.close();"></div>
            <div aria-label="文章目录" class="TOC"></div>
            <style>
                #toggle-toc {
                    display: block;
                }
            </style>
        <?php endif; ?>
    </div>

    <!--评论区，可选-->
    <!-- 只有当允许评论的时候才输出评论区 -->
    <?php if ($this->allow('comment')) : ?>
        <?php $this->need('includes/comments.php'); ?>
    <?php endif; ?>
</main>