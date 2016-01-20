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
        document.getElementById('progress_'+global_id).style.width = percent + "%";
        document.getElementById('progress_'+global_id).innerHTML = percent + "%";
    }

    function completeHandler(event) {//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

        var response = JSON.parse(event.target.responseText);
        document.getElementById('output_'+global_id).innerHTML= response.message;

        var images_area = find_closest_heighest_class(e.target, 'images_area');

        images_area.setAttribute('data-name', response.name);



        document.getElementById('progress_'+global_id).style.width = "0%";
        document.getElementById('progress_'+global_id).innerHTML = "0%";

        document.getElementById('progress_'+global_id).classList.add('invisible');

        document.getElementById('output_'+global_id).classList.remove('invisible');
        document.getElementById('success_tick_'+global_id).classList.remove('invisible');

        document.getElementById('submit_btn_'+global_id).classList.add('invisible');

        document.getElementById('reset_btn_'+global_id).removeAttribute('disabled');
        delete  global_id;

        var node = document.createElement('div');
        node.className='images_area';
       var node2 = document.getElementsByClassName('edit_images')[0].appendChild(node);
        //console.log(node2);
        xhr2 = new XMLHttpRequest();
        xhr2.open('POST', '/admin/image/addsection', true);
        xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState == 4) {
                if (xhr2.status == 200) {
                    node2.innerHTML = xhr2.responseText;
                }
            }
        };
        xhr2.send();


    }// the end of image load


    function errorHandler(event) {

        document.getElementById('output_'+global_id).innerHTML = 'Upload failed';
    }


    function abortHandler(event) {

      document.getElementById('output_'+global_id).innerHTML = 'Upload aborted';
    }

    var submit_btn = find_closest_heighest_class(e.target, 'submit_btn');
   if(submit_btn){


       var id= submit_btn.id;
       var arr = id.split('_');
       global_id= arr[arr.length-1];
     // console.log(id)
       document.getElementById('progress_'+global_id).classList.remove('invisible');
       var file = document.getElementById("FileInput_"+global_id).files[0];
       var formdata = new FormData();

       formdata.append("FileInput_"+global_id, file);
       formdata.append("id", global_id);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "/admin/image/upload");
            ajax.send(formdata);



       document.getElementById('reset_btn_'+global_id).setAttribute('disabled', 'disabled');

    }


    var file_input = find_closest_heighest_class(e.target, 'FileInput');

    file_input.onchange = function(){
        var id= file_input.getAttribute('data-id');
        var input = this;
 //       console.log(1212);

            if (input.files && input.files[0]) {
                if (input.files[0].type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                     document.getElementById('image_preview_'+id).setAttribute('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);

                    this.classList.add('invisible');
                    document.getElementById('output_'+id).classList.add('invisible');
                    document.getElementById('reset_btn_'+id).classList.remove('invisible');
                    document.getElementById('submit_btn_'+id).classList.remove('invisible');

                }// else console.log('is not image mime type');
            }// else console.log('not isset files data or files API not supordet');

        };//end of function


    var reset_btn = find_closest_heighest_class(e.target, 'reset_btn');
    if(reset_btn){

            e.preventDefault();
            var id= reset_btn.id;
            var arr = id.split('_');
            id= arr[arr.length-1];

        var image_name= find_closest_heighest_class(e.target, 'images_area');
        var name= image_name.getAttribute('data-name');
       // console.log(name);

            document.getElementById('image_preview_'+id).setAttribute('src', '/img/nophoto.jpg');
            document.getElementById('FileInput_'+id).classList.remove('invisible');

            xhr2 = new XMLHttpRequest();
            xhr2.open('POST', '/admin/image/delete', true);
            xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr2.onreadystatechange = function () {
                if (xhr2.readyState == 4) {
                    if (xhr2.status == 200) {
                       // document.getElementById('output_'+id).innerHTML = xhr2.responseText;
                        var images = document.getElementsByClassName('edit_images')[0].querySelectorAll('.images_area');
                        //избегаем удаления если область добавления изображений вего лишь одна
                        if(images.length>1) {
                            var images_area = find_closest_heighest_class(e.target, 'images_area');
                            // console.log(images_area);
                            images_area.parentNode.removeChild(images_area);
                        }
                    }
                }
            };
            xhr2.send('id='+id+'&name='+name);

        document.getElementById('submit_btn_'+id).classList.add('invisible');
       document.getElementById('reset_btn_'+id).classList.add('invisible');

        };





}