const userList = document.getElementById('user-list');
var sections = [];

var users = JSON.parse(document.getElementById('users-service').getAttribute('data-users'));
console.log(users);

users.forEach(user => {
    var row = document.createElement('tr');
    //row.className = 'item';

    var id = document.createElement('td');
    id.innerHTML = user.id;
    row.appendChild(id);

    var login = document.createElement('td');
    login.innerHTML = user.login;
    row.appendChild(login);

    var email = document.createElement('td');
    email.innerHTML = user.email;
    row.appendChild(email);



    var activation = document.createElement('td');
    var btnActivation = document.createElement('span');
    btnActivation.setAttribute('data-is-activated', user.is_activated);
    btnActivation.innerHTML = user.is_activated == '1' ? "person_off" : "how_to_reg";
    btnActivation.classList.add(user.is_activated == '1' ? 'warning' : 'editor');
    btnActivation.classList.add('material-icons');
    btnActivation.title = "Изменить статус активации";
    btnActivation.addEventListener('click', () => {
        
        const http = new XMLHttpRequest()
        http.open('POST', '/forum/user_activation.php', true)
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        http.send(`id=${user.id}&is_activated=${!(btnActivation.getAttribute('data-is-activated') == 1)}`);
        http.onload = function() {
            console.log(http.responseText); 
            btnActivation.innerHTML = !(btnActivation.getAttribute('data-is-activated') == 1) ? "person_off" : "how_to_reg";
            console.log(!(btnActivation.getAttribute('data-is-activated') == 1));
            btnActivation.classList.toggle('editor');
            btnActivation.classList.toggle('warning');
            btnActivation.setAttribute('data-is-activated', +!(btnActivation.getAttribute('data-is-activated') == 1));
        }
    });
    activation.appendChild(btnActivation); 
    
    var btnMod = document.createElement('span');
    btnMod.classList.add('material-icons');
    btnMod.classList.add('editor');
    btnMod.innerHTML = "badge";
    btnMod.title = "Модерируемые разделы";
    btnMod.addEventListener('click', () => {
        showModalForm('edit_mod', {id: user.id, sections: sections});
    });
    activation.appendChild(btnMod);

    row.appendChild(activation);

    userList.getElementsByTagName('tbody')[0].append(row);
    sorttable.makeSortable(userList);
});

sorttable.makeSortable(userList);

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

                
                forumData.map(({sections}) => ({sections})).forEach(array => {
                    array.sections.forEach(element => {
                        sections.push(element);
                    });
                });
                
                console.log(sections);     
            }
          }
      };
      httpRequest.open('GET', '/forum/forum_list.php');
      httpRequest.send();
  })();
