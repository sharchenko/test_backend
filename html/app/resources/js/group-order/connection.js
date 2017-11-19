let url = `ws://${location.hostname}:8081`;
let connection = new WebSocket(url)

connection.message = message => connection.send(JSON.stringify(message))

connection.onopen = event => {
    console.log(`Connected to ${url}`)

    axios.get('/user/auth-key').then(res => {
        if (res.data.key) {
            connection.message({auth: res.data.key});
        }
    })
}

connection.onmessage = function (event) {
    console.log(event.data)
}

window.conn = connection

export {connection}