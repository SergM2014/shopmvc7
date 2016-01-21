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

        //document.getElementById('output_'+global_id).innerHTML = 'Upload failed';
        image_area.querySelector('.output').innerHTML = 'Upload failed';
    }


    function abortHandler(event) {

      //document.getElementById('output_'+global_id).innerHTML = 'Upload aborted';
        image_area.querySelector('.output').innerHTML = 'Upload aborted';
    }



    var submit_btn = find_closest_heighest_class(e.target, 'submit_btn');
   if(submit_btn){


        image_area= find_closest_heighest_class(e.target, 'image_area');
        var id= image_area.id;


       image_area.querySelector('.progress').classList.remove('invisible');

       var file= image_area.querySelector('.FileInput').files[0];
       var formdata = new FormData();

       formdata.append("FileInput", file);
       formdata.append("id", id);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "/admin/image/upload");
            ajax.send(formdata);

       image_area.querySelector('.reset_btn').setAttribute('disabled', 'disabled');

    }


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




    var reset_btn = find_closest_heighest_class(e.target, 'reset_btn');
    if(reset_btn){

        var image_area= find_closest_heighest_class(e.target, 'image_area');
        var id= image_area.id;


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
            xhr2.send('id='+id+'&name='+name);

        image_area.querySelector('.submit_btn').classList.add('invisible');
        image_area.querySelector('.reset_btn').classList.add('invisible');

        };





}