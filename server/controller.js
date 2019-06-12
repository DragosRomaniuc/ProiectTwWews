const http = require('http');
const url = require('url');
const mongoose = require('mongoose');
mongoose.Promise = global.Promise;
mongoose.connect('mongodb://localhost/testTw', { useNewUrlParser: true });
mongoose.connection.once('open', () => {
    console.log("Connection has been made, now make fireworks! :D");
}).on('error', err => {
    console.log("Connection error: ", err);
})

module.exports = http.createServer(async (req, res) => {

    var service = require('./service.js');
    const reqUrl = url.parse(req.url, true);
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
    // GET Endpoint
    if (reqUrl.pathname == '/setUserNews' && req.method === 'POST') {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
        console.log('Request Type:' +
            req.method + ' Endpoint: ' +
            reqUrl.pathname);
            
          

        service.setUserNews(req, res);

        // POST Endpoint
    } else if (reqUrl.pathname=="/getUserTopics" && req.method === 'POST') {
        // res.setHeader('Access-Control-Allow-Origin', '*');
        // res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
        console.log('Request Type:' +
            req.method + ' Endpoint: ' +
            reqUrl.pathname);

        service.getTopics(req, res);

    }else if (reqUrl.pathname.includes("searchid") && req.method === 'GET') {
        console.log('Request Type:' +
            req.method + ' Endpoint: ' +
            reqUrl.pathname);

        service.getSeries(req, res);

    }
    else if (reqUrl.pathname.includes("deleteid") && req.method === 'DELETE') {
        console.log('Request Type:' +
            req.method + ' Endpoint: ' +
            reqUrl.pathname);

        service.deleteSeries(req, res);

    }else if (req.method === 'OPTIONS') {
        console.log('Request Type:' +
            req.method + ' Endpoint: ' +
            reqUrl.pathname);

            res.setHeader('Access-Control-Allow-Origin', '*');
            res.setHeader('Access-Control-Allow-Headers', '*');
            res.setHeader('Access-Control-Request-Method', '*');
            res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
            res.writeHead(200);
		    res.end();

    } else {
        console.log('Request Type:' +
            req.method + ' Invalid Endpoint: ' +
            reqUrl.pathname);

        service.invalidRequest(req, res);

    }
});