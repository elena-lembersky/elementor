import {$usersTable, $generalModal, $logoutButton, $usersTableWrapper} from './modules/utils.js';
import {getUsers, getUserInfo, printUserName, userLogout, buildUsersTable} from './modules/user.js';
import { closeModal } from './modules/modal.js';

$usersTable.addEventListener("click", getUserInfo);
$generalModal.addEventListener("click", closeModal);
$logoutButton.addEventListener("click", userLogout);

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
    $usersTableWrapper.innerHTML=buildUsersTable(e.data);
});



