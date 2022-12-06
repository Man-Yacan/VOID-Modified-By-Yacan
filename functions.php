<?php

/**
 * functions.php
 *
 * 初始化主题
 *
 * @author      熊猫小A
 * @version     2019-01-15 1.0
 */
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

// 看不见错误就是没有错误
error_reporting(0);

require_once('libs/Utils.php');
require_once('libs/Contents.php');
require_once('libs/Comments.php');

Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Utils', 'addButton');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Utils', 'addButton');
// 为防止友链解析与 Markdown 冲突，重写 Markdown 函数
Typecho_Plugin::factory('Widget_Abstract_Contents')->markdown = array('Contents', 'markdown');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Contents', 'contentEx');
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('Contents', 'excerptEx');

/**
 * 主题启用
 */
function themeInit()
{
    Helper::options()->commentsAntiSpam = false;
    Helper::options()->commentsMaxNestingLevels = 999;
    Helper::options()->commentsOrder = 'DESC';
}

$GLOBALS['VOIDPluginREQ'] = 1.2;
$GLOBALS['VOIDVersion'] = 3.51;

/**
 * 主题设置
 */
function themeConfig($form)
{
    $defaultBanner = new Typecho_Widget_Helper_Form_Element_Text('defaultBanner', null, '', '首页顶部大图', '可以填写随机图 API。');
    $form->addInput($defaultBanner);
    $indexBannerTitle = new Typecho_Widget_Helper_Form_Element_Text('indexBannerTitle', null, '', '首页顶部大标题', '不要太长');
    $form->addInput($indexBannerTitle);
    $indexBannerSubtitle = new Typecho_Widget_Helper_Form_Element_Text('indexBannerSubtitle', null, '', '首页顶部小标题', '');
    $form->addInput($indexBannerSubtitle);

    $colorScheme = new Typecho_Widget_Helper_Form_Element_Radio('colorScheme', array('0' => '自动切换', '1' => '日间模式', '2' => '夜间模式'), '0', '主题颜色模式', '选择主题颜色模式。自动模式下每天 22:00 到次日 06:59 会显示为夜间模式。');
    $form->addInput($colorScheme);

    $indexStyle = new Typecho_Widget_Helper_Form_Element_Radio('indexStyle', array(
        '0' => '双栏',
        '1' => '单栏'
    ), '0', '首页版式', '选择单栏或者双栏瀑布流');
    $form->addInput($indexStyle);

    // 高级设置
    $reward = new Typecho_Widget_Helper_Form_Element_Text('reward', null, '', '打赏二维码', '图片链接，只允许一张图片，更多请自行合成。');
    $form->addInput($reward);
    $serifincontent = new Typecho_Widget_Helper_Form_Element_Radio('serifincontent', array('0' => '不启用', '1' => '启用'), '0', '文章内容使用衬线体', '是否对文章内容启用衬线体（思源宋体）。此服务由 Google Fonts 提供，可能会有加载较慢的情况。');
    $form->addInput($serifincontent);
    $lazyload = new Typecho_Widget_Helper_Form_Element_Radio('lazyload', array('1' => '启用', '0' => '不启用'), '1', '图片懒加载', '是否启用图片懒加载。');
    $form->addInput($lazyload);
    $enableMath = new Typecho_Widget_Helper_Form_Element_Radio('enableMath', array('0' => '不启用', '1' => '启用'), '0', '启用数学公式解析', '是否启用数学公式解析。启用后会多加载 1~2M 的资源。');
    $form->addInput($enableMath);
    $head = new Typecho_Widget_Helper_Form_Element_Textarea('head', null, '', 'head 标签输出内容', '统计代码等。');
    $form->addInput($head);
    $footer = new Typecho_Widget_Helper_Form_Element_Textarea('footer', null, '', 'footer 标签输出内容【直接在源代码添加！！！】', '备案号等。');
    $form->addInput($footer);
    $pjax = new Typecho_Widget_Helper_Form_Element_Radio('pjax', array('0' => '不启用', '1' => '启用'), '0', '启用 PJAX (BETA)', '是否启用 PJAX。如果你发现站点有点不对劲，又不知道这个选项是啥意思，请关闭此项。');
    $form->addInput($pjax);
    $pjaxreload = new Typecho_Widget_Helper_Form_Element_Textarea('pjaxreload', null, null, 'PJAX 重载函数', '输入要重载的 JS，如果你发现站点有点不对劲，又不知道这个选项是啥意思，请关闭 PJAX 并留空此项。');
    $form->addInput($pjaxreload);
    $serviceworker = new Typecho_Widget_Helper_Form_Element_Text('serviceworker', null, null, '自定义 Service Worker', '如果你知道这是什么，请把你的 SW 文件（例如主题 assets 文件夹下的 VOIDCacheRule.js）复制一份到<b>站点根目录</b>，并在这里填写文件名（例如 VOIDCacheRule.js）。若不知道该选项含义，请留空此项。');
    $form->addInput($serviceworker);

    // 超高级设置
    $advance = new Typecho_Widget_Helper_Form_Element_Textarea('advance', null, null, 超高级设置, '主题中包含一份 advanceSetting.sample.json，自己仿照着写吧。');
    $form->addInput($advance);
}

