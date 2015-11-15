var menu=document.getElementById('menu'),
change_button = document.getElementById('touch-button'),
    progress=document.getElementById('progress-bar'),
    output= document.getElementById('output'),
    submit_btn= document.getElementById('submit-btn'),
    reset_btn= document.getElementById('reset-btn');




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

    output.classList.remove('unvisible');
    submit_btn.classList.add('unvisible');
    progress.classList.add('unvisible');
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

        progress.classList.remove('unvisible');

        var file=document.getElementById("FileInput").files[0];

        var formdata= new FormData();

        formdata.append("FileInput", file);

        var ajax=new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "/protected/ajax/upload.php/");
        ajax.send(formdata);

        reset_btn.setAttribute('disabled', 'disabled');

    };// end of function
}



document.getElementById('FileInput').onchange = function(){

    var input = this ;

    if ( input.files && input.files[0] ) {
        if ( input.files[0].type.match('image.*') ) {
            var reader = new FileReader();

            reader.onload = function(e) { document.getElementById('image_preview').setAttribute('src', e.target.result); };
            reader.readAsDataURL(input.files[0]);

            document.getElementById('FileInput').classList.add('unvisible');

            output.classList.add('unvisible');

            reset_btn.classList.remove('unvisible');

            submit_btn.classList.remove('unvisible');

        }// else console.log('is not image mime type');
    }// else console.log('not isset files data or files API not supordet');

};//end of function



reset_btn.onclick = function(){
    document.getElementById('image_preview').setAttribute('src', '/images/noavatar.jpg');
    document.getElementById('FileInput').classList.remove('unvisible');

    xhr= new XMLHttpRequest();
    xhr.open('POST', 'index/deleteimage/', true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if(xhr.status == 200) {
                output.innerHTML=xhr.responseText;
            }
        }
    };
    xhr.send('ajax=1');

    submit_btn.classList.add('unvisible');
    this.classList.add('unvisible');

};
//end of image upload