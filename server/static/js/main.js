import { $usersTable, $generalModal, $logoutButton } from './modules/utils.js';
import { getUsers, getUserInfo, printUserName, userLogout } from './modules/user.js';
import { closeModal } from './modules/modal.js';

$usersTable.addEventListener("click", getUserInfo);
$generalModal.addEventListener("click", closeModal);
$logoutButton.addEventListener("click", userLogout);

getUsers();
printUserName();

