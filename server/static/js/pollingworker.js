function fetchUsersData() {
    let url = 'http://localhost:8080/users';

    fetch(url)
        .then(res => res.json())
        .then((out) => {
            //console.log('users data:', data)
            self.postMessage(out);
        })
        .catch(err => { throw err });
}

setInterval(function() {
    fetchUsersData();
}, 3000);