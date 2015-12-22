var menu=document.getElementById('menu'),

    progress=document.getElementById('progress-bar'),
    output= document.getElementById('output'),
    submit_btn= document.getElementById('submit-btn'),
    reset_btn= document.getElementById('image-reset-btn');




// this background is for imageupload



function progressHandler(event){

    var percent=Math.round((event.loaded/event.total)*100);
    progress.style.width= percent+"%";
    progress.innerHTML= percent+"%";
}

function completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    output.innerHTML= event.target.responseText;

    progress.style.width= "0%";
    progress.innerHTML= "0%";

    output.classList.remove('invisible');
    submit_btn.classList.add('invisible');
    progress.classList.add('invisible');
    reset_btn.removeAttribute('disabled');
}


function errorHandler(event){

    output.innerHTML= 'Upload failed';
}


function abortHandler(event){

    output.innerHTML= 'Upload aborted';
}

if(submit_btn){
    submit_btn.onclick = function(){
console.log('submit');
        progress.classList.remove('invisible');

        var file=document.getElementById("FileInput").files[0];

        var formdata= new FormData();

        formdata.append("FileInput", file);

        var ajax=new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "/image/upload");
        ajax.send(formdata);

        reset_btn.setAttribute('disabled', 'disabled');

    };// end of function
}


if(document.getElementById('FileInput')) {
    document.getElementById('FileInput').onchange = function () {

        var input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('image_preview').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                document.getElementById('FileInput').classList.add('invisible');

                output.classList.add('invisible');

                reset_btn.classList.remove('invisible');

                submit_btn.classList.remove('invisible');

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function
}

if(reset_btn) {
    reset_btn.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('reset');

        document.getElementById('image_preview').setAttribute('src', '/img/noavatar.jpg');
        document.getElementById('FileInput').classList.remove('unvisible');

        xhr2 = new XMLHttpRequest();
        xhr2.open('POST', '/image/delete', true);
        xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState == 4) {
                if (xhr2.status == 200) {
                    output.innerHTML = xhr2.responseText;

                }
            }
        };
         xhr2.send();

        submit_btn.classList.add('unvisible');
        this.classList.add('unvisible');

    };
}
//end of image upload