/**
 * 文章自定义字段
 */
function themeFields(Typecho_Widget_Helper_Layout $layout)
{
    $excerpt = new Typecho_Widget_Helper_Form_Element_Textarea('excerpt', null, null, '文章摘要', '输入自定义摘要。留空自动从文章截取。');
    $layout->addItem($excerpt);
    $banner = new Typecho_Widget_Helper_Form_Element_Text('banner', null, null, '文章主图', '输入图片URL，该图片会用于主页文章列表的显示。');
    $layout->addItem($banner);
    $bannerStyle = new Typecho_Widget_Helper_Form_Element_Select('bannerStyle', array(
        0 => '显示在顶部',
        1 => '显示在顶部并添加模糊效果',
        2 => '不显示'
    ), 0, '文章主图样式', '');
    $layout->addItem($bannerStyle);
    $bannerascover = new Typecho_Widget_Helper_Form_Element_Select('bannerascover', array('1' => '主图显示在标题上方', '2' => '主图作为标题背景', '0' => '不显示'), '1', '首页主图样式', '主图作为标题背景时会添加暗色遮罩，但仍然建议仅对暗色的主图采用该方式展示。否则请选择「主图显示在标题上方」。');
    $layout->addItem($bannerascover);
    $posttype = new Typecho_Widget_Helper_Form_Element_Select('posttype', array('0' => '一般文章', '1' => 'Landscape'), '0', '文章类型', '选择展示方式');
    $layout->addItem($posttype);
    $showfullcontent = new Typecho_Widget_Helper_Form_Element_Select('showfullcontent', array('0' => '否', '1' => '是'), '0', '在首页显示完整内容', '是否在首页展示完整内容。适合比较短的文章。');
    $layout->addItem($showfullcontent);
    $showTOC = new Typecho_Widget_Helper_Form_Element_Select('showTOC', array('0' => '不显示目录', '1' => '显示目录'), '0', '文章目录', '是否显示文章目录。');
    $layout->addItem($showTOC);
}

$GLOBALS['VOIDSetting'] = Utils::getVOIDSettings();

// 评论显示userAgent
// 获取浏览器信息
function getBrowser($agent)
{
    $outputer = '<i class="ua-icon icon-';
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
        $outputer .= 'ie"></i><span>&nbsp;&nbsp;Internet Explore';
    } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Firefox/', $regs[0]);
        $FireFox_vern = explode('.', $str1[1]);
        $outputer .= 'firefox"></i><span>&nbsp;&nbsp;FireFox';
    } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Maxthon/', $agent);
        $Maxthon_vern = explode('.', $str1[1]);
        $outputer .= 'edge"></i><span>&nbsp;&nbsp;Microsoft Edge';
    } else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
        $outputer .= '360"></i>&nbsp;&nbsp;360极速浏览器';
    } else if (preg_match('/Edg([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Edge/', $regs[0]);
        $Edge_vern = explode('.', $str1[1]);
        $outputer .= 'edge"></i><span>&nbsp;&nbsp;Microsoft Edge';
    } else if (preg_match('/UC/i', $agent)) {
        $str1 = explode('rowser/', $agent);
        $UCBrowser_vern = explode('.', $str1[1]);
        $outputer .= 'uc"></i><span>&nbsp;&nbsp;UC浏览器';
    } else if (preg_match('/QQ/i', $agent, $regs) || preg_match('/QQBrowser\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('rowser/', $agent);
        $QQ_vern = explode('.', $str1[1]);
        $outputer .= 'qq"></i><span>&nbsp;&nbsp;QQ浏览器';
    } else if (preg_match('/UBrowser/i', $agent, $regs)) {
        $str1 = explode('rowser/', $agent);
        $UCBrowser_vern = explode('.', $str1[1]);
        $outputer .= 'uc"></i><span>&nbsp;&nbsp;UC浏览器';
    } else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
        $outputer .= 'opera"></i><span>&nbsp;&nbsp;Opera';
    } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Chrome/', $agent);
        $chrome_vern = explode('.', $str1[1]);
        $outputer .= 'chrome"></i><span>&nbsp;&nbsp;Google Chrome';
    } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Version/', $agent);
        $safari_vern = explode('.', $str1[1]);
        $outputer .= 'safari"></i><span>&nbsp;&nbsp;Safari';
    } else {
        $outputer .= 'chrome"></i><span>&nbsp;&nbsp;Google Chrome';
    }
    echo $outputer . '</span>';
}

