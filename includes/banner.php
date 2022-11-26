<?php

/** 
 * banner.php
 *  
 * @author      熊猫小A
 * @version     2019-01-17 0.1
 * 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$setting = $GLOBALS['VOIDSetting'];
$banner = $setting['defaultBanner'];
$blur = false;

if ($this->is('post') || $this->is('page')) {
    $banner = $this->fields->bannerStyle < 2 ? $this->fields->banner : '';
    $blur = $this->fields->bannerStyle == 1;
}
?>

<div class="lazy-wrap
    <?php
    if (empty($banner)) echo ' no-banner';
    else echo ' loading dark';
    if ($this->is('index')) echo ' index';
    if ($this->is('archive') && !$this->have()) echo ' not-found'; ?>">
    <!-- 不管头图地址有没有填写都输出，没有填写的话img的src为空，利用下面JS为其添加 -->
    <div id="banner" class="<?php if ($blur) echo 'blur'; ?>">
        <?php if ($setting['bluredLazyload']) : ?>
            <img src="<?php echo Contents::genBluredPlaceholderSrc($banner); ?>" class="blured-placeholder remove-after">
        <?php endif; ?>
        <img class="lazyload" data-src="<?php echo $banner; ?>">
    </div>

    <!-- 如果banner图为空 -->
    <?php if (empty($banner)) : ?>
        <?php if ($this->is('index')) : ?>
            <!-- 首页banner图为空：没有填写随机图API或者固定头图地址时，产生一个随机图地址并伴随一条图片信息 -->
            <span id="img-info"></span>
            <style>
                .lazy-wrap>#img-info {
                    position: absolute;
                    right: .2rem;
                    bottom: .4rem;
                    color: white;
                    font-size: 70%;
                    display: none;
                    background: rgba(0, 0, 0, .37);
                    backdrop-filter: blur(3px);
                    padding: .1rem .2rem;
                }
            </style>
            <script>
                var imgInfo = {
                    12: '歼20就问你帅不帅！🤠',
                    14: '安徽理工大学脑瘫小分队~😆',
                    15: 'NOKIA我曾经也爱过你的！🥹',
                    16: '淮南——成就了AUST，然后又毁她。🏫',
                    17: '淮南废弃游乐场摩天轮-1🎡',
                    18: '淮南废弃游乐场摩天轮-2🎡',
                    19: 'AUST西门~🎓'
                },
                    imgNum = 1 + ~~(Math.random() * 19);
                // var imgNum = 14 + ~~(Math.random() * 6);  // 测试用
                if (imgInfo.hasOwnProperty(imgNum)) { // 判断是否需要输出信息
                    let span_ele = $('.lazy-wrap>#img-info');
                    span_ele.text('© ' + imgInfo[imgNum]);
                    span_ele.css('display', 'inline-block')
                }
                var imgUrl = 'https://cdn.manyacan.com/background/' + imgNum + '.webp';
                $('#banner').find('img:nth-of-type(1)').attr('src', imgUrl);
                $('#banner').find('img:nth-of-type(2)').attr('data-src', imgUrl);
                $('body>header').removeClass('force-dark').removeClass('no-banner');
            </script>
        <?php else : ?>
            <!-- 文章（post与独立页面）banner图为空 -->
            <!-- 如果文章页（包括独立页面和post页面没有banner图）  -->
            <script>
                $('body>header').addClass('force-dark').addClass('no-banner');
            </script>
            <style>
                main>.lazy-wrap {
                    min-height: 0;
                }
            </style>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!$this->is('index')) : ?>
        <div class="banner-title">
            <h1 class="post-title">
                <?php if (!$this->is('archive')) : ?>
                    <?php $this->title(); ?>
                <?php else : ?>
                    <?php if ($this->have()) : ?>
                        <?php $this->archiveTitle(array(
                            'category'  =>  _t('分类 "%s" 下的文章'),
                            'search'    =>  _t('包含关键字 "%s" 的文章'),
                            'tag'       =>  _t('包含标签 "%s" 的文章'),
                            'author'    =>  _t('"%s" 发布的文章')
                        ), '', '');  ?>
                    <?php else : ?>
                        <!-- 404页面 -->
                        <span class="glitch">0</span>
                    <?php endif; ?>
                <?php endif; ?>
            </h1>
            <?php if (!$this->is('archive')) : ?>
                <p class="post-meta">
                    <?php if ($this->template == 'Archives.php') {
                        echo '-';
                    } else { ?>
                        <span><a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></span>&nbsp;•&nbsp;
                        <time datetime="<?php echo date('c', $this->created); ?>"><?php echo date('Y-m-d', $this->created); ?></time>
                        &nbsp;•&nbsp;<a no-pjax target="_self" href="javascript:void(0);" onclick="VOID_SmoothScroller.scrollTo('#comments', -60)"><?php $this->commentsNum(); ?>&nbsp;评论</a>
                        <?php if ($setting['VOIDPlugin']) echo '&nbsp;•&nbsp;<span>' . $this->viewsNum . '&nbsp;阅读</span>'; ?>
                        <?php if ($this->user->hasLogin()) : ?>
                            <?php if ($this->is('post')) : ?>
                                &nbsp;•&nbsp;<a target="_blank" href="<?php echo $this->options->adminUrl . 'write-post.php?cid=' . $this->cid; ?>">编辑</a>
                            <?php else : ?>
                                &nbsp;•&nbsp;<a target="_blank" href="<?php echo $this->options->adminUrl . 'write-page.php?cid=' . $this->cid; ?>">编辑</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php } ?>
                </p>
            <?php endif; ?>
        </div>
    <?php elseif ($this->is('index')) : ?>
        <?php
        $title = Helper::options()->title;
        if ($setting['indexBannerTitle'] != '') $title = $setting['indexBannerTitle'];
        $subtitle = Helper::options()->description;
        if ($setting['indexBannerSubtitle'] != '') $subtitle = $setting['indexBannerSubtitle'];
        ?>
        <div class="banner-title index force-normal">
            <h1 class="post-title"><span class="brand"><span><?php echo $title; ?></span></span><br><span class="subtitle"><?php echo $subtitle; ?></span></h1>
        </div>
    <?php endif; ?>
</div>