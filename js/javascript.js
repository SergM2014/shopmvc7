var current_arr=[];

var leftmenu = document.getElementsByClassName('leftmenu')[0];
var upmenu = document.getElementById('menu');
var prior_result = document.getElementById('prior_result');

function find_closest_heighest_class(el, cl){
    var elem = el;
    while (!elem.classList.contains( cl )){
        if(elem.tagName.toLowerCase() == 'html') return false;
        elem = elem.parentNode;
        if(!elem) return false;
    }
    return elem;
}

function find_closest_heighest_id(el, id){
    var elem = el;

    while( elem.id != id){

        if(elem.tagName.toLowerCase() == 'html') return false;
        elem = elem.parentNode;
        if(!elem) return false;
    }
    return elem;
}


function find_closest_heigher_li(el){
    var elem = el;
      do {
        elem = elem.parentNode;
            var tag= elem.tagName.toLowerCase();
            if(tag== 'li') { return elem;}
          if(tag == 'html') return false;

        }  while (!elem.classList.contains('parent-0'));

        return false;

}

//**************************************************************

if(leftmenu) {
    handle = function menu_processing(e) {
        //***************
// на мобильних девайсах выдвигаем блок меню вправо
        if (document.body.clientWidth < 750) {
            document.getElementById('leftmenu').style.display = "block";
            setTimeout(function () {
                leftmenu.classList.add('active-menu');
            }, 500);
        }
//***************
        var i, li, children_ul, parent_ul, children_li, children, visible_arr, parent;

        for (i = 0; i < current_arr.length; i++) {
            current_arr[i].classList.remove('current');

            var ul = find_closest_heighest_class(current_arr[i], 'visible');
            if (ul) ul.className = "invisible";
        }

        current_arr.length = 0;

        li = e.target.parentNode;

        if (li.classList.contains("content")) return false;

        do {
            li.classList.add('current');
            current_arr.push(li);

            children_ul = li.querySelector('ul');

            if (children_ul) {
                children_ul.className = 'visible';
                parent_ul = li.parentNode;
                children_li = parent_ul.childNodes;

                for (i = 0; i < children_li.length; i++) {

                    if (children_li[i]) {
                        if (!children_li[i].classList.contains('current')) {
                            children = children_li[i].childNodes;

                            if (children[1] && children[1].tagName.toLowerCase() == 'ul') children[1].className = "invisible";
                        }
                    }

                }
            }
            li = find_closest_heigher_li(li);

        } while (li);

        visible_arr = e.currentTarget.querySelectorAll('ul.visible');

        for (i = 0; i < visible_arr.length; i++) {
            parent = visible_arr[i].parentNode;
            if (!parent.classList.contains('current') && visible_arr[i].className == 'visible') {
                visible_arr[i].className = 'invisible';
            }
        }

    };


//откритие скритие детских членов в меню
    leftmenu.addEventListener('click', handle);
//end of the left menu

}




