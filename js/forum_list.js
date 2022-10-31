const forumList = document.querySelector('.forum-list');
var showEditorTools = document.getElementById('role-service').getAttribute('data-role') == 'admin';

(() => {    
    let httpRequest = new XMLHttpRequest();
  
      if (!httpRequest)
        return false;
      httpRequest.onreadystatechange = () => {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                forumData = JSON.parse(httpRequest.responseText);
                console.log(forumData);
                var categories = forumData.map(({category: {id, name, priority}}) => ({id, name, priority}));

                var index = 0;
                forumData.forEach(item => {
                    var categoryRow = document.createElement('div');
                    categoryRow.className = 'category';

                    categoryRow.style = '--index:' + index++;

                    var categoryRowTitle = document.createElement('div');
                    categoryRowTitle.className = 'category__title';
                    categoryRowTitle.innerHTML = item.category.name; 
                    categoryRowTitle.title = `Категория форума "${item.category.name}", включает в себя разделов: ${item.sections != null ? item.sections.length : 0}`;                

                    categoryRow.appendChild(categoryRowTitle);

                    if (showEditorTools) {
                        if (item.category.id != '0') {
                            var btnEditCategory = document.createElement('span');
                            btnEditCategory.classList.add('material-icons');
                            btnEditCategory.classList.add('editor');
                            btnEditCategory.classList.add('btn-after-text');
                            btnEditCategory.innerHTML = "edit";
                            btnEditCategory.addEventListener('click', () => {
                                showModalForm('edit_category', item.category);
                            });
                            categoryRowTitle.appendChild(btnEditCategory);
                        }

                        var btnAddSection = document.createElement('span');
                        btnAddSection.classList.add('material-icons');
                        btnAddSection.classList.add('editor');
                        btnAddSection.classList.add('btn-after-text');
                        btnAddSection.innerHTML = "add_box";
                        btnAddSection.addEventListener('click', () => {
                            showModalForm('add_section', item.category);
                        });

                        categoryRowTitle.appendChild(btnAddSection);                
                    }

                    var categoryRowSections = document.createElement('div');
                    categoryRowSections.className = 'category__section-list';
                    categoryRowSections.className = 'section-list';

                    if (item.sections != null) {
                        item.sections.forEach(section => {
                            var sectionRow = document.createElement('div');
                            sectionRow.className = 'section-list__row';
                        
                            // Section title and description
                            var info = document.createElement('div');
                            info.classList.add('section-list__cell');
                            info.classList.add('section-info');
                        
                            var infoTitle = document.createElement('div');
                            infoTitle.className = 'section-info__title';

                            var infoLink = document.createElement('a');
                            infoLink.className = 'section-info__title__link';
                            infoLink.innerHTML = section.title;
                            infoLink.href = 'section/?id=' + section.id;
                            
                            info.appendChild(infoTitle);                            
                            infoTitle.appendChild(infoLink);

                            if (showEditorTools) {
                                var btnEditSection = document.createElement('span');
                                btnEditSection.classList.add('material-icons');
                                btnEditSection.classList.add('editor');
                                btnEditSection.classList.add('btn-after-text');
                                btnEditSection.innerHTML = "edit";
                                btnEditSection.addEventListener('click', () => {
                                    showModalForm('edit_section', {section: section, categories: categories});
                                });
                                infoTitle.appendChild(btnEditSection);
                            }
                        
                            var infoDescription = document.createElement('div');
                            infoDescription.className = 'section-info__description';
                            infoDescription.innerHTML = section.description;
                        
                            info.appendChild(infoDescription);
                            sectionRow.appendChild(info);    
                        
                            // Topics counter
                            var topics = document.createElement('div');
                            topics.classList.add('section-list__cell');
                            topics.classList.add('section-topics');
                        
                            var topics_number = document.createElement('div');
                            topics_number.className = 'section-topics__number';
                            topics_number.innerHTML = section.topics;
                        
                            var topics_word = document.createElement('div');
                            topics_word.className = 'section-topics__word';
                            topics_word.innerHTML = 'тем';
                        
                            topics.appendChild(topics_number);
                            topics.appendChild(topics_word);
                            sectionRow.appendChild(topics);    
                            
                            // Last message
                            var lastMessage = document.createElement('div');
                            lastMessage.className = 'section-list__cell';
                        
                            if (section.lastMessage != null) {
                                var lastMessageContent = document.createElement('div');
                                lastMessageContent.className = 'last-message';
                        
                                var lastMessageContent_img = document.createElement('img');
                                lastMessageContent_img.src = section.lastMessage.img;
                                lastMessageContent_img.className = 'last-message__image';
                        
                                var lastMessageContent_title = document.createElement('div');
                                lastMessageContent_title.className = 'last-message__title';
                                lastMessageContent_title.innerHTML = section.lastMessage.title;
                        
                                var lastMessageContent_postedBy = document.createElement('div');
                                lastMessageContent_postedBy.className = 'last-message__posted-by';
                                lastMessageContent_postedBy.innerHTML = `От ${section.lastMessage.poster}, ${section.lastMessage.date}`;
                        
                                lastMessageContent.appendChild(lastMessageContent_img);
                                lastMessageContent.appendChild(lastMessageContent_title);
                                lastMessageContent.appendChild(lastMessageContent_postedBy);
                        
                                lastMessage.appendChild(lastMessageContent);
                            }
                            else {
                                sectionRow.classList.add('section-list__row--no-topics');
                            }
                        
                            sectionRow.appendChild(lastMessage);                       
                        
                            categoryRowSections.appendChild(sectionRow);
                        });                        
                    }
                    categoryRow.appendChild(categoryRowSections);
                    forumList.appendChild(categoryRow);
                });     
            }
          }
      };
      httpRequest.open('GET', 'core/actions/get/forum_list.php');
      httpRequest.send();
  })();

if (showEditorTools) {
    document.getElementById('btn-add-category').addEventListener('click', () => {
        showModalForm('add_category');
    });
}
