const searchInput = document.getElementById('search-input');
const searchResults = document.querySelector('.search-result-list');

var searchData = JSON.parse(document.getElementById('search-service').getAttribute('data-search'));
var results = [];

console.log('data', searchData);

searchInput.addEventListener('input', () => {    
    if (searchInput.value != "") {
        var results = JSON.parse(document.getElementById('search-service').getAttribute('data-search'));
        results = results.filter(msg => 
            msg['text'].toLowerCase().includes(searchInput.value.toLowerCase()) || 
            msg['title'].toLowerCase().includes(searchInput.value.toLowerCase()) 
        );
        console.log(results, 'DATA', searchData);
    
        results.forEach(msg => {
            msg['text'] = msg['text'].replace(new RegExp(`(?<!<[^>]*)${searchInput.value}`, "gi"), `<mark>${searchInput.value}</mark>`);
            msg['title'] = msg['title'].replace(new RegExp(`(?<!<[^>]*)${searchInput.value}`, "gi"), `<mark>${searchInput.value}</mark>`);
        });        

        if (!results.length == 0) {            
            searchResults.innerHTML = `<div class="search-info">По вашему запросу найдено результатов: <b>${results.length}</b>.</div>`;
            addMessage(results, 0, true);
        }
        else {
            searchResults.innerHTML = (`<div class="search-info">По вашему запросу <b>"${searchInput.value}"</b> ничего не найдено.</div>`);
        }  
    }
    else {
        searchResults.innerHTML = '';
    } 
});

function addMessage(results, index = 0, instant = false) {
    console.log(results);
    if (index + 1 > results.length) { return; }

    message = results[index];

    messageWrapper = document.createElement('div');
    messageWrapper.className = 'search-result';

    messageTitle = document.createElement('a');
    messageTitle.innerHTML = message['title'];
    messageTitle.className = 'search-result__title';
    var id = message['reply_to'] == 0 ? message['id'] : message['reply_to'];
    messageTitle.href = "../topic/?id=" + id;
    messageWrapper.append(messageTitle);

    messageInfo = document.createElement('div');
    messageInfo.innerHTML = `Сообщение от <a href="../profile/?id=${message['user']}">${message['author']}</a>, ${message['date']}`;
    messageInfo.className = 'search-result__info';
    messageWrapper.append(messageInfo);

    messageText = document.createElement('div');
    messageText.innerHTML = message['text'];
    messageText.className = 'search-result__text';
    messageWrapper.append(messageText);

    //var d = new Date(message['date'].replace(/ /g,"T"));
    //messageDate = document.createElement('div');   
    //messageDate.innerHTML = `${d.getDate()} ${months[d.getMonth()]}, ${d.getFullYear()}`;           

    searchResults.append(messageWrapper);

    if (!instant) {
        setTimeout(() => {
            addMessage(results, ++index);
        }, 300);
    }
    else {
        addMessage(results, ++index, true);
    }
}