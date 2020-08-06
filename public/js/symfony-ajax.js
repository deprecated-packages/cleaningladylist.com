async function connect(
    method = '',
    path = '',
    data = {},
    debug = false
) {

    function lol() {

    }

    // Default options are marked with *
    const request = await fetch(path, {
        method: method ?? "GET", // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data) // body data type must match "Content-Type" header
    });

    if (debug) {
        console.log(request);
    }

    return request.json(); // parses JSON response into native JavaScript objects
}

function handle() {

}
