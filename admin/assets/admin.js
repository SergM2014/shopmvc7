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
//var width = document.body.clientWidth;
//    console.log(width);
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


        popup_menu.className = "";

        var x = e.clientX;
        var y = e.clientY;


        if((x+101)>border_right) { x= (x-101)+(border_right-x); }


        if((y+71)>body_bottom){ y = (y-71)+(body_bottom-y);}

        popup_menu.style.left = x+"px";
        popup_menu.style.top = y+"px";



    }//конец клика по тейбл

    if(e.target.id == 'delete_item'){

        // var confirmed = confirm("Do you really want delete the item?");
        var confirmed = true;
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


};
