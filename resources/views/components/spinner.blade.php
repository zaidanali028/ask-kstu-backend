<div wire:loading.delay>
    <div style="display: flex;justify-content:center;align-items:center;background-color:black; position:fixed;top:0px;left:0px;z-index:9999;width:100%;height:100%;opacity:.75 ">

        <div class="la-line-spin-clockwise-fade-rotating">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

    </div>
</div>

<style>
    /*!
 * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
 * Copyright 2015 Daniel Cardoso <@DanielCardoso>
 * Licensed under MIT
 */
.la-line-spin-clockwise-fade-rotating,
.la-line-spin-clockwise-fade-rotating > div {
    position: relative;
    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
}
.la-line-spin-clockwise-fade-rotating {
    display: block;
    font-size: 0;
    color: #fff;
}
.la-line-spin-clockwise-fade-rotating.la-dark {
    color: #333;
}
.la-line-spin-clockwise-fade-rotating > div {
    display: inline-block;
    float: none;
    background-color: currentColor;
    border: 0 solid currentColor;
}
.la-line-spin-clockwise-fade-rotating {
    width: 32px;
    height: 32px;
    -webkit-animation: line-spin-clockwise-fade-rotating-rotate 6s infinite linear;
       -moz-animation: line-spin-clockwise-fade-rotating-rotate 6s infinite linear;
         -o-animation: line-spin-clockwise-fade-rotating-rotate 6s infinite linear;
            animation: line-spin-clockwise-fade-rotating-rotate 6s infinite linear;
}
.la-line-spin-clockwise-fade-rotating > div {
    position: absolute;
    width: 2px;
    height: 10px;
    margin: 2px;
    margin-top: -5px;
    margin-left: -1px;
    border-radius: 0;
    -webkit-animation: line-spin-clockwise-fade-rotating 1s infinite ease-in-out;
       -moz-animation: line-spin-clockwise-fade-rotating 1s infinite ease-in-out;
         -o-animation: line-spin-clockwise-fade-rotating 1s infinite ease-in-out;
            animation: line-spin-clockwise-fade-rotating 1s infinite ease-in-out;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(1) {
    top: 15%;
    left: 50%;
    -webkit-transform: rotate(0deg);
       -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
         -o-transform: rotate(0deg);
            transform: rotate(0deg);
    -webkit-animation-delay: -.875s;
       -moz-animation-delay: -.875s;
         -o-animation-delay: -.875s;
            animation-delay: -.875s;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(2) {
    top: 25.2512626585%;
    left: 74.7487373415%;
    -webkit-transform: rotate(45deg);
       -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
         -o-transform: rotate(45deg);
            transform: rotate(45deg);
    -webkit-animation-delay: -.75s;
       -moz-animation-delay: -.75s;
         -o-animation-delay: -.75s;
            animation-delay: -.75s;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(3) {
    top: 50%;
    left: 85%;
    -webkit-transform: rotate(90deg);
       -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
         -o-transform: rotate(90deg);
            transform: rotate(90deg);
    -webkit-animation-delay: -.625s;
       -moz-animation-delay: -.625s;
         -o-animation-delay: -.625s;
            animation-delay: -.625s;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(4) {
    top: 74.7487373415%;
    left: 74.7487373415%;
    -webkit-transform: rotate(135deg);
       -moz-transform: rotate(135deg);
        -ms-transform: rotate(135deg);
         -o-transform: rotate(135deg);
            transform: rotate(135deg);
    -webkit-animation-delay: -.5s;
       -moz-animation-delay: -.5s;
         -o-animation-delay: -.5s;
            animation-delay: -.5s;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(5) {
    top: 84.9999999974%;
    left: 50.0000000004%;
    -webkit-transform: rotate(180deg);
       -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
         -o-transform: rotate(180deg);
            transform: rotate(180deg);
    -webkit-animation-delay: -.375s;
       -moz-animation-delay: -.375s;
         -o-animation-delay: -.375s;
            animation-delay: -.375s;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(6) {
    top: 74.7487369862%;
    left: 25.2512627193%;
    -webkit-transform: rotate(225deg);
       -moz-transform: rotate(225deg);
        -ms-transform: rotate(225deg);
         -o-transform: rotate(225deg);
            transform: rotate(225deg);
    -webkit-animation-delay: -.25s;
       -moz-animation-delay: -.25s;
         -o-animation-delay: -.25s;
            animation-delay: -.25s;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(7) {
    top: 49.9999806189%;
    left: 15.0000039834%;
    -webkit-transform: rotate(270deg);
       -moz-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
         -o-transform: rotate(270deg);
            transform: rotate(270deg);
    -webkit-animation-delay: -.125s;
       -moz-animation-delay: -.125s;
         -o-animation-delay: -.125s;
            animation-delay: -.125s;
}
.la-line-spin-clockwise-fade-rotating > div:nth-child(8) {
    top: 25.2506949798%;
    left: 25.2513989292%;
    -webkit-transform: rotate(315deg);
       -moz-transform: rotate(315deg);
        -ms-transform: rotate(315deg);
         -o-transform: rotate(315deg);
            transform: rotate(315deg);
    -webkit-animation-delay: 0s;
       -moz-animation-delay: 0s;
         -o-animation-delay: 0s;
            animation-delay: 0s;
}
.la-line-spin-clockwise-fade-rotating.la-sm {
    width: 16px;
    height: 16px;
}
.la-line-spin-clockwise-fade-rotating.la-sm > div {
    width: 1px;
    height: 4px;
    margin-top: -2px;
    margin-left: 0;
}
.la-line-spin-clockwise-fade-rotating.la-2x {
    width: 64px;
    height: 64px;
}
.la-line-spin-clockwise-fade-rotating.la-2x > div {
    width: 4px;
    height: 20px;
    margin-top: -10px;
    margin-left: -2px;
}
.la-line-spin-clockwise-fade-rotating.la-3x {
    width: 96px;
    height: 96px;
}
.la-line-spin-clockwise-fade-rotating.la-3x > div {
    width: 6px;
    height: 30px;
    margin-top: -15px;
    margin-left: -3px;
}
/*
 * Animations
 */
@-webkit-keyframes line-spin-clockwise-fade-rotating-rotate {
    100% {
        -webkit-transform: rotate(-360deg);
                transform: rotate(-360deg);
    }
}
@-moz-keyframes line-spin-clockwise-fade-rotating-rotate {
    100% {
        -moz-transform: rotate(-360deg);
             transform: rotate(-360deg);
    }
}
@-o-keyframes line-spin-clockwise-fade-rotating-rotate {
    100% {
        -o-transform: rotate(-360deg);
           transform: rotate(-360deg);
    }
}
@keyframes line-spin-clockwise-fade-rotating-rotate {
    100% {
        -webkit-transform: rotate(-360deg);
           -moz-transform: rotate(-360deg);
             -o-transform: rotate(-360deg);
                transform: rotate(-360deg);
    }
}
@-webkit-keyframes line-spin-clockwise-fade-rotating {
    50% {
        opacity: .2;
    }
    100% {
        opacity: 1;
    }
}
@-moz-keyframes line-spin-clockwise-fade-rotating {
    50% {
        opacity: .2;
    }
    100% {
        opacity: 1;
    }
}
@-o-keyframes line-spin-clockwise-fade-rotating {
    50% {
        opacity: .2;
    }
    100% {
        opacity: 1;
    }
}
@keyframes line-spin-clockwise-fade-rotating {
    50% {
        opacity: .2;
    }
    100% {
        opacity: 1;
    }
}
</style>