//вешаем на боди разную фигню
    document.onclick = function (e) {

        if (document.body.clientWidth < 750) {
//скрытие левого меню при клике по ним
            if (leftmenu) {
                var target = e.target;
                while (!target.classList.contains('leftmenu')) {
                    target = target.parentNode;
                    if (target.tagName.toLowerCase() == 'html') {
                        if (leftmenu.classList.contains('active-menu'))leftmenu.classList.remove('active-menu');
                        document.getElementById('leftmenu').style.display = 'none';
                        break;
                    }
                }
            }


            //hide upper menu for mobile devices
            target = e.target;
            if (document.getElementById('menu').classList.contains('active-uppermenu') && target.id != 'touch-button') {
                while (target.id != 'menu') {
                    target = target.parentNode;
                    if (target.tagName.toLowerCase() == 'html') {
                        if (upmenu.classList.contains('active-uppermenu'))upmenu.classList.remove('active-uppermenu');
                        setTimeout(function () {
                            upmenu.style.display = 'none'
                        }, 1200);
                        break;
                    }
                }
            }
        }


//скрытие предварительных результатов при клике поза дивом
        target = e.target;
        if (prior_result.classList.contains('founded')) {
            while (target.id != 'prior_result') {
                target = target.parentNode;
                if (!target || target.tagName.toLowerCase() == 'html') {
                    prior_result.classList.remove('founded');
                    break;
                }
            }
        }


        var kcaptcha = find_closest_heighest_id(e.target, 'kcaptcha');
        if (kcaptcha) {
            kcaptcha.setAttribute('src', 'http://' + location.hostname + '/lib/kcaptcha/index.php?PHPSESSID=' + Math.random());
        }

//нажимаем клавишу перерахунок корзини
        var recount = find_closest_heighest_id(e.target, 'recount_busket');
        if (recount) {

            var numbers = document.getElementsByClassName('modalwindow')[0].querySelectorAll('input');

           var o ={};

            for(var i=0; i<numbers.length; i++){

               if(numbers[i].id == 'update_busket_token') continue;

                var id = numbers[i].id;
                var val = numbers[i].value;
                o[id]=val;
                o[id+'_price']= numbers[i].getAttribute('data-price');
            }

            var _token= document.getElementById('update_busket_token').value;


            xhr = new XMLHttpRequest();
            xhr.open('POST', '/bigbusket/recount', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('items=' + JSON.stringify(o)+'&_token='+_token);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        //вставляемо в велику корзину
                        document.getElementsByClassName('modalwindow')[0].innerHTML = xhr.responseText;

//update small busket
                            xhr2 = new XMLHttpRequest();
                            xhr2.open('POST', '/bigbusket/updatesmallbusket', true);
                            xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr2.send('_token='+_token);
                            xhr2.onreadystatechange = function () {
                                if (xhr2.readyState == 4) {
                                    if (xhr2.status == 200) {
                                        //поновленнч малоъ корзини
                                        response= JSON.parse(xhr2.responseText);
                                        document.getElementById('total_number').innerText = response.number;
                                        document.getElementById('total_sum').innerText = response.sum;
                                    }
                                }
                            };
                           //end of the second request

                    }
                }
            };

        }


        //кликаем по хрестику закрыть корзину
        var busket_close = find_closest_heighest_id(e.target, 'busket_close');
        if(busket_close){
            var modalshadow= document.getElementsByClassName('modalshadow')[0];
            var modalwindow = document.getElementsByClassName('modalwindow')[0];
            modalshadow.parentNode.removeChild(modalshadow); // удаляем затемнение
           modalwindow.parentNode.removeChild(modalwindow);//удаляем корзину

        }


        var make_order = find_closest_heighest_id(e.target, 'make_order');
        if(make_order){
           // console.log(111);
            var orderform = document.createElement('div'); // слой затемнения
            orderform.className = 'orderform';
            document.body.appendChild(orderform);

            xhr= new XMLHttpRequest();
            xhr.open('POST', '/bigbusket/createOrderForm', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send();
            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4){
                    if(xhr.status == 200){
                        document.getElementsByClassName('orderform')[0].innerHTML = xhr.responseText;
                            }
                        }
                    };




            setTimeout(function(){orderform.classList.add('showform')},100);
        }


        //закрыаем форму заказа
        var order_close = find_closest_heighest_class(e.target, 'order_close');
        if(order_close){


            var success=document.getElementsByClassName('orderform')[0].querySelector('.success');

            if(success){
                var modalshadow= document.getElementsByClassName('modalshadow')[0];
                var modalwindow = document.getElementsByClassName('modalwindow')[0];

                modalwindow.parentNode.removeChild(modalwindow);//удаляем модальне викно
                setTimeout(function(){ modalshadow.parentNode.removeChild(modalshadow);}, 2000 );//удаляем затенненя
            }


            document.getElementsByClassName('orderform')[0].classList.add('hideform');
            setTimeout(function(){document.getElementsByClassName('orderform')[0].parentNode.removeChild(document.getElementsByClassName('orderform')[0])}, 2000)
        }
        //конец формы заказа


//нажтмаем форму заказа
        var send_order = find_closest_heighest_id(e.target, 'send_order');
        if(send_order){
            e.preventDefault();
           
            var form =new FormData(document.getElementById('send_order_form'));
          
            xhr= new XMLHttpRequest();
            xhr.open('POST', '/bigbusket/order', true);
            xhr.send(form);
            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4){
                    if(xhr.status == 200){
                        document.getElementsByClassName('orderform')[0].innerHTML = xhr.responseText;


                        //update small busket
                        var _token= document.getElementById('update_busket_token').value;
                        xhr2 = new XMLHttpRequest();
                        xhr2.open('POST', '/bigbusket/updatesmallbusket', true);
                        xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr2.send('_token='+_token);
                       
                        xhr2.onreadystatechange = function () {
                            if (xhr2.readyState == 4) {
                                if (xhr2.status == 200) {
                                    //поновленнч малоъ корзини
                                   
                                    response= JSON.parse(xhr2.responseText);
                                   
                                    document.getElementById('total_number').innerText = response.number;
                                    document.getElementById('total_sum').innerText = response.sum;
                                            }
                                        }
                                    };
                        //end of the second request

                    }
                }
            };

        }
        //конец отослать форму заказа

        var show_preview = find_closest_heighest_class(e.target, 'date_to_preview');
        if(show_preview){

            var id = show_preview.getAttribute('priorResultId');

            xhr = new XMLHttpRequest();
            xhr.open('POST', '/priorresult/getProduct', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('id='+id);
            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4){
                    if(xhr.status == 200){
                        var darkLayer = document.createElement('div'); // слой затемнения
                        darkLayer.className = 'modalshadow'; // class чтобы подхватить стиль
                        document.body.appendChild(darkLayer); // включаем затемнение

                        var modalwindow = document.createElement('section');
                        modalwindow.className = 'preview_product_window';
                        document.body.appendChild(modalwindow);
                        modalwindow.innerHTML = xhr.responseText;

                        darkLayer.onclick = function () {  // при клике на слой затемнения все исчезнет

                                darkLayer.parentNode.removeChild(darkLayer); // удаляем затемнение
                                modalwindow.parentNode.removeChild(modalwindow);

                        };



                    }
                }
            }

        }


        var comment = find_closest_heighest_id(e.target, 'submitComment');
        if(comment) {
           e.preventDefault();

            var formdata = new FormData(document.getElementById('send_comment'));
            var product_id= document.getElementById('add_item').getAttribute('data-item');
            var message = CKEDITOR.instances.message.getData();
            formdata.append('product_id', product_id);
            formdata.append('message', message);

            xhr = new XMLHttpRequest();
            xhr.open('POST', '/product/comment', true);
            xhr.send(formdata);
            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4){
                    if(xhr.status == 200){
                        document.getElementsByClassName('commentBlock')[0].innerHTML = xhr.responseText;
                      if(document.getElementById('message')) CKEDITOR.replace(document.getElementById('message'));
                    }
                }
            }

        }// commentend


        var radio_button = find_closest_heighest_id(e.target, "comments_order");
        if(radio_button){
            var value = document.querySelector('input[type="radio"]:checked').value;

            var id = radio_button.getAttribute('data-id');

            xhr = new XMLHttpRequest();
            xhr.open('POST', '/product/orderComment', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.send('id='+id+'&order='+value);
            xhr.onreadystatechange = function(){
                if(xhr.readyState == 4){
                    if(xhr.status == 200){
                        document.getElementById('ordered_comments').innerHTML = xhr.responseText;

                    }
                }
            }

        }








    };
