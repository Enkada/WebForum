var preview = document.getElementById('image-preview');

function showLogo(input) {
    if (input.files[0] != null) {
        var file = input.files[0];
        if (file.type.split('/')[0] === 'image') {
            console.log(file);
            preview.src = URL.createObjectURL(file);
        }
        else {
            console.log("wrong file type");
        }        
    }    
}