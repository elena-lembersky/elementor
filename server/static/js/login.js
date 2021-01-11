const $loginForm = document.getElementById('login_form');
const $loginFormErros = document.querySelector('[data-action="login-errors"]');
$loginForm.addEventListener('submit',logIn);


function logIn(e){
    e.preventDefault();
    const url = 'http://localhost:8080/login';
    const formData = new FormData(this);
    const plainFormData = Object.fromEntries(formData.entries());
    const formDataJsonString = JSON.stringify(plainFormData);

    console.log('formDataJsonString',formDataJsonString);

    fetch(url, {
        method: 'POST',
        body: formDataJsonString,
        headers: {
            'Content-Type': 'multipart/form-data',
            "Accept": "application/json"
        }
    })
        .then(res => {
            return res.json()
        })
        .then((out) => {
            console.log('post response ', out);
            const output = JSON.parse(out);
            if (output.ok) {
                location.reload();
            }
            else if (output.err) {
                $loginForm.reset()
                $loginFormErros.textContent = output.err;
            };
        })
        .catch(err => { throw err });
}
