var file_input = document.getElementById('file_input'), submit_btn = document.getElementsByClassName('submit_btn')[0],
    reset_btn = document.getElementsByClassName('reset_btn')[0], output = document.getElementsByClassName('output')[0],
    progress_bar = document.getElementsByClassName('progress_bar')[0], progress = document.getElementsByClassName('progress')[0],
    success = document.getElementsByClassName('success_tick')[0],img_preview = document.getElementById('image_preview');

file_input.onchange = function(){
    var input = this;



    if (input.files && input.files[0]) {
        if (input.files[0].type.match('image.*')) {
            var reader = new FileReader();
            reader.onload = function (e) {

                img_preview.setAttribute('src', e.target.result);
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
    success.classList.remove('invisible');

    submit_btn.classList.add('invisible');

    reset_btn.classList.remove('invisible');

    img_preview.classList.add('uploaded');

}// the end of image load





function errorHandler(event) {

    output.innerHTML = 'Upload failed';
}


function abortHandler(event) {

   output.innerHTML = 'Upload aborted';
}


submit_btn.addEventListener('click', function(){

    submit_btn.classList.add('invisible');

    progress.classList.remove('invisible');

    var file = file_input.files[0];
    var formdata = new FormData();

    formdata.append("FileInput", file);

   // formdata.append("_token", _token);

    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "/admin/image/uploadSlider");
    ajax.send(formdata);

    reset_btn.setAttribute('disabled', 'disabled');

});


reset_btn.addEventListener('click', function(){

    img_preview.setAttribute('src', '/img/nophoto.jpg');

    if(file_input.classList.contains('invisible')) file_input.classList.remove('invisible');

    xhr2 = new XMLHttpRequest();
    xhr2.open('POST', '/admin/image/deleteSlider', true);
    xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr2.onreadystatechange = function () {
        if (xhr2.readyState == 4) {
            if (xhr2.status == 200) {

                var response =JSON.parse(xhr2.responseText)
                output.innerHTML = response.message;
                success.classList.add('invisible');
            }
        }
    };
    xhr2.send();

    submit_btn.classList.add('invisible');
    reset_btn.classList.add('invisible');

    img_preview.classList.remove('uploaded');

});



