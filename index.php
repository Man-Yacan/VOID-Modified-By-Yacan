<?php

/**
 * VOID：无类型
 * 
 * 作者：<a href="https://www.imalan.cn">熊猫小A</a>
 * 
 * @package     Typecho-Theme-VOID
 * @author      熊猫小A
 * @version     3.5.0
 * @link        https://blog.imalan.cn/archives/247/
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$setting = $GLOBALS['VOIDSetting'];

if (!Utils::isPjax()) {
    $this->need('includes/head.php');
    $this->need('includes/header.php');
}
?>

<main id="pjax-container">
    <title hidden>
        <?php Contents::title($this); ?>
    </title>

    <?php $this->need('includes/ldjson.php'); ?>
    <?php $this->need('includes/banner.php'); ?>

    <div class="wrapper container <?php if ($setting['indexStyle'] == 1)
                                        echo 'narrow';
                                    else
                                        echo 'wide'; ?>">

        <!-- 输出矫情 Start -->
        <?php if ($this->currentPage == 1 || $this->_currentPage == 1) : ?>
            <?php $this->widget('Widget_Comments_Recent', 'pageSize=1&parentId=1734')->to($comments); ?>
            <!--pageSiz获取的评论条数，parentId=cid；&ignoreAuthor=true忽略文章作者评论-->
            <a id="whisper" class="title" href="<?php $comments->permalink(); ?>">
                <div>
                    <div>
                        矫情一下<i class="voidicon-music"></i>
                        <small style="font-size: 55%">
                            <?php $comments->dateWord(); ?>
                        </small>
                    </div>
                </div>
                <div>
                    <?php $comments->excerpt(50, '...'); ?>
                </div>
            </a>
        <?php endif; ?>
        <!-- 输出矫情 End -->

        <section id="index-list" class="float-up">
            <ul id="masonry">
                <?php while ($this->next()) : ?>
                    <?php $bannerAsCover = $this->fields->bannerascover;
                    if ($this->fields->banner == '')
                        $bannerAsCover = '0'; ?>
                    <li id="p-<?php $this->cid(); ?>" class="masonry-item style-<?php
                                                                                if ($this->fields->showfullcontent == '1') {
                                                                                    if ($bannerAsCover == '2')
                                                                                        echo '1';
                                                                                    echo ' full-content';
                                                                                } else {
                                                                                    echo $bannerAsCover;
                                                                                }
                                                                                ?>">

                        <!-- 输出置顶代码 -->
                        <?php $this->sticky(); ?>

                        <?php if ($this->fields->showfullcontent != '1') : ?>
                            <a href="<?php $this->permalink(); ?>">
                            <?php endif; ?>
                            <article class="yue">
                                <?php if ($this->fields->banner != '') : ?>
                                    <?php if ($this->fields->showfullcontent == '1') : ?>
                                        <a href="<?php $this->permalink(); ?>">
                                        <?php endif; ?>
                                        <div class="banner">
                                            <?php if (Helper::options()->lazyload == '1') : ?>
                                                <?php if ($setting['bluredLazyload']) : ?>
                                                    <img src="<?php echo Contents::genBluredPlaceholderSrc($this->fields->banner); ?>" class="blured-placeholder">
                                                <?php endif; ?>
                                                <img class="lazyload" data-src="<?php echo $this->fields->banner; ?>">
                                            <?php else : ?>
                                                <img src="<?php echo $this->fields->banner; ?>">
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($this->fields->showfullcontent == '1') : ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="content-wrap">
                                    <?php if ($this->fields->showfullcontent == '1') : ?>
                                        <a href="<?php $this->permalink(); ?>">
                                        <?php endif; ?>
                                        <h1 class="title">
                                            <?php $this->title(); ?>
                                        </h1>
                                        <?php if ($this->fields->showfullcontent == '1') : ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($this->fields->excerpt != '')
                                        echo "<p class=\"headline content\">{$this->fields->excerpt}</p>"; ?>

                                    <div class="articleBody">
                                        <?php if ($this->fields->showfullcontent != '1') : ?>
                                            <?php if ($this->fields->excerpt == '') : ?>
                                                <p>
                                                    <?php if (Utils::isMobile())
                                                        $this->excerpt(60);
                                                    else
                                                        $this->excerpt(80); ?>
                                                </p>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php $this->content(); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="post-meta-index">
                                        <time datetime="<?php echo date('c', $this->created); ?>">
                                            <?php echo date('M d, Y', $this->created); ?>
                                        </time>
                                        <?php if ($setting['VOIDPlugin']) : ?>
                                            <span class="word-count">&nbsp;•&nbsp;
                                                <?php echo $this->wordCount; ?> 字
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($setting['VOIDPlugin'])
                                            echo '&nbsp;•&nbsp;' . $this->viewsNum . '&nbsp;阅读</span>&nbsp;•&nbsp;'; ?>
                                        <?php $tags = Contents::getTags($this->cid);
                                        if (count($tags) > 0) {
                                            foreach ($tags as $tag) {
                                                echo '#' . $tag['name'] . '&nbsp;';
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </article>
                            <?php if ($this->fields->showfullcontent != '1') : ?>
                            </a>
                        <?php endif; ?>
                    </li>
                    <script>
                        VOID_Ui.MasonryCtrler.watch("p-<?php $this->cid(); ?>");
                    </script>
                <?php endwhile; ?>
            </ul>
        </section>
        <?php $this->pageNav('<span aria-label="上一页">←</span>', '<span aria-label="下一页">→</span>', 1, '...', 'wrapClass=pager&prevClass=prev&nextClass=next'); ?>
    </div>
</main>

<?php
if (!Utils::isPjax()) {
    $this->need('includes/footer.php');
}
?>