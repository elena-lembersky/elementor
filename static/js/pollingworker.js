function fetchUsersData() {
    const url = '/users';

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