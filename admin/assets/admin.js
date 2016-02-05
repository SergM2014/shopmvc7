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



document.body.onclick = function(e){


    var popup_menu= document.getElementById('popup_menu');

    if(popup_menu.className==''){

        popup_menu.className="invisible";
    }

    var table =find_closest_table_tr(e.target);
    if(table) {

        var main_content = document.getElementsByClassName('main-content')[0].getBoundingClientRect();
        var body = document.body.getBoundingClientRect();

        var border_right= Math.round(main_content.right);
        var body_bottom = Math.round(body.bottom);


        var item_id= table.querySelector('[data-id]').getAttribute('data-id');

        document.getElementById('rewiev_item').setAttribute('href', '/admin/product/review?id='+item_id);
        document.getElementById('update_item').setAttribute('href', '/admin/product/update?id='+item_id);
        document.getElementById('delete_item').setAttribute('href', '/admin/product/delete?id='+item_id);

        popup_menu.className = "";

        var x = e.clientX;
        var y = e.clientY;


        if((x+101)>border_right) { x= (x-101)+(border_right-x); }
        /*console.log(border_right);
        console.log(x);*/

        if((y+71)>body_bottom){ y = (y-71)+(body_bottom-y);}

        popup_menu.style.left = x+"px";
        popup_menu.style.top = y+"px";

   }//конец клика по тейбл
};

