function find_closest_table_tr(el){
    var elem = el;
    //console.log(elem);
    while (elem.tagName.toLowerCase()!= 'tr'){
        if(elem.tagName.toLowerCase() == 'html' || elem.tagName.toLowerCase() == 'th' ) return false;
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

function find_closest_heighest_class(el, cl){
    var elem = el;
    //console.log(elem);
    while (!elem.classList.contains( cl )){
        if(elem.tagName.toLowerCase() == 'html') return false;
        elem = elem.parentNode;
        if(!elem) return false;
    }
    return elem;
}

function output_message(message){

    var message_box= document.getElementById('message_box');
    message_box.className="";
    message_box.querySelector('span').innerHTML= message;


}




document.body.onclick = function(e){

    if(e.target.id== 'message_close') document.getElementById('message_box').className="invisible";

//dealing with popup menu
    var popup_menu= document.getElementById('popup_menu');

    if( popup_menu && popup_menu.className=='' && e.target.id != 'delete_item'){

        popup_menu.className="invisible";
    }

    var table =find_closest_table_tr(e.target);
    if(table && e.target.id != 'delete_item') {

        var main_content = document.getElementsByClassName('main-content')[0].getBoundingClientRect();
        var body = document.body.getBoundingClientRect();

        var border_right= Math.round(main_content.right);
        var body_bottom = Math.round(body.bottom);


        var item_id= table.querySelector('[data-id]').getAttribute('data-id');

        document.getElementById('rewiev_item').setAttribute('href', '/admin/product/show?id='+item_id);
        document.getElementById('update_item').setAttribute('href', '/admin/product/edit?id='+item_id);
        //   document.getElementById('delete_item').setAttribute('href', '/admin/product/delete?id='+item_id);
        document.getElementById('delete_item').setAttribute('data-delete_id', item_id);
        document.getElementById('delete_item').className="delete_item";


        popup_menu.className = "";

        var x = e.clientX;
        var y = e.clientY;


        if((x+101)>border_right) { x= (x-101)+(border_right-x); }


        if((y+71)>body_bottom){ y = (y-71)+(body_bottom-y);}

        popup_menu.style.left = x+"px";
        popup_menu.style.top = y+"px";



    }//конец клика по тейбл




    if(e.target.className == 'delete_item'){

         var confirmed = confirm("Do you really want delete the item?");
       // var confirmed = true;
        //start delet item
        if(confirmed) {

            var id = document.getElementById('delete_item').getAttribute('data-delete_id');
            var item_to_del = document.getElementsByClassName('articles_good')[0].querySelector('td[data-id="'+id+'"]').parentNode;

            xhr= new XMLHttpRequest();
            xhr.open('POST', '/admin/product/destroy', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        popup_menu.className="invisible";
                        item_to_del.parentNode.removeChild(item_to_del);
                        output_message('The item with id '+id+' is fully deleted!');
                    }
                }
            };
            xhr.send('id='+id);
        }//end of the deletion of an item
    }
    //console.log(e.target);




    var close_img= find_closest_heighest_class(e.target,'close_img');
    var dark_layer_close= find_closest_heighest_class(e.target,'darkLayer');

    if (close_img || dark_layer_close) {
        document.body.removeChild(document.getElementsByClassName('darkLayer')[0]);
        document.body.removeChild(document.getElementsByClassName('big_image')[0]);


    }

    //если кликнули по дереве категорий в админке
    if (e.target.classList.contains('admin_categories_item')) {

        var main_content = document.getElementsByClassName('main-content')[0].getBoundingClientRect();
        var body = document.body.getBoundingClientRect();

        var border_right= Math.round(main_content.right);
        var body_bottom = Math.round(body.bottom);




        var item_id = e.target.getAttribute('data-id');
       // console.log(item_id);

        document.getElementById('rewiev_item').setAttribute('href', '/admin/category/create');
        document.getElementById('rewiev_item').innerText='add category';
        document.getElementById('update_item').setAttribute('href', '/admin/category/edit?id='+item_id);
        document.getElementById('update_item').innerText='rename category';

        var delete_category = document.getElementById('delete_item');
        delete_category.setAttribute('data-delete_id', item_id);
        delete_category.className ="delete_category";


        popup_menu.className = "";

        var x = e.clientX;
        var y = e.clientY;


        if((x+101)>border_right) { x= (x-101)+(border_right-x); }


        if((y+71)>body_bottom){ y = (y-71)+(body_bottom-y);}

        popup_menu.style.left = x+"px";
        popup_menu.style.top = y+"px";

    }
//конец кликания подереву категорий в админке


//клиеаем удалить категорию
if(e.target.className == 'delete_category'){

         var confirmed = confirm("Do you really want delete the category?");
       // var confirmed = true;
        //start delet item
        if(confirmed) {

            var id = document.getElementById('delete_item').getAttribute('data-delete_id');
            var item_to_del = document.getElementsByClassName('admin_categories')[0].querySelector('span[data-id="'+id+'"]').parentNode;
            var _token = document.getElementById("delete_category_token").value;
            //console.log(_token);


            xhr= new XMLHttpRequest();
            xhr.open('POST', '/admin/category/destroy', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        popup_menu.className="invisible";
                        var response = JSON.parse(xhr.responseText);

                        if(response.error) {
                           document.getElementById('message_box').className = "";
                           document.getElementById('message_box').querySelector('span').innerText = response.error;
                             }

                         if(response.success){
                           document.getElementById('message_box').className = "";
                           document.getElementById('message_box').querySelector('span').innerText = response.success; 
                            item_to_del.parentNode.removeChild(item_to_del);
                         }
                    }
                }
            };
            xhr.send('id='+id+'&ajax=1'+'&_token='+_token);
        }
    }//конец удаления категорий


