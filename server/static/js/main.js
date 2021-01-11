import { $usersTable, $generalModal, $logoutButton } from './modules/utils.js';
import { getUsers, getUserInfo, printUserName, userLogout } from './modules/user.js';
import { closeModal } from './modules/modal.js';

$usersTable.addEventListener("click", getUserInfo);
$generalModal.addEventListener("click", closeModal);
$logoutButton.addEventListener("click", userLogout);

getUsers();
printUserName();

///////// TODO add socket or worker here /////////
const intervalID = setInterval(function (){
    setTimeout(getUsers,0);
},3000);

//clear interval if user leaved browser
setTimeout(function (){
    clearInterval(intervalID);
    alert("Please refresh your Browser to Continue");
}, 3 * 60 * 1000);

////////////////////////////////////////////////////



