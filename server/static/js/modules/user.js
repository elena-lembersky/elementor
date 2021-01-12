import {$usersTableWrapper, $generalModalContainer, $titleName, dataHandler} from './utils.js';
import { showModal } from './modal.js';

function logout(uid) {
    let url = `http://localhost:8080/logout/${uid}`;
    fetch(url)
        .then(res => res.json())
        .then((out) => {
            const output = JSON.parse(out);
            if (output.ok) {
                location.reload();
            }
        })
        .catch(err => { throw err });
}

export function userLogout(){
    const userID = returnCookieUserID();
    logout(userID);
}

function fetchUserData(uid){
    let url = `http://localhost:8080/user/${uid}`;

    fetch(url)
        .then(res => res.json())
        .then((out) => {
            dataHandler(out,showModal);
            //console.log('User Data! ', out.ok);
        })
        .catch(err => { throw err });
}

export function getUserInfo(e){
    let tr = e.target.closest('tr');
    if (!tr) return;
    const userID = tr.dataset.id;
    fetchUserData(userID);
}

export function getUsers(){
    let url = 'http://localhost:8080/users';

    fetch(url)
        .then(res => res.json())
        .then((out) => {
            //console.log('All users data ', out);
            dataHandler(out,insertUsersDataToTable);
        })
        .catch(err => { throw err });
}

export function buildUsersTable(json) {
    let cols = Object.keys(json[0]);
    let headerRow = cols
        .map(col => `<th>${col}</th>`)
        .join("");

    let rows = json
        .map(row => {
            let tds = cols.map(col => `<td>${row[col]}</td>`).join("");
            return `<tr data-id="${row['ID']}">${tds}</tr>`;
        })
        .join("");

    const table = `
        <table class="data-table">
            <thead>
                <tr>${headerRow}</tr>
            </thead>
            <tbody>
                ${rows}
            </tbody>
        </table>`;
    return table;
}

export function insertUsersDataToTable(out){
    $usersTableWrapper.innerHTML=buildUsersTable(out);
}

export function returnCookieUserID(){
    return document.cookie.replace(/(?:(?:^|.*;\s*)user_id\s*\=\s*([^;]*).*$)|^.*$/, "$1");
}

function returnCookieUserName(){
    return document.cookie.replace(/(?:(?:^|.*;\s*)user_name\s*\=\s*([^;]*).*$)|^.*$/, "$1");
}

export function printUserName() {
    $titleName.textContent = returnCookieUserName();
}