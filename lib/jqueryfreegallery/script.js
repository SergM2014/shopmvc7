function remove_arrow(arrow){
    document.getElementsByClassName(arrow)[0].classList.add('invisible');

}



document.body.addEventListener('click', function(e){



    var items = document.getElementsByClassName('images_preview_area')[0].querySelectorAll('.preview_image');
    var length= items.length;
//console.log(e.target);
    if(e.target.className == 'preview_image'){

        var back_gallery_div = document.createElement('div');
        back_gallery_div.className = "back_gallery";
        var gallery_box = document.createElement('div');
        gallery_box.className="gallery_box";

        var left_arrow = document.createElement('div');
        left_arrow.className="left_arrow arrow";
        left_arrow.innerHTML='<img src="/lib/jqueryfreegallery/img/left.png" rel="left" >';

        var right_arrow = document.createElement('div');
        right_arrow.className= "right_arrow arrow";
        right_arrow.innerHTML='<img src="/lib/jqueryfreegallery/img/right.png" rel="right">';

        var close = document.createElement('div');
        close.className="close_gallery";
        close.innerHTML='<img src="/lib/jqueryfreegallery/img/close.png">';



        back_gallery_div.appendChild(gallery_box);

        back_gallery_div.appendChild(close);

        back_gallery_div.appendChild(left_arrow);
        back_gallery_div.appendChild(right_arrow);

        document.body.insertBefore(back_gallery_div, document.body.firstChild);

        var current= e.target.getAttribute('src');
//console.log(current);

       // var items = document.getElementsByClassName('images_preview_area')[0].querySelectorAll('.preview_image');


//console.log(items);
        var width=+1;


        for(var i=0; i<items.length; i++){

            var new_node= items[i].cloneNode(true);
            new_node.className='';

            if(new_node.getAttribute('src') == current){
                current = new_node;
            }

            var img= document.createElement('div');
            img.className="gallery_img";
            img.id= (i+1);

            img.appendChild(new_node);
//console.log(document.documentElement.clientWidth);
            width+=document.documentElement.clientWidth+50;
            img.style.width= window.innerWidth+'px';
            gallery_box.appendChild(img);
            gallery_box.style.width= width+'px';

        }
//console.log(items)
        current.parentNode.classList.add('current');


        document.getElementsByClassName('wrapper')[0].classList.add('invisible');


    }


    if (e.target.parentNode.className=="close_gallery"){
        document.body.removeChild(document.getElementsByClassName('back_gallery')[0]);
        document.getElementsByClassName('wrapper')[0].classList.remove('invisible');
    }
//конец вывода слайдера на екран



    if(e.target.getAttribute('rel')=="right") {

        document.getElementsByClassName('left_arrow')[0].classList.remove('invisible');
//console.log(length)
        var current = document.getElementsByClassName('current')[0];
        var id = Number(current.id);
        if(id == (length-1)) {
            document.getElementsByClassName('right_arrow')[0].classList.add('invisible');
        }
//console.log(id);
        var new_id=id+1;
//console.log(new_id);
        current.classList.remove('current')
        var next = document.getElementById(new_id);
        next.classList.add('current');
    }


    if(e.target.getAttribute('rel')=="left") {

        document.getElementsByClassName('right_arrow')[0].classList.remove('invisible');
        var current = document.getElementsByClassName('current')[0];
        var id = Number(current.id);
        if(id<3)  document.getElementsByClassName('left_arrow')[0].classList.add('invisible');
//console.log(id);
        var new_id=id-1;
console.log(new_id);
        if(new_id<1) return;
//console.log(new_id);
        current.classList.remove('current')
        var previous = document.getElementById(new_id);
        previous.classList.add('current');
    }

});

