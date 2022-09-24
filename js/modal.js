const modal = document.getElementById('modal');
const modal_btnClose = document.getElementById('modal__btn-close');
const modal_btnSubmit = document.getElementById('modal__btn-submit');
const modal_content = document.getElementById('modal__content');
const modal_message = document.getElementById('modal-message-service').getAttribute('data-message');

const PATH = document.getElementById('path-service').getAttribute('data-path');

if (modal_message != "") {
    var message = JSON.parse(modal_message);
    showModal(message.title, message.text);
}

function showModal(title, text) {
    modal.classList.add('show');

    modal_content.innerHTML = `<h2>${title}</h2><p>${text}</p>`;
    modal_btnSubmit.style.display = "none";
}

function showModalForm(action, extra = null) {
    modal.classList.add('show');

    modal_content.innerHTML = '';
    modal_btnSubmit.style.display = "";

    if (action.includes('add'))
        modal_btnSubmit.innerHTML = 'Добавить';
    else if (action.includes('delete'))
        modal_btnSubmit.innerHTML = 'Удалить';
    else if (action.includes('edit'))
        modal_btnSubmit.innerHTML = 'Изменить';

    var form = document.createElement('form');
    form.id = 'modal__form';
    form.action = `${PATH}core/actions/post/${action}.php`;
    form.method = "POST";

    var tbId = document.createElement('input');
    tbId.type = 'hidden';
    tbId.name = "id";
    tbId.value = extra != null ? extra.id : null;
    form.appendChild(tbId);

    var h2 = document.createElement('h2');
    modal_content.appendChild(h2);

    switch (action) {
        case 'edit_mod':
            h2.innerHTML = "Модерируемые разделы";

            var selectSection = document.createElement('select');
            selectSection.name = "section";
            selectSection.title = "Раздел";
            extra.sections.forEach(s => {
                var optionSection = document.createElement('option');
                optionSection.value = s.id;
                optionSection.innerHTML = s.name;
                selectSection.appendChild(optionSection);
            });
            //selectSection.value = extra.section.category;
            form.appendChild(selectSection);
            break;
        case 'delete_category':
            h2.innerHTML = "Удаление категории";

            var p = document.createElement('p');
            p.innerHTML = `Вы действительно хотите удалить категорию "${extra.name}"? Связанные с этой категорией разделы не будут удалены.`;
            form.appendChild(p);
            break;
        case 'delete_section':
            h2.innerHTML = "Удаление раздела";

            var p = document.createElement('p');
            p.innerHTML = `Вы действительно хотите удалить раздел "${extra.title}"?`;
            form.appendChild(p);
            break;
        case 'add_category':
            h2.innerHTML = "Новая категория";

            var tbName = document.createElement('input');
            tbName.name = "name";
            tbName.placeholder = "Название категории";
            tbName.title = tbName.placeholder;
            tbName.required = true;
            form.appendChild(tbName);
            break;
        case 'edit_category':
            h2.innerHTML = "Изменение категории";

            var tbName = document.createElement('input');
            tbName.name = "name";
            tbName.placeholder = "Название категории";
            tbName.title = tbName.placeholder;
            tbName.value = extra.name;
            tbName.required = true;
            form.appendChild(tbName);

            var tbPriority = document.createElement('input');
            tbPriority.type = 'number';
            tbPriority.name = "priority";
            tbPriority.placeholder = "Приоритет категории";
            tbPriority.title = tbPriority.placeholder;
            tbPriority.value = extra.priority;
            form.appendChild(tbPriority);

            var btnDeleteCategory = document.createElement('span');
            btnDeleteCategory.classList.add('btn-material-icon');
            btnDeleteCategory.classList.add('warning');   
            btnDeleteCategory.innerHTML = '<span class="material-icons">delete</span><span>Удалить категорию</span>';
            btnDeleteCategory.addEventListener('click', () => {
                showModalForm('delete_category', extra);
            });
            form.appendChild(btnDeleteCategory);
            break;
        case 'edit_message': 
            h2.innerHTML = "Изменение сообщения";

            var tbTitle = document.createElement('input');
            tbTitle.name = "title";
            tbTitle.placeholder = "Название раздела";
            tbTitle.title = tbTitle.placeholder;
            tbTitle.required = true;
            tbTitle.value = extra.title;
            form.appendChild(tbTitle);

            var taText = document.createElement('textarea');
            taText.rows = 5;
            taText.name = "text";
            taText.placeholder = "Текст сообщения";
            taText.title = taText.placeholder;
            taText.style.resize = "vertical";
            taText.value = extra.text;
            taText.required = true;
            form.appendChild(taText);
            break;
        case 'edit_section':            
            h2.innerHTML = "Редактирование раздела";  
            tbId.value = extra.section.id;   

            var tbTitle = document.createElement('input');
            tbTitle.name = "title";
            tbTitle.placeholder = "Название раздела";
            tbTitle.title = tbTitle.placeholder;
            tbTitle.required = true;
            tbTitle.value = extra.section.title;
            form.appendChild(tbTitle);

            var taDescription = document.createElement('textarea');
            taDescription.rows = 5;
            taDescription.name = "description";
            taDescription.placeholder = "Описание раздела";
            taDescription.title = taDescription.placeholder;
            taDescription.style.resize = "vertical";
            taDescription.value = extra.section.description;
            form.appendChild(taDescription);

            var selectCategory = document.createElement('select');
            selectCategory.name = "category";
            selectCategory.title = "Категория";
            extra.categories.forEach(c => {
                var optionCategory = document.createElement('option');
                optionCategory.value = c.id;
                optionCategory.innerHTML = c.name;
                selectCategory.appendChild(optionCategory);
            });
            selectCategory.value = extra.section.category;
            console.log(extra);
            form.appendChild(selectCategory);

            var btnDeleteSection = document.createElement('span');
            btnDeleteSection.classList.add('btn-material-icon');
            btnDeleteSection.classList.add('warning');   
            btnDeleteSection.innerHTML = '<span class="material-icons">delete</span><span>Удалить раздел</span>';
            btnDeleteSection.addEventListener('click', () => {
                showModalForm('delete_section', extra.section);
            });
            form.appendChild(btnDeleteSection);
            break;
        case 'add_section':            
            h2.innerHTML = "Добавление раздела";   
            
            tbId.name = "category";
            tbId.value = extra.id;
            console.log(extra);

            var tbTitle = document.createElement('input');
            tbTitle.name = "title";
            tbTitle.placeholder = "Название раздела";
            tbTitle.title = tbTitle.placeholder;
            tbTitle.required = true;
            form.appendChild(tbTitle);

            var taDescription = document.createElement('textarea');
            taDescription.rows = 5;
            taDescription.name = "description";
            taDescription.placeholder = "Описание раздела";
            taDescription.title = taDescription.placeholder;
            taDescription.style.resize = "vertical";
            form.appendChild(taDescription);
            break;
    }

    modal_content.appendChild(form);
}

modal_btnClose.addEventListener('click', () => {
    modal.classList.remove('show');
});