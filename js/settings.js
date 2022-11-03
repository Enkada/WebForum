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

document.querySelectorAll('.btn-style').forEach(btn => {
    btn.addEventListener('click', () => {
        // var expires = "";
        // var date = new Date();
        // date.setTime(date.getTime() + (2147483647));
        // expires = "; expires=" + date.toUTCString();
        // document.cookie = 'theme' + "=" + (btn.getAttribute('data-style') || "")  + expires + "; path=/";
        setCookie('theme', btn.getAttribute('data-style'));

        location.reload();
        return false;
    });
});

function setCookie(name,value) {
    var expires = "";
    var date = new Date();
    date.setTime(date.getTime() + (2147483647));
    expires = "; expires=" + date.toUTCString();
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

const accent = document.querySelector('#range-accent');

accent.addEventListener('input', () => {
    console.log(accent.value);
    document.documentElement.style.setProperty('--brand-deg', accent.value);
});

accent.addEventListener('change', () => {
    setCookie('accent', accent.value)
});