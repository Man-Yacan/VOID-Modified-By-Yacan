<style>
/*灯笼*/
.xian {
    position: absolute;
    top: -20px;
    left: 60px;
    width: 2px;
    height: 20px;
    background: #dc8f03;
}
.deng-box {
    position: fixed;
    top: 20px;
    z-index: 2;
    left: 2rem;
}
.deng-box1 {
    position: fixed;
    top: 20px;
    right: 2rem;
    z-index: 2;
}

/* 移动端访问时，灯笼全部靠右 */
@media screen and (max-width: 767px) {
    .deng-box {
        left: -2rem;
        /*right: -2rem;*/
        /*z-index: 1000;*/
    }
    
    .deng-box1 {
        right: -2rem;
    }
}


.deng-box1 .deng {
    position: relative;
    width: 120px;
    height: 90px;
    margin: 50px;
    background: #d8000f;
    background: rgba(216, 0, 15, 0.9);
    border-radius: 50% 50%;
    -webkit-transform-origin: 50% -100px;
    -webkit-animation: swing 5s infinite ease-in-out;
    box-shadow: -5px 5px 50px 4px rgba(250, 108, 0, 1);
}
.deng {
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
.deng-a {
    width: 100px;
    height: 90px;
    background: #d8000f;
    background: rgba(216, 0, 15, 0.2);
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
.shui {
    width: 5px;
    height: 40px;
    background: #ffa500;
    border-radius: 0 0 5px 5px;
}
.shui-a {
    margin: -10px 0 0 40px;
    -webkit-animation: swing 4s infinite ease-in-out;
    -webkit-transform-origin: 50% -20px;
}
.shui-b {
    margin: -35px 0 0 59px;
    -webkit-animation: swing 4s infinite ease-in-out;
    -webkit-transform-origin: 50% -45px;
}
.shui-c {
    margin: -45px 0 0 77px;
    -webkit-animation: swing 4s infinite ease-in-out;
    -webkit-transform-origin: 50% -25px;
}
.deng:before {
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
.deng:after {
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
    font-family: 华文行楷,Arial,Lucida Grande,Tahoma,sans-serif;
    font-size: 1.2rem;
    color: #dc8f03;
    font-weight: bold;
    line-height: 85px;
    text-align: center;
}
.night .deng-t,
.night .deng-box,
.night .deng-box1 {
    background: transparent !important;
}
@-moz-keyframes swing {
    0% {
        -moz-transform: rotate(-10deg)
    }
    50% {
        -moz-transform: rotate(10deg)
    }
    100% {
        -moz-transform: rotate(-10deg)
    }
}
@-webkit-keyframes swing {
    0% {
        -webkit-transform: rotate(-10deg)
    }
    50% {
        -webkit-transform: rotate(10deg)
    }
    100% {
        -webkit-transform: rotate(-10deg)
    }
}
</style>

<!-- 灯笼 1 -->
<div class="deng-box" id="box-00">
    <div class="deng">
        <div class="xian"></div>
        <div class="deng-a">
            <div class="deng-b"><div class="deng-t">国庆</div></div>
        </div>
        <div class="shui shui-a"></div>
        <div class="shui shui-b"></div>
        <div class="shui shui-c"></div>
    </div>
</div>

<!-- 灯笼 2 -->
<div class="deng-box1" id="box-01">
    <div class="deng">
        <div class="xian"></div>
        <div class="deng-a">
            <div class="deng-b"><div class="deng-t">快乐</div></div>
        </div>
        <div class="shui shui-a"></div>
        <div class="shui shui-b"></div>
        <div class="shui shui-c"></div>
    </div>
</div>

<script>
window.onload = function() {
    document.getElementById("box-00").onclick = function() {
        document.getElementById("box-00").style.display = "none";
        document.getElementById("box-01").style.display = "none"
    };
    document.getElementById("box-01").onclick = function() {
        document.getElementById("box-01").style.display = "none";
        document.getElementById("box-00").style.display = "none"
    }
};
</script>