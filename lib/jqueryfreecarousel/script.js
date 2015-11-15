var _scroller;
_scroller = function () { // scroller
    return{
        speed:200,/*10,*. /*скорость, чем больше значние, тем медленнее движение*/
        direct:-1,/* -1 - движение влево, +1 - вправо*/
        position:0,
        t:null,
        // Инициализация скроллера
        init: function () {
            var el;
            // Установка обработчика колесика мыши
            el = document.getElementById('scroller_container');
            _scroller.addEvent(el, 'mousewheel', _scroller.wheel);
            _scroller.addEvent(el, 'DOMMouseScroll', _scroller.wheel);//вариант события прокрутка мышкой для файерфокс

            _scroller.timer(_scroller.direct); // запускаю скроллер
        },

        // Обработчик колесика мыши
        wheel: function (e) {
            _scroller.stop();
            e = e ? e : window.event;

            /*var wheelElem = e.target ? e.target : e.srcElement;*/
            var wheelData = e.detail ? e.detail * -1 : e.wheelDelta / 40;
           // console.log(e.detail);//schreibt->  - если налево->  + если направо

            // В движке WebKit возвращается значение в 100 раз больше
            if (Math.abs(wheelData) > 100) {
                wheelData = Math.round(wheelData / 100);
            }
            //_scroller.scroll(wheelData*10);
            _scroller.direct=wheelData>0?1:-1;
            _scroller.timer(_scroller.direct);
            if (window.event) {
                e.cancelBubble = true;
                e.returnValue = false;
                e.cancel = true;
            }
            if (e.stopPropagation && e.preventDefault) {
                e.stopPropagation();
                e.preventDefault();
            }
            return false;
        },

        // Функция скроллера
        scroll: function (wheel) {
            var div = document.getElementById('scroller_container').firstElementChild;
            var the_first, the_last, width;
            _scroller.position += wheel;//add1 pointt causes gradual moovement to the right or to the left

            //console.log('_scroller_position=>'+_scroller.position);

            if (wheel>0) {
                if (_scroller.position >= 0) { // берем последнюю картинку и вставляем ёё в начало
                    // В этот момент можно подгружать более левую картинку и удалить последнюю
                    the_first=div;//.firstElementChild; // контейнер с картинками
                    the_last=the_first.lastElementChild; // последняя картинка вместе с анкором
                    width= the_last.firstElementChild.clientWidth; // размер картинки
                    the_first.insertBefore(the_last,the_first.firstElementChild);
                    _scroller.position-=width;
                }
            }
            else {
                the_first = div;//.firstElementChild; // контейнер с картинками

                the_last = the_first.firstElementChild; // первая картинка вместе с анкором
                width = the_last.firstElementChild.clientWidth; // размер картинки
                if(_scroller.position < -width){ // если картинка ушла влево из зоны видимости переношу её в конец списка
                    // В этот момент можно подгружать следующую картинку и удалить первую
                    the_first.appendChild(the_last);

                    _scroller.position+=width;//пысля того як первый рисунок переставленный назад обнуяеться
                    //тобто зменшуеться до  -1
                   // console.log('scroller_position=>=>'+_scroller.position);//schreibt immer -1

                }
            }
            div.style.left = _scroller.position + 'px';
//console.log(/*'_scroller_position=>'+_scroller.position+*/'    width=>'+width);//_scroller_position=>-133    width=>133

        },

        // Таймер скроллера
        timer: function (wheel) {//по умолчаинию при загрузке -1
            _scroller.stop();
            _scroller.t = setInterval("_scroller.scroll(" + wheel + ");", _scroller.speed);
            //launch endless cycle
        },

        // Остановка скроллера
        stop: function () {
            if (_scroller.t != null) {
                clearInterval(_scroller.t);
                _scroller.t = null;
            }
        },

        // назначить обработчик события
        addEvent:function(el, evType, fn, useCapture) {
            if (el.addEventListener) {
                el.addEventListener(evType, fn, useCapture);
            }else if (el.attachEvent) {
                var r = el.attachEvent('on' + evType, fn);
            }else el['on' + evType] = fn;
        }
    };
}();//конец функции которая вносится в переменную _scroller

/*if(!document.funcDomReady)document.funcDomReady=function(){_scroller.init()};
 else onDomReady(_scroller.init);*/
//window.onload=function(){setTimeout(_scroller.init,100);}; // стартуем с задержкой, чтобы все прогрузилось
//самовызывающаяся функция
(function(){setTimeout(_scroller.init,100);})();

document.getElementById('scroller_container').addEventListener('mousemove', function(){_scroller.stop()});

document.getElementById('scroller_container').addEventListener('mouseout', function(){_scroller.timer(_scroller.direct)});