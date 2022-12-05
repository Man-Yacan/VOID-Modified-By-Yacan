<?php

/** 
 * Friends
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

<main id="pjax-container">
    <title hidden>
        <?php Contents::title($this); ?>
    </title>

    <?php
    $this->need('includes/ldjson.php');
    $this->need('includes/banner.php');
    ?>

    <div class="wrapper container">
        <div class="contents-wrap">
            <!--start .contents-wrap-->
            <section id="post" class="float-up">
                <article class="post yue">
                    <div class="articleBody resume-table" class="full">
                        <h2>网上邻居</h2>
                        <!-- 输出页面 Markdown -->
                        <?php $this->content(); ?>
                        <!-- 输出页面 Markdown End -->

                        <hr>
                        <!-- 读者墙 -->
                        <h2>读者墙</h2>
                        <p class="notice">留言不积极，思想有问题~☺️</p>
                        <div id="reader-wall">
                            <ul class='readers-list'>
                                <?php getFriendWall(); ?>
                            </ul>
                        </div>
                    </div>
                </article>
            </section>
        </div>
    </div>
    <!-- css样式 -->


    <style>
        #reader-wall>.readers-list {
            padding: unset;
            margin: unset;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: flex-start;
        }


        #reader-wall>.readers-list li {
            width: 25%;
            height: fit-content;
            list-style: none;
        }

        #reader-wall>.readers-list a::after {
            content: unset
        }

        #reader-wall>.readers-list a {
            margin: 4px;
            border: #ccc 1px solid;
            border-radius: 2px;
            font-size: 10px;
            height: 40px;
            line-height: 40px;
            position: relative;
            display: block;
        }

        #reader-wall>.readers-list a:hover {
            transform: translateY(-5px);
            box-shadow: 8px 8px 5px rgb(0 0 0 / 38%)
        }

        #reader-wall .readers-list a img,
        strong {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        #reader-wall>.readers-list a>img {
            border: 1px solid #ccc;
            left: .2rem;
            margin: unset;
            animation: img-light 4s ease-in-out infinite
        }

        #reader-wall>.readers-list a:hover>img {
            transform: translateY(-50%) scale(1.15) rotate(720deg)
        }

        @keyframes img-light {
            0% {
                box-shadow: 0 0 4px #f00;
            }

            25% {
                box-shadow: 0 0 16px #0f0;
            }

            50% {
                box-shadow: 0 0 4px #00f;
            }

            75% {
                box-shadow: 0 0 16px #0f0;
            }

            100% {
                box-shadow: 0 0 4px #f00;
            }
        }

        #reader-wall>.readers-list a>em {
            font-size: 1rem;
            font-family: fangsong;
            max-width: 58%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: bold;
            margin: 0 auto;
            display: block;
            text-align: center;
        }

        #reader-wall>.readers-list a:hover>em {
            font-size: 250%;
        }

        #reader-wall>.readers-list a>strong {
            right: .4rem;
        }

        @media screen and (max-width:767px) {
            #reader-wall>.readers-list li {
                width: 50%;
            }
        }

        body.theme-dark #reader-wall>.readers-list a {
            background-color: rgba(230, 230, 255, .03);
        }

        .readers-list * {
            -webkit-transition: all .2s ease-out;
            -moz-transition: all .2s ease-out;
            transition: all .2s ease-out;
        }
    </style>


    <!--评论区，可选（只有当允许评论的时候才输出评论区）-->
    <?php $this->need('includes/comments.php'); ?>
</main>


<!-- footer -->
<?php
if (!Utils::isPjax()) {
    $this->need('includes/footer.php');
}
?>