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

var popup_menu= document.getElementById('popup_menu');

var popup_menu_object = {
    get_x: function(e){
        var main_content = document.getElementsByClassName('main-content')[0].getBoundingClientRect();
        var border_right= Math.round(main_content.right);
        var x = e.pageX;
        if((x+101)>border_right) { x= (x-101)+(border_right-x); }

        return x;
    },

    get_y: function(e){
        var body_bottom = Math.round(window.scrollY + window.innerHeight);

        var y = e.pageY;
        if((y+71)>body_bottom){ y = (y-71)+(body_bottom-y);}

        return y;
    },

    z_index: function(){
        return 100;
    },

    item_id: function(attr, elem){
        return elem.getAttribute(attr)
    },

    show: function(allias, elem, e){

        var item_id = this.item_id('data-'+allias+'_id', elem);
        document.getElementById('rewiev_item').setAttribute('href', '/admin/'+allias+'/create');
        document.getElementById('rewiev_item').innerText='add '+allias;
        document.getElementById('update_item').setAttribute('href', '/admin/'+allias+'/edit?id='+item_id);
        document.getElementById('update_item').innerText='edit '+allias;

        var delete_item = document.getElementById('delete_item');
        delete_item.setAttribute('data-'+allias+'_delete_id', item_id);
        delete_item.className ='delete_'+allias+'';

        popup_menu.className = "";

        popup_menu.style.left = this.get_x(e)+"px";
        popup_menu.style.top = this.get_y(e)+"px";
        popup_menu.style.zIndex = this.z_index();
    }

};


