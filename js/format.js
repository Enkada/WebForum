function getFormatTime(date) {
    var diff = (Date.now() - Date.parse(date));
    var s = Math.floor(diff / 1000);
    var m = Math.floor(s / 60);
    var h = Math.floor(m / 60);
    var d = Math.floor(h / 24);

    if (s == 0 && m == 0 && h == 0 && d == 0) {
        return "только что";
    }
    else if (m == 0 && h == 0 && d == 0) {
        return s + " сек. назад";
    }
    else if (h == 0 && d == 0) {
        return m + " мин. назад";
    }
    else if (d == 0) {
        return h + " ч. назад";
    }
    else if (d > 0) {
        return d + " д. назад";
    }

    return date;
}

const allowedTags = ['b', 'i', 's', 'u'];

function formatMessage(t) {
	
    console.log(t);
    allowedTags.forEach(tag => {
        
        var matches = t.matchAll(new RegExp(`\\[${tag}\\](.*?)\\[\/${tag}\\]`, "g"));

        if (matches != null) {  
            for (const match of matches) {
                t = t.replace(match[0], `<${tag}>${match[1]}</${tag}>`);
            }
        }
    });
    

    return t;
}

String.prototype.escape = function() {
    var tagsToReplace = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;'
    };
    return this.replace(/[&<>]/g, function(tag) {
        return tagsToReplace[tag] || tag;
    });
};