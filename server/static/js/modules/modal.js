import { buildUsersTable } from "./user.js";
import { $body, $generalModalContainer } from './utils.js';

export function showModal(data,el){
    el.innerHTML=buildUsersTable(data);
    $body.setAttribute('data-show-modal',true);
}

export function closeModal(e){
    let isModalContent = e.target.closest('.general_modal_container');
    if (isModalContent) return;
    $body.setAttribute('data-show-modal',false);
    $generalModalContainer.innerHTML="";
}