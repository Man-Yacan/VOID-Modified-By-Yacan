<style>
    .top-wire {
        position: absolute;
        top: -20px;
        left: 60px;
        width: 2px;
        height: 20px;
        background: #dc8f03;
    }

    .lantern {
        position: fixed;
        top: 20px;
        z-index: 2;
        cursor: pointer
    }

    .lantern-left {
        left: 7rem
    }

    .lantern-right {
        right: 7rem
    }

    .lantern-main {
        position: relative;
        width: 120px;
        height: 90px;
        margin: 50px;
        background: #d8000f;
        background: rgba(216, 0, 15, 0.9);
        border-radius: 50% 50%;
        -webkit-transform-origin: 50% -100px;
        -webkit-animation: swing 3s infinite ease-in-out;
        box-shadow: -5px 5px 50px 4px rgba(250, 108, 0, 1);
    }


    .lantern-right .lantern-main {
        -webkit-animation: swing 5s infinite ease-in-out
    }

    .deng-a {
        width: 100px;
        height: 90px;
        background: #d8000f;
        margin: 12px 8px 8px 8px;
        border-radius: 50% 50%;
        border: 2px solid #dc8f03;
    }

    .deng-b {
        width: 45px;
        height: 90px;
        background: #d8000f;
        background: rgba(216, 0, 15, 0.2);
        margin: -4px 8px 8px 26px;
        border-radius: 50% 50%;
        border: 2px solid #dc8f03;
    }

    .tassel {
        width: 5px;
        height: 40px;
        background: #ffa500;
        border-radius: 0 0 5px 5px;
    }

    .tassel-ani {
        -webkit-animation: swing 4s infinite ease-in-out
    }

    .tassel-a {
        margin: -10px 0 0 40px;
        -webkit-transform-origin: 50% -20px;
    }

    .tassel-b {
        margin: -35px 0 0 59px;
        -webkit-transform-origin: 50% -45px;
    }

    .tassel-c {
        margin: -45px 0 0 77px;
        -webkit-transform-origin: 50% -25px;
    }

    .lantern-main:before {
        position: absolute;
        top: -7px;
        left: 29px;
        height: 12px;
        width: 60px;
        content: " ";
        display: block;
        z-index: 999;
        border-radius: 5px 5px 0 0;
        border: solid 1px #dc8f03;
        background: #ffa500;
        background: linear-gradient(to rightright, #dc8f03, #ffa500, #dc8f03, #ffa500, #dc8f03);
    }

    .lantern-main:after {
        position: absolute;
        bottom: -7px;
        left: 10px;
        height: 12px;
        width: 60px;
        content: " ";
        display: block;
        margin-left: 20px;
        border-radius: 0 0 5px 5px;
        border: solid 1px #dc8f03;
        background: #ffa500;
        background: linear-gradient(to rightright, #dc8f03, #ffa500, #dc8f03, #ffa500, #dc8f03);
    }

    .deng-t {
        font-family: 华文行楷, Arial, Lucida Grande, Tahoma, sans-serif;
        font-size: 1.2rem;
        color: #dc8f03;
        font-weight: bold;
        line-height: 85px;
        text-align: center;
    }

    @keyframes swing {
        0% {
            transform: rotate(-10deg)
        }

        50% {
            transform: rotate(10deg)
        }

        100% {
            transform: rotate(-10deg)
        }
    }


    /* 移动端访问时，灯笼全部靠右 */
    @media screen and (max-width: 767px) {
        .lantern-left {
            left: -3rem
        }

        .lantern-right {
            right: -3rem
        }
    }
</style>

<!-- 灯笼 1 -->
<div class="lantern lantern-left">
    <div class="lantern-main">
        <div class="top-wire"></div>
        <div class="deng-a">
            <div class="deng-b">
                <div class="deng-t">疫情</div>
            </div>
        </div>
        <div class="tassel tassel-a tassel-ani"></div>
        <div class="tassel tassel-b tassel-ani"></div>
        <div class="tassel tassel-c tassel-ani"></div>
    </div>
</div>

<!-- 灯笼 2 -->
<div class="lantern lantern-right">
    <div class="lantern-main">
        <div class="top-wire"></div>
        <div class="deng-a">
            <div class="deng-b">
                <div class="deng-t">退散</div>
            </div>
        </div>
        <div class="tassel tassel-a tassel-ani"></div>
        <div class="tassel tassel-b tassel-ani"></div>
        <div class="tassel tassel-c tassel-ani"></div>
    </div>
</div>

<script>
    $(function() {
        $('.lantern').click(function() {
            $('.lantern').each(function() {
                $(this).fadeOut(500)
            })
            VOID.alert('再次刷新页面即可显示灯笼保平安~')
        })
    })
</script>