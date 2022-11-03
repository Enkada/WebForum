const params = new Proxy(new URLSearchParams(window.location.search), {
    get: (searchParams, prop) => searchParams.get(prop),
});

const topicList = document.getElementById('topic-list');

(() => {    
    let httpRequest = new XMLHttpRequest();

    if (!httpRequest)
        return false;

    httpRequest.onreadystatechange = () => {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                topicsData = JSON.parse(httpRequest.responseText);
                console.log(topicsData);

                if (topicsData == null)
                    return; 
                
                var index = 0;
                topicsData.forEach(topic => {
                    var topicRow = document.createElement('div');
                    topicRow.className = 'topic';

                    topicRow.style = '--index:' + index++;

                    var topicTitle = document.createElement('div');
                    topicTitle.className = 'topic__title';

                    var topicTitleLink = document.createElement('a');
                    topicTitleLink.className = 'topic__title__link';
                    topicTitleLink.innerHTML = topic.title;
                    topicTitleLink.href = '../topic/?id=' + topic.id;

                    topicTitle.appendChild(topicTitleLink);
                    topicRow.appendChild(topicTitle);

                    var topicInfo = document.createElement('div');
                    topicInfo.className = 'topic__info';
                    
                    var topicInfoAuthor = document.createElement('div');
                    topicInfoAuthor.className = 'topic__info__author';
                    topicInfoAuthor.innerHTML = topic.author;

                    var topicInfoDate = document.createElement('div');
                    topicInfoDate.className = 'topic__info__date';
                    topicInfoDate.innerHTML = getFormatTime(topic.date);

                    topicInfo.appendChild(topicInfoAuthor);
                    topicInfo.appendChild(topicInfoDate);
                    topicRow.appendChild(topicInfo);

                    var topicReplies = document.createElement('div');
                    topicReplies.className = 'topic__replies';

                    var topicRepliesNumber = document.createElement('div');
                    topicRepliesNumber.className = 'topic__replies__number';
                    topicRepliesNumber.innerHTML = topic.replies;

                    var topicRepliesWord = document.createElement('div');
                    topicRepliesWord.className = 'topic__replies__word';
                    topicRepliesWord.innerHTML = 'ответов';

                    topicReplies.appendChild(topicRepliesNumber);
                    topicReplies.appendChild(topicRepliesWord);
                    topicRow.appendChild(topicReplies);

                    topicList.appendChild(topicRow);
                });
            }
        }
    };
    httpRequest.open('GET', '../core/actions/get/topics.php?section=' + params.id);
    httpRequest.send();
})();

const newTopicForm = document.getElementById('form-new-topic');
const btnAddTopic = document.getElementById('btn-add-topic');

if (btnAddTopic != null) {
    btnAddTopic.addEventListener('click', () => {
        newTopicForm.style.display = "";
        btnAddTopic.style.display = "none";
    });
}