// 获取操作系统信息
function getOs($agent)
{
    $os = '&nbsp;&nbsp;<i class="ua-icon icon-';
    if (preg_match('/win/i', $agent)) {
        if (preg_match('/nt 6.0/i', $agent)) {
            $os .= 'win1"></i><span>&nbsp;&nbsp;Windows Vista';
        } else if (preg_match('/nt 6.1/i', $agent)) {
            $os .= 'win1"></i><span>&nbsp;&nbsp;Windows 7';
        } else if (preg_match('/nt 6.2/i', $agent)) {
            $os .= 'win2"></i><span>&nbsp;&nbsp;Windows 8';
        } else if (preg_match('/nt 6.3/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class= "ua-icon icon-win2"></i><span>&nbsp;&nbsp;Windows 8.1';
        } else if (preg_match('/nt 5.1/i', $agent)) {
            $os .= 'win1"></i><span>&nbsp;&nbsp;Windows XP';
        } else if (preg_match('/nt 10.0/i', $agent)) {
            $os .= 'win3"></i><span>&nbsp;&nbsp;Windows 10';
        } else {
            $os .= 'win2"></i><span>&nbsp;&nbsp;Windows X64';
        }
    } else if (preg_match('/android/i', $agent)) {
        if (preg_match('/android 12/i', $agent)) {
            $os .= 'android"></i><span>&nbsp;&nbsp;Android Snow Cone';
        } else if (preg_match('/android 11/i', $agent)) {
            $os .= 'android"></i><span>&nbsp;&nbsp;Android Red Velvet Cake';
        } else if (preg_match('/android 10/i', $agent)) {
            $os .= 'android"></i><span>&nbsp;&nbsp;Android Q';
        } else if (preg_match('/android 9/i', $agent)) {
            $os .= 'android"></i><span>&nbsp;&nbsp;Android Pie';
        } else {
            $os .= 'android"></i><span>&nbsp;&nbsp;Android';
        }
    } else if (preg_match('/ubuntu/i', $agent)) {
        $os .= 'ubuntu"></i><span>&nbsp;&nbsp;Ubuntu';
    } else if (preg_match('/linux/i', $agent)) {
        $os .= '&nbsp;&nbsp;<i class= "ua-icon icon-linux"></i><span>&nbsp;&nbsp;Linux';
    } else if (preg_match('/iPhone/i', $agent)) {
        $os .= 'apple"></i><span>&nbsp;&nbsp;iPhone';
    } else if (preg_match('/mac/i', $agent)) {
        $os .= 'mac"></i><span>&nbsp;&nbsp;MacOS';
    } else if (preg_match('/fusion/i', $agent)) {
        $os .= 'android"></i><span>&nbsp;&nbsp;Android';
    } else {
        $os .= 'linux"></i><span>&nbsp;&nbsp;Linux';
    }
    echo $os . '&nbsp;/&nbsp;</span>';
}


// 获取最热门文章，默认获取10篇
function getHotComments($limit = 10)
{
    $db = Typecho_Db::get();
    $result = $db->fetchAll(
        $db->select()->from('table.contents')
            ->where('status = ?', 'publish')
            ->where('type = ?', 'post')
            ->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
            ->limit($limit)
            ->order('viewsNum', Typecho_Db::SORT_DESC)
    );
    if ($result) {
        foreach ($result as $val) {
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $post_title = htmlspecialchars($val['title']);
            $permalink = $val['permalink'];
            if ($val['commentsNum'] >= 10) {
                echo '<li class="hot">';
            } else {
                echo '<li>';
            }
            // 为什么最后要多输出一个<i>标签？为了换行时伪元素能够被挤下去到第二行
            echo '<a href="' . $permalink . '" title="' . $post_title . '" target="_self">' . $val['title'] . '</a> <small>阅读' . $val['viewsNum'] . ' / 评论' . $val['commentsNum'] . '</small><i></i></li>';
        }
    }
}


// 获取站长最后来网站的时间（创建文章、修改文章、发表说说）
function get_last_update()
{
    $now = time();
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $create = $db->fetchRow($db->select('created')->from('table.contents')->limit(1)->order('created', Typecho_Db::SORT_DESC)); // 最后创建文章的时间
    $update = $db->fetchRow($db->select('modified')->from('table.contents')->limit(1)->order('modified', Typecho_Db::SORT_DESC)); // 最后修改文章的时间
    $comment_create = $db->fetchRow($db->select('created')->from('table.comments')->limit(1)->order('created', Typecho_Db::SORT_DESC)->where('author = ?', 'Yacan Man')); // 站长最后评论的时间
    $max_timer = max($create['created'], $update['modified'], $comment_create['created']);
    echo Typecho_I18n::dateWord($max_timer, $now);
}


// 获取数据库所有文章阅读数总和
function get_sum_view_num()
{
    $db = Typecho_Db::get();
    $query = $db->select('sum(viewsNum)')->from('table.contents');
    $result = $db->fetchAll($query);
    return $result[0]['sum(`viewsNum`)'];
}


/**
 * 添加随机用户头像
 */
function local_random_avatar()
{
    $options = Typecho_Widget::widget('Widget_Options');
    $thumb = 'https://cdn.manyacan.com/blog/random_avatar/' . rand(1, 60) . '.png';
    // $avatar = "<img alt='用户头像' src='{$thumb}' class='avatar avatar-50 photo' />";
    echo $thumb;
}


// 输出博客用户评论总数，输入邮箱在数据库中进行查询
function get_user_level($mail = '')
{
    $db = Typecho_Db::get();
    if ($mail) {
        $count = $db->fetchRow(
            $db->select('COUNT(*)')
                ->from('table.comments')
                ->where('status = ?', 'approved')
                ->where('mail = ?', $mail)
        );
        $commentnum = $count['COUNT(*)'];
        if ($commentnum <= 1) {
            return '';
        } elseif ($commentnum <= 2) {
            return '二进宫';
        } elseif ($commentnum <= 3) {
            return '三回头';
        } elseif ($commentnum <= 5) {
            return '老油条';
        } else {
            return 'OnlyFans';
        }
    } else {
        $count = $db->fetchRow(
            $db->select('COUNT(*)')
                ->from('table.comments')
                ->where('status = ?', 'approved')
        );
        return $count['COUNT(*)'];
    }
}


// 输入IP将其转化为物理地理信息，需要配合根目录qqwry.dat文件使用
function convertip($ip)
{
    $ip1num = 0;
    $ip2num = 0;
    $ipAddr1 = "";
    $ipAddr2 = "";
    $dat_path = './qqwry.dat';
    if (!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
        return 'IP 数据库路径不对';
    }
    if (!$fd = @fopen($dat_path, 'rb')) {
        return 'IP 数据库路径不正确';
    }
    $ip = explode('.', $ip);
    $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];
    $DataBegin = fread($fd, 4);
    $DataEnd = fread($fd, 4);
    $ipbegin = implode('', unpack('L', $DataBegin));
    if ($ipbegin < 0)
        $ipbegin += pow(2, 32);
    $ipend = implode('', unpack('L', $DataEnd));
    if ($ipend < 0)
        $ipend += pow(2, 32);
    $ipAllNum = ($ipend - $ipbegin) / 7 + 1;
    $BeginNum = 0;
    $EndNum = $ipAllNum;
    while ($ip1num > $ipNum || $ip2num < $ipNum) {
        $Middle = intval(($EndNum + $BeginNum) / 2);
        fseek($fd, $ipbegin + 7 * $Middle);
        $ipData1 = fread($fd, 4);
        if (strlen($ipData1) < 4) {
            fclose($fd);
            return 'System Error';
        }
        $ip1num = implode('', unpack('L', $ipData1));
        if ($ip1num < 0)
            $ip1num += pow(2, 32);

        if ($ip1num > $ipNum) {
            $EndNum = $Middle;
            continue;
        }
        $DataSeek = fread($fd, 3);
        if (strlen($DataSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $DataSeek = implode('', unpack('L', $DataSeek . chr(0)));
        fseek($fd, $DataSeek);
        $ipData2 = fread($fd, 4);
        if (strlen($ipData2) < 4) {
            fclose($fd);
            return 'System Error';
        }
        $ip2num = implode('', unpack('L', $ipData2));
        if ($ip2num < 0)
            $ip2num += pow(2, 32);
        if ($ip2num < $ipNum) {
            if ($Middle == $BeginNum) {
                fclose($fd);
                return 'Unknown';
            }
            $BeginNum = $Middle;
        }
    }
    $ipFlag = fread($fd, 1);
    if ($ipFlag == chr(1)) {
        $ipSeek = fread($fd, 3);
        if (strlen($ipSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $ipSeek = implode('', unpack('L', $ipSeek . chr(0)));
        fseek($fd, $ipSeek);
        $ipFlag = fread($fd, 1);
    }
    if ($ipFlag == chr(2)) {
        $AddrSeek = fread($fd, 3);
        if (strlen($AddrSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $ipFlag = fread($fd, 1);
        if ($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if (strlen($AddrSeek2) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }
        while (($char = fread($fd, 1)) != chr(0))
            $ipAddr2 .= $char;
        $AddrSeek = implode('', unpack('L', $AddrSeek . chr(0)));
        fseek($fd, $AddrSeek);
        while (($char = fread($fd, 1)) != chr(0))
            $ipAddr1 .= $char;
    } else {
        fseek($fd, -1, SEEK_CUR);
        while (($char = fread($fd, 1)) != chr(0))
            $ipAddr1 .= $char;
        $ipFlag = fread($fd, 1);
        if ($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if (strlen($AddrSeek2) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }
        while (($char = fread($fd, 1)) != chr(0)) {
            $ipAddr2 .= $char;
        }
    }
    fclose($fd);
    if (preg_match('/http/i', $ipAddr2)) {
        $ipAddr2 = '';
    }
    $ipaddr = "$ipAddr1 $ipAddr2";
    $ipaddr = preg_replace('/CZ88.NET/is', '', $ipaddr);
    $ipaddr = preg_replace('/^s*/is', '', $ipaddr);
    $ipaddr = preg_replace('/s*$/is', '', $ipaddr);
    if (preg_match('/http/i', $ipaddr) || $ipaddr == '') {
        $ipaddr = '可能来自火星';
    }
    $ipaddr = iconv('gbk', 'utf-8//IGNORE', $ipaddr);
    return $ipaddr;
}


// 读者墙——最多评论
function getMostVisitors($limit = 12, $masterEmail = 'myxc@live.cn')
{
    $db = Typecho_Db::get();
    $sql = $db->select('COUNT(author) AS cnt', 'author', 'url', 'mail')
        ->from('table.comments')
        ->where('status = ?', 'approved')
        ->where('type = ?', 'comment')
        ->where('mail != ?', $masterEmail)   //排除自己上墙
        ->group('mail')
        ->order('cnt', Typecho_Db::SORT_DESC)
        ->limit($limit);    //读取几位用户的信息
    $result = $db->fetchAll($sql);

    if ($result) {
        $maxNum = $result[0]['cnt'];
        foreach ($result as $value) {
            if (!$value['url']) {
                $value['url'] = 'mailto:' . $value['mail'];
            }
            $mostactive .= '<li><a target="_blank" rel="nofollow" href="' . $value['url'] . '"><img src="https://cravatar.cn/avatar/' . md5(strtolower($value['mail'])) . '?s=36&d=&r=G"><em>' . $value['author'] . '</em><strong>+' . $value['cnt'] . '</strong></a></li>';
        }
        echo $mostactive;
    }
}


// 读者墙——最近评论
function getRecentVisitors($limit = 12, $masterEmail = 'myxc@live.cn')
{
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.comments')
        ->group('mail')
        ->where('status = ?', 'approved')
        ->where('mail != ?', $masterEmail)   //排除自己上墙
        ->limit($limit)
        ->order('created', Typecho_Db::SORT_DESC);
    $result = $db->fetchAll($sql);

    if ($result) {
        foreach ($result as $value) {
            if (!$value['url']) {
                $value['url'] = 'mailto:' . $value['mail'];
            }

            $count = $db->fetchRow(
                $db->select('COUNT(*)')
                    ->from('table.comments')
                    ->where('status = ?', 'approved')
                    ->where('mail = ?', $value['mail'])
            );
            $commentnum = $count['COUNT(*)'];

            $mostactive .= '<li><a target="_blank" rel="nofollow" href="' . $value['url'] . '"><img src="https://cravatar.cn/avatar/' . md5(strtolower($value['mail'])) . '?s=36&d=&r=G"><em>' . $value['author'] . '</em><strong>+' . $commentnum . '</strong></a></li>';
        }
        echo $mostactive;
    }
}
