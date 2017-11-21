export class Connection {
    constructor(params = {}) {
        let {host = location.hostname, port = 8081} = params
        this.url = port ? `${host}:${port}` : host
        this.groupId = document.getElementById('group-id').textContent
        this.handlers = {
            message: [],
            error: [],
            close: [],
            open: []
        }

        this.conn = null
    }

    connect() {
        this.conn = new WebSocket(`ws://${this.url}`)

        this.conn.onopen = async event => {
            console.info(`Connected to ${this.url}`)
            let user = await axios.get('/user/auth-key')
            if (user.data.key) this.push({
                auth: user.data.key
            })
            this.handle('open', event)
        }

        this.conn.onclose = event => {
            console.info(`Connection ${this.url} closed`)
            this.handle('close', event)
        }

        this.conn.onerror = error => {
            console.log(event.message)
            this.handle('error', event)
        }

        this.conn.onmessage = event => {
            console.groupCollapsed('socket get data')
            console.info(JSON.parse(event.data))
            console.groupEnd()
            this.handle('message', event)
        }

        return this
    }

    handle(level, event) {
        if (this.handlers[level]) {
            this.handlers[level].forEach(handler => {
                try {
                    handler(event, event.data ? JSON.parse(event.data) : undefined, this.conn);
                } catch (e) {
                    console.log(e.message)
                }
            })
        }
    }

    on(event, callback) {
        if (this.handlers[event] && typeof callback === 'function') {
            this.handlers[event].push(callback)
        } else {
            throw new Error('Invalid params')
        }
        return this
    }

    push(data) {
        data.group_id = this.groupId
        data = JSON.stringify(data)

        console.groupCollapsed('socket push data')
        console.info(data)
        console.groupEnd()

        this.conn.send(data)
        return this
    }
}