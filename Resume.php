<?php

/** 
 * Resume
 *
 * @package custom
 *  
 * @author      曼亚灿
 * @version     2022-11-21 0.1
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

<main id="pjax-container">
    <title hidden>
        <?php Contents::title($this); ?>
    </title>

    <?php
    $this->need('includes/ldjson.php');
    $this->need('includes/banner.php');
    //引入加密文件并设置密码
    require_once('MkEncrypt.php');
    MkEncrypt('', 'Resume');
    ?>

    <div class="wrapper container">
        <div class="contents-wrap">
            <!--start .contents-wrap-->
            <section id="post" class="float-up">
                <article class="post yue">
                    <!-- 最后修改时间检查 -->
                    <?php $postCheck = Utils::isOutdated($this);
                    if ($postCheck["is"] && $this->is('post')) : ?>
                        <p class="notice">请注意，简历最后修改于 <span style="font-size: 150%; color: red"><?php echo $postCheck["updated"]; ?></span> 天前，其中某些信息可能已经过时。</p>
                    <?php endif; ?>
                    <div class="articleBody resume-table" class="full">
                        <!-- 输出页面Markdown -->
                        <?php $this->content(); ?>
                    </div>
                </article>
            </section>
        </div>
    </div>
</main>

<?php
if (!Utils::isPjax()) {
    $this->need('includes/footer.php');
}
?>