document.body.onclick = function(e){

    if(e.target.id== 'message_close') document.getElementById('message_box').className="invisible";

//dealing with popup menu


    if( popup_menu && popup_menu.className=='' && e.target.id != 'delete_item'){

        popup_menu.className="invisible";
    }

    var table =find_closest_table_tr(e.target);

    if(table && e.target.id != 'delete_item') {
        if(table.hasAttribute('data-product_id')) {
            popup_menu_object.show('product', table, e);
             }
        if(table.hasAttribute('data-comment_id')) {
            popup_menu_object.show('comment', table, e);
            document.getElementById('rewiev_item').removeAttribute('href');

            var published_status = table.querySelector('.published_status').classList.contains('published');

            if (published_status) {
                document.getElementById('rewiev_item').removeAttribute('comment_publish_id');
                document.getElementById('rewiev_item').setAttribute('comment_unpublish_id', popup_menu_object.item_id('data-comment_id', table));
                document.getElementById('rewiev_item').innerText = 'unpublish comment';
            }

            if (!published_status) {
                document.getElementById('rewiev_item').removeAttribute('comment_unpublish_id');
                document.getElementById('rewiev_item').setAttribute('comment_publish_id', popup_menu_object.item_id('data-comment_id', table));
                document.getElementById('rewiev_item').innerText = 'publish comment';
            }

            }
        }



//console.log(e.target.className);

    if(e.target.className == 'delete_product'){

         var confirmed = confirm("Do you really want delete the item?");
       // var confirmed = true;
        //start delet item
        if(confirmed) {

            var id = document.getElementById('delete_item').getAttribute('data-product_delete_id');
//console.log(id);
            var item_to_del = document.getElementsByClassName('articles_good')[0].querySelector('tr[data-product_id="'+id+'"]');

//console.log(item_to_del);

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



    var close_img= find_closest_heighest_class(e.target,'close_img');
    var dark_layer_close= find_closest_heighest_class(e.target,'darkLayer');

    if (close_img || dark_layer_close) {
        document.body.removeChild(document.getElementsByClassName('darkLayer')[0]);
        document.body.removeChild(document.getElementsByClassName('big_image')[0]);
    }





    //если кликнули по дереве категорий в админке
    if (e.target.classList.contains('admin_categories_item')) {

        var category = e.target;

        popup_menu_object.show('category', category, e);

    }
//конец кликания подереву категорий в админке


//клиеаем удалить категорию
if(e.target.className == 'delete_category'){

         var confirmed = confirm("Do you really want delete the category?");
       // var confirmed = true;
        //start delet item
        if(confirmed) {

            var id = document.getElementById('delete_item').getAttribute('data-category_delete_id');
//console.log(id);
            var item_to_del = document.getElementsByClassName('admin_categories')[0].querySelector('span[data-category_id="'+id+'"]');
//console.log(item_to_del); return
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

        manufacturer= e.target;

        popup_menu_object.show('manufacturer', manufacturer, e);

    }//конец кликания по производителям


    if(e.target.className == 'delete_manufacturer'){

        var confirmed = confirm("Do you really want delete the manufacturer?");
        // var confirmed = true;
        //start delet item
        if(confirmed) {

            var id = document.getElementById('delete_item').getAttribute('data-manufacturer_delete_id');
            var item_to_del = document.getElementsByClassName('admin_manufacturers')[0].querySelector('span[data-manufacturer_id="'+id+'"]');
            var _token = document.getElementById("delete_manufacturer_token").value;



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



    if(e.target.className == 'delete_comment'){

        var confirmed = confirm("Do you really want delete the comment?");
        // var confirmed = true;
        //start delet item
        if(confirmed) {

            var id = document.getElementById('delete_item').getAttribute('data-comment_delete_id');
            var item_to_del = document.getElementsByClassName('comments_area')[0].querySelector('tr[data-comment_id="'+id+'"]');
            var _token = document.getElementsByName("_token")[0].value;



            xhr= new XMLHttpRequest();
            xhr.open('POST', '/admin/comment/destroy', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        popup_menu.className="invisible";
                        var response = JSON.parse(xhr.responseText);
                       // console.log(response);

                        if(response.error) {
                            document.getElementById('message_box').className = "";
                            document.getElementById('message_box').querySelector('span').innerText = response.error;
                        }

                        if(response.success){
                            document.getElementById('message_box').className = "";
                            document.getElementById('message_box').querySelector('span').innerText = response.message;
                            item_to_del.parentNode.removeChild(item_to_del);
                        }
                    }
                }
            };
            xhr.send('id='+id+'&ajax=1&_token='+_token);
        }
    }//конец удаления категорий

//нажимаем на unpublish comment
    if(e.target.hasAttribute('comment_unpublish_id')){


        var id = e.target.getAttribute('comment_unpublish_id');
        e.target.removeAttribute('comment_unpublish_id');
        var item_to_unpublish = document.getElementsByClassName('comments_area')[0].querySelector('tr[data-comment_id="'+id+'"]').querySelector('.published_status');
        var _token = document.getElementsByName("_token")[0].value;


        xhr= new XMLHttpRequest();
        xhr.open('POST', '/admin/comment/unpublish', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    popup_menu.className="invisible";
                    var response = JSON.parse(xhr.responseText);
                    // console.log(response);

                    if(response.error) {
                        document.getElementById('message_box').className = "";
                        document.getElementById('message_box').querySelector('span').innerText = response.error;
                    }

                    if(response.success){
                        document.getElementById('message_box').className = "";
                        document.getElementById('message_box').querySelector('span').innerText = response.message;
                        item_to_unpublish.innerText="NO";
                        item_to_unpublish.classList.remove('published');
                        item_to_unpublish.classList.add('unpublished');
                    }
                }
            }
        };
        xhr.send('id='+id+'&ajax=1&_token='+_token);

    }

    //нажимаем на publish comment
    if(e.target.hasAttribute('comment_publish_id')){


        var id = e.target.getAttribute('comment_publish_id');
        e.target.removeAttribute('comment_publish_id');
        var item_to_publish = document.getElementsByClassName('comments_area')[0].querySelector('tr[data-comment_id="'+id+'"]').querySelector('.published_status');
        var _token = document.getElementsByName("_token")[0].value;

        xhr= new XMLHttpRequest();
        xhr.open('POST', '/admin/comment/publish', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    popup_menu.className="invisible";
                    var response = JSON.parse(xhr.responseText);
                    // console.log(response);

                    if(response.error) {
                        document.getElementById('message_box').className = "";
                        document.getElementById('message_box').querySelector('span').innerText = response.error;
                    }

                    if(response.success){
                        document.getElementById('message_box').className = "";
                        document.getElementById('message_box').querySelector('span').innerText = response.message;
                        item_to_publish.innerText="YES";
                        item_to_publish.classList.remove('unpublished');
                        item_to_publish.classList.add('published')
                    }
                }
            }
        };
        xhr.send('id='+id+'&ajax=1&_token='+_token);

    }


    var slider =find_closest_heighest_class(e.target, 'slider');
    if(slider){

        popup_menu_object.show('slider', slider, e);

    }

    if(e.target.className == 'delete_slider'){

        var confirmed = confirm("Do you really want delete the slider?");
        // var confirmed = true;
        //start delet item
        if(confirmed) {
            var id = document.getElementById('delete_item').getAttribute('data-slider_delete_id');
            var item_to_del = document.getElementsByClassName('main-content')[0].querySelector('article[data-slider_id="'+id+'"]');
            var _token = document.getElementsByName("_token")[0].value;
            //console.log(item_to_del);

            xhr= new XMLHttpRequest();
            xhr.open('POST', '/admin/slider/destroy', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        popup_menu.className="invisible";
                        var response = JSON.parse(xhr.responseText);
                        // console.log(response);

                        if(response.error) {
                            document.getElementById('message_box').className = "";
                            document.getElementById('message_box').querySelector('span').innerText = response.error;
                        }

                        if(response.success){
                            document.getElementById('message_box').className = "";
                            document.getElementById('message_box').querySelector('span').innerText = response.message;
                            item_to_del.parentNode.removeChild(item_to_del);
                        }
                    }
                }
            };
            xhr.send('id='+id+'&ajax=1&_token='+_token);


        }
    }


};


