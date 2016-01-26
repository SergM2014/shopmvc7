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

function find_closest_heighest_id(el, id){
    var elem = el;

    while( elem.id != id){

        if(elem.tagName.toLowerCase() == 'html') return false;
        elem = elem.parentNode;
        if(!elem) return false;
    }
    return elem;
}

//вешаем на область где есть где есть изображения
document.getElementsByClassName('edit_images')[0].onclick = function (e) {

//File API
    var file_input = find_closest_heighest_class(e.target, 'FileInput');

    file_input.onchange = function(){
        var input = this;
        var image_area= find_closest_heighest_class(e.target, 'image_area');


        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    image_area.querySelector('.thumb').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                this.classList.add('invisible');
                image_area.querySelector('.output').classList.add('invisible');
                image_area.querySelector('.reset_btn').classList.remove('invisible');
                image_area.querySelector('.submit_btn').classList.remove('invisible');

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function file_input on change
//end of File API



    function progressHandler(event) {

        var percent = Math.round((event.loaded / event.total) * 100);

        image_area.querySelector('.progress-bar').style.width = percent + "%";
        image_area.querySelector('.progress-bar').innerHTML = percent + "%";
    }

    function completeHandler(event) {//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

        var response = JSON.parse(event.target.responseText);

        image_area.querySelector('.output').innerHTML= response.message;

        image_area.querySelector('.progress-bar').style.width = "0%";
        image_area.querySelector('.progress-bar').innerHTML = "0%";

        image_area.querySelector('.progress').classList.add('invisible');

        image_area.querySelector('.output').classList.remove('invisible');
        image_area.querySelector('.success_tick').classList.remove('invisible');

        image_area.querySelector('.submit_btn').classList.add('invisible');

        image_area.querySelector('.reset_btn').removeAttribute('disabled');
        image_area.querySelector('h4').classList.add('invisible');
        image_area.querySelector('.thumb').classList.add('uploaded');
        delete  image_area;

        var node = document.createElement('div');
        var time = Math.floor((new Date()).getTime() / 1000);
        var randomNum = Math.round((Math.random() * (1000 - 1) + 1));
        var id= time+'_'+randomNum;

        node.id= id;
        node.className='image_area';
       var add_image = document.getElementsByClassName('edit_images')[0].appendChild(node);
        //console.log(node2);
        xhr2 = new XMLHttpRequest();
        xhr2.open('POST', '/admin/image/addsection', true);
        xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState == 4) {
                if (xhr2.status == 200) {
                    add_image.innerHTML = xhr2.responseText;
                }
            }
        };
        xhr2.send();


    }// the end of image load


    function errorHandler(event) {

        image_area.querySelector('.output').innerHTML = 'Upload failed';
    }


    function abortHandler(event) {

        image_area.querySelector('.output').innerHTML = 'Upload aborted';
    }



    var submit_btn = find_closest_heighest_class(e.target, 'submit_btn');
   if(submit_btn){
        submit_btn.classList.add('invisible');

        image_area= find_closest_heighest_class(e.target, 'image_area');
        var id= image_area.id;

       var _token= document.getElementById('update_product_token').value;



       image_area.querySelector('.progress').classList.remove('invisible');

       var file= image_area.querySelector('.FileInput').files[0];
       var formdata = new FormData();

       formdata.append("FileInput", file);
       formdata.append("id", id);
       formdata.append("_token", _token);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "/admin/image/upload");
            ajax.send(formdata);

       image_area.querySelector('.reset_btn').setAttribute('disabled', 'disabled');

    }



    var reset_btn = find_closest_heighest_class(e.target, 'reset_btn');
    if(reset_btn){

        var image_area= find_closest_heighest_class(e.target, 'image_area');
        var id= image_area.id;

        var _token= document.getElementById('update_product_token').value;

        image_area.querySelector('.thumb').setAttribute('src', '/img/nophoto.jpg');
        var file_input = image_area.querySelector('.FileInput');

        if(file_input.classList.contains('invisible')) file_input.classList.remove('invisible');

            xhr2 = new XMLHttpRequest();
            xhr2.open('POST', '/admin/image/delete', true);
            xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr2.onreadystatechange = function () {
                if (xhr2.readyState == 4) {
                    if (xhr2.status == 200) {

                        image_area.querySelector('.output').innerHTML = xhr2.responseText;
                        image_area.querySelector('.success_tick').classList.add('invisible');

                        var images = document.getElementsByClassName('edit_images')[0].querySelectorAll('.image_area');

                        if(images.length>1){
                            image_area.parentNode.removeChild(image_area)
                        }

                    }
                }
            };
            xhr2.send('id='+id+'&name='+name+'&_token='+_token);

        image_area.querySelector('.submit_btn').classList.add('invisible');
        image_area.querySelector('.reset_btn').classList.add('invisible');
        image_area.querySelector('h4').classList.remove('invisible');
        image_area.querySelector('.thumb').classList.remove('uploaded');

        };

    var image_uploaded = find_closest_heighest_class(e.target, 'uploaded');
    if(image_uploaded) {


        var darkLayer = document.createElement('div');
        darkLayer.className='darkLayer';
        document.body.appendChild(darkLayer);



        var src=image_uploaded.src;
        src= src.replace('thumbs/', '');
        var image= document.createElement('img');
        image.setAttribute('src',src);

        var close =document.createElement('img');
        close.setAttribute('src','/img/close.png');
        close.className="close_img";


        var big_image =document.createElement('div');
        big_image.className="big_image";

        big_image.appendChild(image);
        big_image.appendChild(close);


        document.body.appendChild(big_image);

    };


}

document.body.onclick = function (e) {

    var close_img= find_closest_heighest_class(e.target,'close_img');
    var dark_layer_close= find_closest_heighest_class(e.target,'darkLayer');

    if (close_img || dark_layer_close) {
        document.body.removeChild(document.getElementsByClassName('darkLayer')[0]);
        document.body.removeChild(document.getElementsByClassName('big_image')[0]);


    }
};