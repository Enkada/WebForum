const params = new Proxy(new URLSearchParams(window.location.search), {
    get: (searchParams, prop) => searchParams.get(prop),
});

const replyList = document.getElementById('topic-reply-list');
const replyForm = document.getElementById('form-add-reply');
const replyFormId = document.getElementById('form-add-reply__id');

var index = 0;

(() => {    
    let httpRequest = new XMLHttpRequest();

    if (!httpRequest)
        return false;

    httpRequest.onreadystatechange = () => {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                repliesData = JSON.parse(httpRequest.responseText);
                console.log(repliesData);

                if (repliesData == null)
                    return; 
                
                repliesData.forEach(reply => {
                                     

                    replyList.appendChild(createReply(reply));
                });
            }
        }
    };
    httpRequest.open('GET', '../core/actions/get/messages.php?id=' + params.id);
    httpRequest.send();
})();

const topicDate = document.querySelector('#topic-header-message__content__date');
const topicText = document.querySelector('#topic-header-message__content__text');
window.onload = () => {
    topicText.innerHTML = formatMessage(topicText.innerHTML);
    topicDate.innerHTML = getFormatTime(topicDate.innerHTML);
};

function createReply(replyData) {
    var reply = document.createElement('div');
    reply.className = 'reply';   

    reply.style = '--index:' + index++;

    var replyWrapper = document.createElement('div');
    replyWrapper.className = 'reply__wrapper';

    var replyHeader = document.createElement('div');
    replyHeader.className = 'reply__header'; 

    var replyTitle = document.createElement('div');
    replyTitle.className = 'reply__header__title'; 
    replyTitle.innerHTML = replyData.title;
    replyHeader.appendChild(replyTitle);

    var replyAuthorImage = document.createElement('img');
    replyAuthorImage.classList.add('reply__header__image'); 
    replyAuthorImage.classList.add('avatar'); 
    replyAuthorImage.src = "../profile/avatar/" + replyData.photo;
    replyHeader.appendChild(replyAuthorImage);

    var replyAuthor = document.createElement('a');
    replyAuthor.className = 'reply__header__author'; 
    replyAuthor.innerHTML = replyData.author;
    replyAuthor.href = "../profile/?id=" + replyData.user;
    replyHeader.appendChild(replyAuthor);

    var replyDate = document.createElement('div');
    replyDate.className = 'reply__header__date'; 
    replyDate.innerHTML = getFormatTime(replyData.date);
    replyDate.title = replyData.date;
    replyHeader.appendChild(replyDate);

    replyWrapper.appendChild(replyHeader);

    if (replyData.attachments) {
        var replyAttachments = document.createElement('div');
        replyAttachments.className = 'reply__attachment-list'; 
        JSON.parse(replyData.attachments).forEach(attachment => {
            attachmentImage = document.createElement('img');
            attachmentImage.className = 'reply__attachment--image'; 
            attachmentImage.src = '../uploads/' + attachment.real;
            replyAttachments.appendChild(attachmentImage);

            attachmentImage.addEventListener('click', () => {
               openImageViewer('../uploads/' + attachment.real); 
            });
        });
        replyWrapper.appendChild(replyAttachments);
    }

    var replyText = document.createElement('div');
    replyText.className = 'reply__text'; 
    replyText.innerHTML = formatMessage(replyData.text.escape());
    replyWrapper.appendChild(replyText);

    var replyBtnList = document.createElement('div');
    replyBtnList.className = 'reply__btn-list'; 

    if (["admin", "user", "mod"].includes(document.getElementById('role-service').getAttribute('data-role'))) {
        var replyBtn = document.createElement('div');
        replyBtn.classList.add('btn-material-icon'); 
        replyBtn.classList.add('btn-material-icon--small'); 
        replyBtn.innerHTML = `<span class="material-icons">reply</span><span>Ответить</span>`;
        replyBtn.addEventListener('click', () => {
            reply.appendChild(replyForm);
            replyFormId.value = replyData.id;        
            replyForm.style.display = "";
            replyForm.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
        });
        replyBtnList.appendChild(replyBtn);

        if (document.getElementById('id-service').getAttribute('data-id') == replyData.user) {
            var replyBtnEdit = document.createElement('div');
            replyBtnEdit.classList.add('btn-material-icon'); 
            replyBtnEdit.classList.add('btn-material-icon--small');  
            replyBtnEdit.innerHTML = `<span class="material-icons">edit</span><span>Изменить</span>`;
            replyBtnEdit.addEventListener('click', () => {
                showModalForm("edit_message", {id: replyData.id, title: replyData.title, text: replyData.text});
            });
            replyBtnList.appendChild(replyBtnEdit);
        }
    }

    replyWrapper.appendChild(replyBtnList);

    reply.appendChild(replyWrapper);

    if (replyData.replies != null) {
        var replyReplies = document.createElement('div');
        replyReplies.className = 'reply__replies'; 
        
        var replyRepliesLine = document.createElement('div');
        replyRepliesLine.className = 'reply__replies__line';
        replyReplies.appendChild(replyRepliesLine);

        var replyRepliesWrapper = document.createElement('div');
        replyRepliesWrapper.className = 'reply__replies__wrapper';        

        replyData.replies.forEach(r => { 
            replyRepliesWrapper.appendChild(createReply(r));
        });  
        replyReplies.appendChild(replyRepliesWrapper);
        reply.appendChild(replyReplies);      
    }

    return reply;
}

const headerMessageBtnReply = document.getElementById('topic-header-message__btn-reply');
const headerMessage = document.getElementById('topic-header-message');

headerMessageBtnReply.addEventListener('click', () => {
    headerMessage.appendChild(replyForm);
    replyFormId.value = params.id;        
    replyForm.style.display = "";
    replyForm.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
});

const imageViewer = document.getElementById('image-viewer');
const selectedImage = document.getElementById('selected-image');
var isLMBDown = false;

imageViewer.addEventListener('mousedown', () => {
    isLMBDown = true;
});

imageViewer.addEventListener('mouseup', () => {
    isLMBDown = false;
});

var mouseX = 0;
var mouseY = 0;
var mouseXSpeed = 0;
var mouseYSpeed = 0;
var offsetX = 0;
var offsetY = 0;

imageViewer.addEventListener('mousemove', function(e) {
    mouseXSpeed = e.screenX - mouseX;
    mouseYSpeed = e.screenY - mouseY;
    mouseX = e.screenX;
    mouseY = e.screenY;

    if (isLMBDown) {
        offsetX += mouseXSpeed;
        offsetY += mouseYSpeed;

        imageViewer.style = `--offset-x: ${offsetX}px; --offset-y: ${offsetY}px;`;
    }    
});

function openImageViewer(image) {
    selectedImage.src = image;
}