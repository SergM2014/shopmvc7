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

        var current= e.target.getAttribute('rel');



        var width=+1;

        for(var i=0; i<items.length; i++){

            var cloned_node= items[i].cloneNode(true);
            cloned_node.className='';

            var src= cloned_node.getAttribute('src');
             cloned_node.setAttribute('src','');
            var image = src.split('/');
            image= image[image.length-1];



            if(cloned_node.getAttribute('rel') == current){
                current = cloned_node;
            }

            var img= document.createElement('div');
            img.className="gallery_img";
            img.id= (i+1);
            cloned_node.setAttribute('src','/uploads/product_images/'+image);

            img.appendChild(cloned_node);

           // width+=document.documentElement.clientWidth+50;
            img.style.width= window.innerWidth+'px';
            gallery_box.appendChild(img);
           // gallery_box.style.width= width+'px';

        }

        current.parentNode.classList.add('current');

        var current_id = current.parentNode.id;
        if(current_id == 1){
            document.getElementsByClassName('left_arrow')[0].classList.add('invisible');
        }
        if(current_id == length){
            document.getElementsByClassName('right_arrow')[0].classList.add('invisible');
        }

        document.getElementsByClassName('wrapper')[0].classList.add('invisible');


    }


    if (e.target.parentNode.className=="close_gallery"){
        document.body.removeChild(document.getElementsByClassName('back_gallery')[0]);
        document.getElementsByClassName('wrapper')[0].classList.remove('invisible');
    }
//конец вывода слайдера на екран



    if(e.target.getAttribute('rel')=="right") {

        document.getElementsByClassName('left_arrow')[0].classList.remove('invisible');
        var current = document.getElementsByClassName('current')[0];
        var id = Number(current.id);
        if(id == (length-1)) {
            document.getElementsByClassName('right_arrow')[0].classList.add('invisible');
        }

        var new_id=id+1;
        current.classList.remove('current')
        var next = document.getElementById(new_id);
        next.classList.add('current');
    }


    if(e.target.getAttribute('rel')=="left") {

        document.getElementsByClassName('right_arrow')[0].classList.remove('invisible');
        var current = document.getElementsByClassName('current')[0];
        var id = Number(current.id);
        if(id<3)  document.getElementsByClassName('left_arrow')[0].classList.add('invisible');

        var new_id=id-1;

        if(new_id<1) return;

        current.classList.remove('current')
        var previous = document.getElementById(new_id);
        previous.classList.add('current');
    }

});

