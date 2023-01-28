<?php
/**
 * Created by PhpStorm.
 * User: Léo Zmoos
 * Date: 23.01.2023
 */

$titre = "BDR - Aerooking";
// ouvre la mémoire tampon
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
        &.ui-slider-active {
             cursor: grabbing;
         }
        }

        .box {
            --primary: #275efe;
            --headline: #3F4656;
            --text: #99A3BA;
            width: 100%;
            max-width: 312px;
            padding: 36px 32px 48px 32px;
            background: #fff;
            border-radius: 9px;
            box-shadow: 0 1px 4px rgba(18, 22, 33, .12);
        h3 {
            font-family: inherit;
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 20px 0;
            color: var(--headline);
        span {
            font-weight: 500;
        }
        }
        .values,
        small {
        div {
            display: inline-block;
            vertical-align: top;
        }
        }
        .values {
            margin: 0;
            font-weight: 500;
            color: var(--primary);
        & > div {
        &:first-child {
             margin-right: 2px;
         }
        &:last-child {
             margin-left: 2px;
         }
        }
        }
        small {
            color: var(--text);
            display: block;
            margin-top: 8px;
            font-size: 14px;
        }
        .slider {
            margin-top: 40px;
        }
        }

        .slider {
            --primary: #275efe;
            --handle: #fff;
            --handle-active: #{mix(white, #275efe, 70%)};
            --handle-hover: #{mix(white, #275efe, 90%)};
            --handle-border: 2px solid var(--primary);
            --line: #cdd9ed;
            --line-active: var(--primary);
            height: 23px;
            width: 100%;
            position: relative;
            pointer-events: none;
        .ui-slider-handle {
            --y: 0;
            --background: var(--handle);
            cursor: grab;
            -webkit-tap-highlight-color: transparent;
            top: 0;
            width: 23px;
            height: 23px;
            transform: translateX(-50%);
            position: absolute;
            outline: none;
            display: block;
            pointer-events: auto;
        div {
            width: 23px;
            height: 23px;
            border-radius: 50%;
            transition: background .4s ease;
            transform: translateY(calc(var(--y) * 1px));
            border: var(--handle-border);
            background: var(--background);
        }
        &:hover {
             --background: var(--handle-hover);
         }
        &:active {
             --background: var(--handle-active);
             cursor: grabbing;
         }
        }
        svg {
            --stroke: var(--line);
            display: block;
            height: 83px;
        path {
            fill: none;
            stroke: var(--stroke);
            stroke-width: 1;
        }
        }
        .active,
        & > svg {
              position: absolute;
              top: -30px;
              height: 83px;
          }
        & > svg {
              left: 0;
              width: 100%;
          }
        .active {
            position: absolute;
            overflow: hidden;
            left: calc(var(--l) * 1px);
            right: calc(var(--r) * 1px);
        svg {
            --stroke: var(--line-active);
            position: relative;
            left: calc(var(--l) * -1px);
            right: calc(var(--r) * -1px);
        path {
            stroke-width: 2;
        }
        }
        }
        }

        html {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        * {
            box-sizing: inherit;
        &:before,
        &:after {
             box-sizing: inherit;
         }
        }

        // Center & dribbble
           body {
               min-height: 100vh;
               display: flex;
               justify-content: center;
               align-items: center;
               font-family: 'Roboto', Arial;
               background: #CDD9ED;
        .dribbble {
            position: fixed;
            display: block;
            right: 20px;
            bottom: 20px;
        img {
            display: block;
            height: 28px;
        }
        }
        }
    </style>
</head>

<html>
<body>

<div class="section-center">
    <div class="container" style="margin-top: 200px">
        <div class="row">
            <!-- Type de trajet, classes et bagages -->
            <div class="booking-form">

                <div class="box">

                    <h3>Price <span>Range</span></h3>
                    <div class="values">
                        <div>$<span id="first"></span></div> - <div>$<span id="second"></span></div>
                    </div>
                    <small>
                        Current Range:
                        <div>$<span id="third"></span></div>
                    </small>

                    <div class="slider" data-value-0="#first" data-value-1="#second" data-range="#third"></div>

                </div>

                <!-- dribbble -->
                <a class="dribbble" href="https://dribbble.com/shots/7268454-Rubber-Slider" target="_blank"><img src="https://cdn.dribbble.com/assets/dribbble-ball-mark-2bd45f09c2fb58dbbfb44766d5d1d07c5a12972d602ef8b32204d28fa3dda554.svg" alt=""></a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<script>
    $('.slider').each(function(e) {

        var slider = $(this),
            width = slider.width(),
            handle,
            handleObj;

        let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('viewBox', '0 0 ' + width + ' 83');

        slider.html(svg);
        slider.append($('<div>').addClass('active').html(svg.cloneNode(true)));

        slider.slider({
            range: true,
            values: [1800, 7800],
            min: 500,
            step: 5,
            minRange: 1000,
            max: 12000,
            create(event, ui) {

                slider.find('.ui-slider-handle').append($('<div />'));

                $(slider.data('value-0')).html(slider.slider('values', 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '&thinsp;'));
                $(slider.data('value-1')).html(slider.slider('values', 1).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '&thinsp;'));
                $(slider.data('range')).html((slider.slider('values', 1) - slider.slider('values', 0)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '&thinsp;'));

                setCSSVars(slider);

            },
            start(event, ui) {

                $('body').addClass('ui-slider-active');

                handle = $(ui.handle).data('index', ui.handleIndex);
                handleObj = slider.find('.ui-slider-handle');

            },
            change(event, ui) {
                setCSSVars(slider);
            },
            slide(event, ui) {

                let min = slider.slider('option', 'min'),
                    minRange = slider.slider('option', 'minRange'),
                    max = slider.slider('option', 'max');

                if(ui.handleIndex == 0) {
                    if((ui.values[0] + minRange) >= ui.values[1]) {
                        slider.slider('values', 1, ui.values[0] + minRange);
                    }
                    if(ui.values[0] > max - minRange) {
                        return false;
                    }
                } else if(ui.handleIndex == 1) {
                    if((ui.values[1] - minRange) <= ui.values[0]) {
                        slider.slider('values', 0, ui.values[1] - minRange);
                    }
                    if(ui.values[1] < min + minRange) {
                        return false;
                    }
                }

                $(slider.data('value-0')).html(ui.values[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, '&thinsp;'));
                $(slider.data('value-1')).html(ui.values[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, '&thinsp;'));
                $(slider.data('range')).html((slider.slider('values', 1) - slider.slider('values', 0)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '&thinsp;'));

                setCSSVars(slider);

            },
            stop(event, ui) {

                $('body').removeClass('ui-slider-active');

                let duration = .6,
                    ease = Elastic.easeOut.config(1.08, .44);

                TweenMax.to(handle, duration, {
                    '--y': 0,
                    ease: ease
                });

                TweenMax.to(svgPath, duration, {
                    y: 42,
                    ease: ease
                });

                handle = null;

            }
        });

        var svgPath = new Proxy({
            x: null,
            y: null,
            b: null,
            a: null
        }, {
            set(target, key, value) {
                target[key] = value;
                if(target.x !== null && target.y !== null && target.b !== null && target.a !== null) {
                    slider.find('svg').html(getPath([target.x, target.y], target.b, target.a, width));
                }
                return true;
            },
            get(target, key) {
                return target[key];
            }
        });

        svgPath.x = width / 2;
        svgPath.y = 42;
        svgPath.b = 0;
        svgPath.a = width;

        $(document).on('mousemove touchmove', e => {
            if(handle) {

                let laziness = 4,
                    max = 24,
                    edge = 52,
                    other = handleObj.eq(handle.data('index') == 0 ? 1 : 0),
                    currentLeft = handle.position().left,
                    otherLeft = other.position().left,
                    handleWidth = handle.outerWidth(),
                    handleHalf = handleWidth / 2,
                    y = e.pageY - handle.offset().top - handle.outerHeight() / 2,
                    moveY = (y - laziness >= 0) ? y - laziness : (y + laziness <= 0) ? y + laziness : 0,
                    modify = 1;

                moveY = (moveY > max) ? max : (moveY < -max) ? -max : moveY;
                modify = handle.data('index') == 0 ? ((currentLeft + handleHalf <= edge ? (currentLeft + handleHalf) / edge : 1) * (otherLeft - currentLeft - handleWidth <= edge ? (otherLeft - currentLeft - handleWidth) / edge : 1)) : ((currentLeft - (otherLeft + handleHalf * 2) <= edge ? (currentLeft - (otherLeft + handleWidth)) / edge : 1) * (slider.outerWidth() - (currentLeft + handleHalf) <= edge ? (slider.outerWidth() - (currentLeft + handleHalf)) / edge : 1));
                modify = modify > 1 ? 1 : modify < 0 ? 0 : modify;

                if(handle.data('index') == 0) {
                    svgPath.b = currentLeft / 2  * modify;
                    svgPath.a = otherLeft;
                } else {
                    svgPath.b = otherLeft + handleHalf;
                    svgPath.a = (slider.outerWidth() - currentLeft) / 2 + currentLeft + handleHalf + ((slider.outerWidth() - currentLeft) / 2) * (1 - modify);
                }

                svgPath.x = currentLeft + handleHalf;
                svgPath.y = moveY * modify + 42;

                handle.css('--y', moveY * modify);

            }
        });

    });

    function getPoint(point, i, a, smoothing) {
        let cp = (current, previous, next, reverse) => {
                let p = previous || current,
                    n = next || current,
                    o = {
                        length: Math.sqrt(Math.pow(n[0] - p[0], 2) + Math.pow(n[1] - p[1], 2)),
                        angle: Math.atan2(n[1] - p[1], n[0] - p[0])
                    },
                    angle = o.angle + (reverse ? Math.PI : 0),
                    length = o.length * smoothing;
                return [current[0] + Math.cos(angle) * length, current[1] + Math.sin(angle) * length];
            },
            cps = cp(a[i - 1], a[i - 2], point, false),
            cpe = cp(point, a[i - 1], a[i + 1], true);
        return `C ${cps[0]},${cps[1]} ${cpe[0]},${cpe[1]} ${point[0]},${point[1]}`;
    }

    function getPath(update, before, after, width) {
        let smoothing = .16,
            points = [
                [0, 42],
                [before <= 0 ? 0 : before, 42],
                update,
                [after >= width ? width : after, 42],
                [width, 42]
            ],
            d = points.reduce((acc, point, i, a) => i === 0 ? `M ${point[0]},${point[1]}` : `${acc} ${getPoint(point, i, a, smoothing)}`, '');
        return `<path d="${d}" />`;
    }

    function setCSSVars(slider) {
        let handle = slider.find('.ui-slider-handle');
        slider.css({
            '--l': handle.eq(0).position().left + handle.eq(0).outerWidth() / 2,
            '--r': slider.outerWidth() - (handle.eq(1).position().left + handle.eq(1).outerWidth() / 2)
        });
    }

</script>

<?php $contenu = ob_get_clean(); // Stocke la page dans la variable
require "layout.php";
?>