//кфнець вішання на боді разной фігні
//************************************************888


if(document.getElementById('leftmenu')){

  document.getElementById('leftmenu').addEventListener('dblclick', function(e){
      var dblclick = find_closest_heighest_class(e.target, 'left-cat');
      if(dblclick) {
          var title = dblclick.getAttribute('data-title');
          window.location.href = "catalog?category="+title;
      }
  });

}



//click over touchbutton show/hide menu
document.getElementById('touch-button').addEventListener('click', function(){
    if(upmenu.classList.contains('active-uppermenu')){
        upmenu.classList.remove('active-uppermenu'); setTimeout(function(){upmenu.style.display="none"},1200)
    } else {
        upmenu.style.display = "block";
        setTimeout(upmenu.classList.add('active-uppermenu'), 500)
    }
});





//нажатие клавиши в строке поиска
document.getElementById('search').addEventListener('keyup', function(){

   if(this.value != '' ){
    if(!prior_result.classList.contains('founded')) { prior_result.classList.add('founded');}

        var val= this.value;

        xhr= new XMLHttpRequest();
        xhr.open('POST', '/priorresult/search', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('value='+val);
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
                if(xhr.status == 200){
                    prior_result.innerHTML = xhr.responseText;
                }
            }
        };

   } else{
       if(prior_result.classList.contains('founded')){prior_result.classList.remove('founded');}
   }
});





//кикаем клавишу купить на странице product/index
if(document.getElementById('add_item')) {
    document.getElementById('add_item').addEventListener('click', function () {
        var id = this.getAttribute('data-item');
        var _token = this.getAttribute('data-token');
        var the_price = document.getElementById('the_price').innerHTML;


        xhr = new XMLHttpRequest();
        xhr.open('POST', '/bigbusket/addintobusket', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('id=' + id + '&price=' + the_price+'&_token='+_token );
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    response= JSON.parse(xhr.responseText);
                    document.getElementById('total_number').innerText = response.number;
                    document.getElementById('total_sum').innerText = response.sum;
                }
            }
        }
    });
}

//кликаем по маленькой корзинке вверху чтобы получить большую корзину
document.getElementById('busket').addEventListener('click', function(){
    xhr = new XMLHttpRequest();
    xhr.open('POST', '/bigbusket', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('ajax='+true+'&launch_big_busket='+true);
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                var darkLayer = document.createElement('div'); // слой затемнения
                darkLayer.className = 'modalshadow'; // class чтобы подхватить стиль
                document.body.appendChild(darkLayer); // включаем затемнение

                var modalwindow = document.createElement('section');
                modalwindow.className = 'modalwindow';
                document.body.appendChild(modalwindow);
                modalwindow.innerHTML = xhr.responseText;

                darkLayer.onclick = function () {  // при клике на слой затемнения все исчезнет
                    if(!document.getElementsByClassName('orderform')[0]) {
                        darkLayer.parentNode.removeChild(darkLayer); // удаляем затемнение
                        modalwindow.parentNode.removeChild(modalwindow);
                    }
                    //return false;
                };

            }
        }
    }

});






if(document.getElementById('writeUs')){
    document.getElementById('writeUs').addEventListener('click', function(){
       //console.log(111);
        document.getElementsByClassName('map')[0].classList.add('narrow');
        setTimeout( function(){document.getElementsByClassName('map')[0].classList.add('invisible');
            document.getElementsByClassName('writeUsBlock')[0].classList.remove('invisible');
            document.getElementsByClassName('writeUsBlock')[0].classList.add('narrow');

        },2000);

        setTimeout(function(){
            document.getElementsByClassName('writeUsBlock')[0].classList.add('heigh');
        }, 2100)



    })
}

