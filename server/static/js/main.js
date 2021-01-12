import {$usersTable, $generalModal, $logoutButton} from './modules/utils.js';
import {getUsers, getUserInfo, printUserName, userLogout, insertUsersDataToTable} from './modules/user.js';
import { closeModal } from './modules/modal.js';
import { dataHandler} from './modules/utils.js';

// TODO logout user with more elegant solution
// const isLogin = sessionStorage.getItem('is_login');
// if (!isLogin) userLogout();

$usersTable.addEventListener("click", getUserInfo);
$generalModal.addEventListener("click", closeModal);
$logoutButton.addEventListener("click", userLogout);

//sessionStorage.setItem('tab', 'bla bla');


getUsers();
printUserName();

///////// TODO logout user when close tab
// window.onbeforeunload = function () {
//     return 'Are you really want to perform the action?';
// }
////////////////////////////////////////////////////
// refresh data
let pollingWorker = new Worker('static/js/pollingworker.js');

pollingWorker.addEventListener('message', function contentReceiverFunc(e) {
    dataHandler(e.data,insertUsersDataToTable);
});



