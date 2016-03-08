var image_preview = document.getElementsByClassName('thumb')[0], output= document.getElementsByClassName('output')[0],
    reset_btn= document.getElementsByClassName('reset_btn')[0], submit_btn = document.getElementsByClassName('submit_btn')[0],
    progress_bar= document.getElementsByClassName('progress_bar')[0], progress=document.getElementsByClassName('progress')[0];
//File API

    var file_input = document.getElementById('file_input');

    file_input.onchange = function(){
        var input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    image_preview.setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                this.classList.add('invisible');
                output.classList.add('invisible');
                reset_btn.classList.remove('invisible');
                submit_btn.classList.remove('invisible');

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function file_input on change
//end of File API



    function progressHandler(event) {

        var percent = Math.round((event.loaded / event.total) * 100);

        progress_bar.style.width = percent + "%";
        progress_bar.innerHTML = percent + "%";
    }

    function completeHandler(event) {//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

        var response = JSON.parse(event.target.responseText);

        output.innerHTML= response.message;

        progress_bar.style.width = "0%";
        progress_bar.innerHTML = "0%";

        progress.classList.add('invisible');

        output.classList.remove('invisible');

        submit_btn.classList.add('invisible');

        reset_btn.removeAttribute('disabled');




    }// the end of image load


    function errorHandler(event) {

        output.innerHTML = 'Upload failed';
    }


    function abortHandler(event) {

       output.innerHTML = 'Upload aborted';
    }


     submit_btn.addEventListener('click',  function(){
         submit_btn.classList.add('invisible');

         progress.classList.remove('invisible');

         var file= file_input.files[0];

         var id = document.getElementsByName('id')[0].value;
         var _token = document.getElementsByName(['_token'])[0].value;
        /* console.log(_token);
         return;*/

         var formdata = new FormData();

         formdata.append("FileInput", file);
         formdata.append("id", id);
         formdata.append("_token", _token);
         formdata.append("ajax", true);

         var ajax = new XMLHttpRequest();
         ajax.upload.addEventListener("progress", progressHandler, false);
         ajax.addEventListener("load", completeHandler, false);
         ajax.addEventListener("error", errorHandler, false);
         ajax.addEventListener("abort", abortHandler, false);
         ajax.open("POST", "/admin/image/updateAvatar");
         ajax.send(formdata);

         reset_btn.setAttribute('disabled', 'disabled');
     });



    reset_btn.addEventListener('click', function(){

       image_preview.setAttribute('src', '/img/nophoto.jpg');

        var id = document.getElementsByName('id')[0].value;
        var _token = document.getElementsByName(['_token'])[0].value;

        if(file_input.classList.contains('invisible')) file_input.classList.remove('invisible');

        xhr2 = new XMLHttpRequest();
        xhr2.open('POST', '/admin/image/deleteAvatar', true);
        xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState == 4) {
                if (xhr2.status == 200) {
                    //document.getElementById('output').innerHTML = xhr2.responseText;
                    var response = JSON.parse(xhr2.responseText);
                    output.innerText = response.message;
                }
            }
        };
        xhr2.send('id='+id+'&_token='+_token+'&ajax='+1);

        submit_btn.classList.add('invisible');
        reset_btn.classList.add('invisible');


    });
