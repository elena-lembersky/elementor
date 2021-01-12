export const $body = document.querySelector('body');
export const $logoutButton = document.querySelector('[data-action="logout"]');
export const $generalModal = document.querySelector('.general_modal');
export const $generalModalContainer = document.querySelector('[data-role="modal-container"]');
export const $usersTable = document.querySelector('.users_wrapper');
export const $usersTableWrapper = document.getElementById("users_table_wrapper");
export const $titleName = document.querySelector(".wellcome span");

export function dataHandler(data,callback){
    if(data.ok) {
        callback(data.ok);
    }
    else {
        console.error(data.err);
    }
}