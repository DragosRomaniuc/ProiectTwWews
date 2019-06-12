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

    // GET Endpoint
    if (reqUrl.pathname == '/series' && req.method === 'POST') {
        console.log('Request Type:' +
            req.method + ' Endpoint: ' +
            reqUrl.pathname);

          

        service.addSeries(req, res);

        // POST Endpoint
    } else if (reqUrl.pathname == '/series' && req.method === 'GET') {
        console.log('Request Type:' +
            req.method + ' Endpoint: ' +
            reqUrl.pathname);

        service.getAllSeries(req, res);

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

    } else {
        console.log('Request Type:' +
            req.method + ' Invalid Endpoint: ' +
            reqUrl.pathname);

        service.invalidRequest(req, res);

    }
});