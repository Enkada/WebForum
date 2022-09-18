const userList = document.getElementById('user-list');

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
    btnActivation.className = user.is_activated == '1' ? 'user-activated' : 'user-not-activated';
    btnActivation.innerHTML = user.is_activated == '1' ? "Активирован" : "Не активирован"; 
    btnActivation.addEventListener('click', () => {
        btnActivation.innerHTML = btnActivation.innerHTML == "Активирован" ? "Не активирован" : "Активирован"; 
        btnActivation.className = btnActivation.className == 'user-activated' ? 'user-not-activated' : 'user-activated'; 
    });
    activation.appendChild(btnActivation);    
    row.appendChild(activation);

    userList.getElementsByTagName('tbody')[0].append(row);
    sorttable.makeSortable(userList);
});

sorttable.makeSortable(userList);