//кликаем по производителям
    if (e.target.classList.contains('admin_manufacturers_item')) {

        var main_content = document.getElementsByClassName('main-content')[0].getBoundingClientRect();
        var body = document.body.getBoundingClientRect();

        var border_right= Math.round(main_content.right);
        var body_bottom = Math.round(body.bottom);




        var item_id = e.target.getAttribute('data-id');

       // console.log(e.target);
       // console.log(item_id);

        document.getElementById('rewiev_item').setAttribute('href', '/admin/manufacturer/create');
        document.getElementById('rewiev_item').innerText='add manufacturer';
        document.getElementById('update_item').setAttribute('href', '/admin/manufacturer/edit?id='+item_id);
        document.getElementById('update_item').innerText='edit manufacturer';

        var delete_manufacturer = document.getElementById('delete_item');
        delete_manufacturer.setAttribute('manufacturer-delete_id', item_id);
        delete_manufacturer.className ="delete_manufacturer";


        popup_menu.className = "";

        var x = e.clientX;
        var y = e.clientY;


        if((x+101)>border_right) { x= (x-101)+(border_right-x); }


        if((y+71)>body_bottom){ y = (y-71)+(body_bottom-y);}

        popup_menu.style.left = x+"px";
        popup_menu.style.top = y+"px";
    }//конец кликания по производителям


    if(e.target.className == 'delete_manufacturer'){

        var confirmed = confirm("Do you really want delete the manufacturer?");
        // var confirmed = true;
        //start delet item
        if(confirmed) {

            var id = document.getElementById('delete_item').getAttribute('manufacturer-delete_id');
            var item_to_del = document.getElementsByClassName('admin_manufacturers')[0].querySelector('span[data-id="'+id+'"]').parentNode;
            var _token = document.getElementById("delete_manufacturer_token").value;
          // console.log(_token);
            //console.log(item_to_del);


            xhr= new XMLHttpRequest();
            xhr.open('POST', '/admin/manufacturer/destroy', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        popup_menu.className="invisible";
                        var response = JSON.parse(xhr.responseText);

                        if(response.error) {
                            document.getElementById('message_box').className = "";
                            document.getElementById('message_box').querySelector('span').innerText = response.error;
                        }

                        if(response.success){
                            document.getElementById('message_box').className = "";
                            document.getElementById('message_box').querySelector('span').innerText = response.success;
                            item_to_del.parentNode.removeChild(item_to_del);
                        }
                    }
                }
            };
            xhr.send('id='+id+'&ajax=1'+'&_token='+_token);
        }
    }//конец удаления категорий



};
