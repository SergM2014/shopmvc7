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

document.getElementsByClassName('main-content')[0].onclick = function(e) {
    var table =find_closest_table_tr(e.target);
    if(table) {
        var x = e.offsetX == undefined ? e.layerX : e.offsetX;
        var y = e.offsetY == undefined ? e.layerY : e.offsetY;
        //alert(x + 'x' + y);

        var popup_menu= document.createElement('div');

        popup_menu.className= "popup";
        popup_menu.style.left= x;
        popup_menu.style.top= y;


      document.getElementsByClassName('articles_good')[0].appendChild(popup_menu);



    }//конец клика по тейбл
}