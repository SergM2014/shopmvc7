
//File API

    var file_input = document.getElementById('file_input');

    file_input.onchange = function(){
        var input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('image_preview').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                this.classList.add('invisible');
                document.getElementById('output').classList.add('invisible');
                document.getElementById('image_reset_btn').classList.remove('invisible');
                document.getElementById('submit_btn').classList.remove('invisible');

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function file_input on change
//end of File API



    function progressHandler(event) {

        var percent = Math.round((event.loaded / event.total) * 100);

        document.getElementById('progress_bar').style.width = percent + "%";
        document.getElementById('progress_bar').innerHTML = percent + "%";
    }

    function completeHandler(event) {//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

        var response = JSON.parse(event.target.responseText);

        document.getElementById('output').innerHTML= response.message;

        document.getElementById('progress_bar').style.width = "0%";
        document.getElementById('progress_bar').innerHTML = "0%";

        document.getElementById('progress').classList.add('invisible');

        document.getElementById('output').classList.remove('invisible');

        document.getElementById('submit_btn').classList.add('invisible');

        document.getElementById('image_reset_btn').removeAttribute('disabled');




    }// the end of image load


    function errorHandler(event) {

        document.getelementById('output').innerHTML = 'Upload failed';
    }


    function abortHandler(event) {

        document.getelementById('output').innerHTML = 'Upload aborted';
    }


     document.getElementById('submit_btn').addEventListener('click',  function(){
         document.getElementById('submit_btn').classList.add('invisible');

         document.getElementById('progress').classList.remove('invisible');

         var file= document.getElementById('file_input').files[0];

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

         document.getElementById('image_reset_btn').setAttribute('disabled', 'disabled');
     });



    document.getElementById('image_reset_btn').addEventListener('click', function(){

        document.getElementById('image_preview').setAttribute('src', '/img/nophoto.jpg');
        var file_input = document.getElementById('file_input');
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
                    document.getElementById('output').innerText = response.message;
                }
            }
        };
        xhr2.send('id='+id+'&_token='+_token+'&ajax='+1);

        document.getElementById('submit_btn').classList.add('invisible');
        document.getElementById('image_reset_btn').classList.add('invisible');


    });
